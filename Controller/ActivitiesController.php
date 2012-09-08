<?php

namespace Dime\TimetrackerBundle\Controller;

use FOS\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations\Route;

use Dime\TimetrackerBundle\Entity\Activity;
use Dime\TimetrackerBundle\Entity\ActivityRepository;
use Dime\TimetrackerBundle\Entity\Timeslice;
use Dime\TimetrackerBundle\Entity\CustomerRepository;
use Dime\TimetrackerBundle\Entity\ProjectRepository;
use Dime\TimetrackerBundle\Entity\ServiceRepository;
use Dime\TimetrackerBundle\Entity\TagRepository;
use Dime\TimetrackerBundle\Form\ActivityType;

class ActivitiesController extends DimeController
{
    /**
     * @var array allowed filter keys
     */
    protected $allowed_filter = array('date', 'active', 'customer', 'project', 'service', 'user');

    /**
     * get activity repository
     *
     * @return ActivityRepository
     */
    protected function getActivityRepository()
    {
        return $this->getDoctrine()->getRepository('DimeTimetrackerBundle:Activity');
    }

    /**
     * get customer repository
     *
     * @return CustomerRepository
     */
    protected function getCustomerRepository()
    {
        return $this->getDoctrine()->getRepository('DimeTimetrackerBundle:Customer');
    }

    /**
     * get project repository
     *
     * @return ProjectRepository
     */
    protected function getProjectRepository()
    {
        return $this->getDoctrine()->getRepository('DimeTimetrackerBundle:Project');
    }

    /**
     * get tag repository
     *
     * @return TagRepository
     */
    protected function getTagRepository()
    {
        return $this->getDoctrine()->getRepository('DimeTimetrackerBundle:Tag');
    }

    /**
     * get activity repository
     *
     * @return ServiceRepository
     */
    protected function getServiceRepository()
    {
        return $this->getDoctrine()->getRepository('DimeTimetrackerBundle:Service');
    }

    /**
     * get a list of all activities
     *
     * [GET] /activities
     *
     * @Route("/activities")
     * @return View
     */
    public function getActivitiesAction()
    {
        $activities = $this->getActivityRepository();

        $qb = $activities->createQueryBuilder('a');

        // Filter
        $filter = $this->getRequest()->get('filter');
        if ($filter) {
            $qb = $activities->filter($this->cleanFilter($filter, $this->allowed_filter), $qb);
        }

        // Scope by current user
        if (!isset($filter['user'])) {
            $activities->scopeByField('user', $this->getCurrentUser()->getId(), $qb);
        }

        // Sort by updatedAt and id
        $qb->addOrderBy('a.updatedAt', 'DESC');
        $qb->addOrderBy('a.id', 'DESC');

        // Pagination
        return $this->paginate($qb,
            $this->getRequest()->get('limit'),
            $this->getRequest()->get('offset')
        );
    }

    /**
     * get an activity by its id
     *
     * [GET] /activities/{id}
     *
     * @param  int  $id
     * @return View
     */
    public function getActivityAction($id)
    {
        // find activity
        $activity = $this->getActivityRepository()->find($id);

        // check if it exists
        if ($activity) {
            // send array
            $view = $this->createView($activity);
        } else {
            // activity does not exists send 404
            $view = $this->createView("Activity does not exist.", 404);
        }

        return $view;
    }

    /**
     * create a new activity
     *
     * [POST] /activities
     *
     * @return View
     */
    public function postActivityAction()
    {
        // create new activity entity
        $activity = new Activity();

        // convert json to assoc array from request content
        $data = $this->handleTagsInput(json_decode($this->getRequest()->getContent(), true));

        if (isset($data['parse'])) {
            // Run parser
            $result = $this->parse($data['parse']);
            if (isset($data['date'])) {
                $date = new \DateTime($data['date']);
            } else {
                $date = new \DateTime();
            }

            // create new activity and timeslice entity
            $activity = new Activity();
            $activity->setUser($this->getCurrentUser());

            if (isset($result['customer'])) {
                $customer = $this->getCustomerRepository()->findOneByAlias($result['customer']);
                $activity->setCustomer($customer);
            }

            if (isset($result['project'])) {
                $project = $this->getProjectRepository()->findOneByAlias($result['project']);
                $activity->setProject($project);
                // Auto set customer because of direct relation to project
                if ($activity->getCustomer()  == null) {
                    $activity->setCustomer($project->getCustomer());
                }
            }

            if (isset($result['service'])) {
                $service = $this->getServiceRepository()->findOneByAlias($result['service']);
                $activity->setService($service);
            }

            if (isset($result['description'])) {
                $activity->setDescription($result['description']);
            }

            // create timeslice
            $timeslice = new Timeslice();
            $timeslice->setActivity($activity);
            $activity->addTimeslice($timeslice);
            if (isset($result['range']) || isset($result['duration'])) {
                // process time range
                if (isset($result['range'])) {
                    $range = $result['range'];

                    if (empty($range['stop'])) {
                        $start = new \DateTime($range['start']);
                        $stop = new \DateTime('now');
                    } elseif (empty($range['start'])) {
                        $start = new \DateTime('now');
                        $stop = new \DateTime($range['stop']);
                    } elseif (!empty($range['start']) && !empty($range['stop'])) {
                        $start = new \DateTime($range['start']);
                        $stop = new \DateTime($range['stop']);
                    }
                    $start->setDate($date->format('Y'), $date->format('m'), $date->format('d'));
                    $stop->setDate($date->format('Y'), $date->format('m'), $date->format('d'));

                    $timeslice->setStartedAt($start);
                    $timeslice->setStoppedAt($stop);
                } else {
                    // track date for duration
                    $date->setTime(0,0,0);
                    $timeslice->setStartedAt($date);
                    $timeslice->setStoppedAt($date);
                }

                // process duration
                if (isset($result['duration'])) {
                  if (empty($result['duration']['sign'])) {
                      $timeslice->setDuration($result['duration']['number']);
                  } else {
                      if ($result['duration']['sign'] == '-') {
                          $timeslice->setDuration($timeslice->getCurrentDuration() - $result['duration']['number']);
                      } else {
                          $timeslice->setDuration($timeslice->getCurrentDuration() + $result['duration']['number']);
                      }
                  }
                }
            } else {
                // start a new timeslice with date 'now'
                $timeslice->setStartedAt(new \DateTime('now'));
            }

            // save change to database
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($activity);
            $em->flush();
            $em->refresh($activity);

            $view = $this->createView($activity);
        } else {
            // create activity form
            $form = $this->createForm(new ActivityType(), $activity);
            $view = $this->saveForm($form, $data);
        }

        return $view;
    }

    /**
     * modify an activity by its id
     *
     * [PUT] /activities/{id}
     *
     * @param  string $id
     * @return View
     */
    public function putActivityAction($id)
    {
        // find activity
        $activity = $this->getActivityRepository()->find($id);

        // check if it exists
        if ($activity) {
            $data = $this->handleTagsInput(json_decode($this->getRequest()->getContent(), true));

            // create form, decode request and save it if valid
            $view = $this->saveForm(
                $this->createForm(new ActivityType(), $activity),
                $data
            );
        } else {
            // activity does not exists send 404
            $view = $this->createView("Activity does not exist.", 404);
        }

        return $view;
    }

    /**
     * delete an activity by its id
     * [DELETE] /activities/{id}
     *
     * @param  int  $id
     * @return View
     */
    public function deleteActivityAction($id)
    {
        // find activity
        $activity = $this->getActivityRepository()->find($id);

        // check if it exists
        if ($activity) {
            // remove service
            $em = $this->getDoctrine()->getEntityManager();
            $em->remove($activity);
            $em->flush();

            // send status message
            $view = $this->createView("Activity has been removed.");
        } else {
            // activity does not exists send 404
            $view = $this->createView("Activity does not exist.", 404);
        }

        return $view;
    }

    /**
     * Parse data and create an array output
     * @param  string $data
     * @return array
     */
    protected function parse($data)
    {
      $result = array();
      $parsers = array(
          '\Dime\TimetrackerBundle\Parser\TimeRange',
          '\Dime\TimetrackerBundle\Parser\Duration',
          '\Dime\TimetrackerBundle\Parser\ActivityRelation',
          '\Dime\TimetrackerBundle\Parser\ActivityDescription'
      );

      foreach ($parsers as $parser) {
        $p = new $parser();
        $result = $p->setResult($result)->run($data);
        $data = $p->clean($data);
        unset($p);
      }

      return $result;
    }
}
