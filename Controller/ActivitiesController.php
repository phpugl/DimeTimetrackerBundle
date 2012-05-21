<?php

namespace Dime\TimetrackerBundle\Controller;

use Dime\TimetrackerBundle\Entity\Activity,
    Dime\TimetrackerBundle\Entity\Timeslice,
    Dime\TimetrackerBundle\Form\ActivityType;

class ActivitiesController extends DimeController
{
    /**
     * get activity repository
     *
     * @return Dime\TimetrackerBundle\Entity\ActivityRepository
     */
    protected function getActivityRepository()
    {
        return $this->getDoctrine()->getRepository('DimeTimetrackerBundle:Activity');
    }

    /**
     * get activity repository
     *
     * @return Dime\TimetrackerBundle\Entity\CustomerRepository
     */
    protected function getCustomerRepository()
    {
        return $this->getDoctrine()->getRepository('DimeTimetrackerBundle:Customer');
    }

    /**
     * get activity repository
     *
     * @return Dime\TimetrackerBundle\Entity\ProjectRepository
     */
    protected function getProjectRepository()
    {
        return $this->getDoctrine()->getRepository('DimeTimetrackerBundle:Project');
    }

    /**
     * get activity repository
     *
     * @return Dime\TimetrackerBundle\Entity\ServiceRepository
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
     * @return FOS\RestBundle\View\View
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
     * @param int $id
     * @return FOS\RestBundle\View\View
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
     * @return FOS\RestBundle\View\View
     */
    public function postActivitiesAction()
    {
        // create new activity entity
        $activity = new Activity();

        // convert json to assoc array from request content
        $data = json_decode($this->getRequest()->getContent(), true);

        if (isset($data['parse'])) {
            // Run parser
            $content = $data['parse'];
            $results = array();
            $parsers = array(
                '\Dime\TimetrackerBundle\Parser\TimeRange',
                '\Dime\TimetrackerBundle\Parser\Duration',
                '\Dime\TimetrackerBundle\Parser\ActivityRelation',
                '\Dime\TimetrackerBundle\Parser\ActivityDescription'
            );

            foreach ($parsers as $parser) {
              $p = new $parser();
              $results = $p->setResult($results)->run($content);
              $content = $p->clean($content);
              unset($p);
            }

            // create new activity and timeslice entity
            $activity = new Activity();
            $activity->setUser($this->getCurrentUser());

            if (isset($results['customer'])) {
                $customer = $this->getCustomerRepository()->findOneByAlias($results['customer']);
                $activity->setCustomer($customer);
            }

            if (isset($results['project'])) {
                $project = $this->getProjectRepository()->findOneByName($results['project']);
                $activity->setProject($project);
            }

            if (isset($results['service'])) {
                $service = $this->getServiceRepository()->findOneByName($results['service']);
                $activity->setService($service);
            }

            if (isset($results['description'])) {
                $activity->setDescription($results['description']);
            }

            // create timeslice
            if (isset($results['range']) || isset($results['duration'])) {
                $timeslice = new Timeslice();

                if (isset($results['range'])) {
                    $range = $results['range'];
                    if (empty($range['stop'])) {
                        $timeslice->setStartedAt(new \DateTime($range['start']));
                        $timeslice->setStoppedAt(new \DateTime('now'));
                    } else if (empty($range['start'])) {
                        $timeslice->setStartedAt(new \DateTime('now'));
                        $timeslice->setStoppedAt(new \DateTime($range['stop']));
                    } else if (!empty($range['start']) && !empty($range['stop'])) {
                        $timeslice->setStartedAt(new \DateTime($range['start']));
                        $timeslice->setStoppedAt(new \DateTime($range['stop']));
                    }
                }

                if (empty($results['duration']['sign'])) {
                    $timeslice->setDuration($results['duration']['number']);
                } else {
                    if ($results['duration']['sign'] == '-') {
                        $timeslice->setDuration($timeslice->getCurrentDuration() - $results['duration']['number']);
                    } else {
                        $timeslice->setDuration($timeslice->getCurrentDuration() + $results['duration']['number']);
                    }
                }

                $timeslice->setActivity($activity);
                $activity->addTimeslice($timeslice);
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
     * @param string $id
     * @return FOS\RestBundle\View\View
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
     * @param int $id
     * @return FOS\RestBundle\View\View
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
}
