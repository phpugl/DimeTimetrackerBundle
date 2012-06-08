<?php

namespace Dime\TimetrackerBundle\Controller;

use Dime\TimetrackerBundle\Entity\Activity;
use Dime\TimetrackerBundle\Entity\ActivityRepository;
use Dime\TimetrackerBundle\Entity\Timeslice;
use Dime\TimetrackerBundle\Entity\ProjectRepository;
use Dime\TimetrackerBundle\Entity\ServiceRepository;
use Dime\TimetrackerBundle\Form\ActivityType;
use FOS\RestBundle\View\View;

class ActivitiesController extends DimeController
{
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
     * get activity repository
     *
     * @return
     */
    protected function getCustomerRepository()
    {
        return $this->getDoctrine()->getRepository('DimeTimetrackerBundle:Customer');
    }

    /**
     * get activity repository
     *
     * @return ProjectRepository
     */
    protected function getProjectRepository()
    {
        return $this->getDoctrine()->getRepository('DimeTimetrackerBundle:Project');
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
     * @return View
     */
    public function getActivitiesAction()
    {
        $activities = $this->getActivityRepository();

        return $this->createView($activities->findAll());
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
    public function postActivitiesAction()
    {
        // create new activity entity
        $activity = new Activity();

        // convert json to assoc array from request content
        $data = json_decode($this->getRequest()->getContent(), true);

        if (isset($data['parse'])) {
            // Run parser
            $result = $this->parse($data['parse']);

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
                        $timeslice->setStartedAt(new \DateTime($range['start']));
                        $timeslice->setStoppedAt(new \DateTime('now'));
                    } elseif (empty($range['start'])) {
                        $timeslice->setStartedAt(new \DateTime('now'));
                        $timeslice->setStoppedAt(new \DateTime($range['stop']));
                    } elseif (!empty($range['start']) && !empty($range['stop'])) {
                        $timeslice->setStartedAt(new \DateTime($range['start']));
                        $timeslice->setStoppedAt(new \DateTime($range['stop']));
                    }
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
            // create form, decode request and save it if valid
            $view = $this->saveForm(
                $this->createForm(new ActivityType(), $activity),
                json_decode($this->getRequest()->getContent(), true)
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
