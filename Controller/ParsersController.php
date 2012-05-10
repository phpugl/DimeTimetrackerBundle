<?php

namespace Dime\TimetrackerBundle\Controller;

use Dime\TimetrackerBundle\Entity\Activity,
    Dime\TimetrackerBundle\Form\ActivityType,
    Dime\TimetrackerBundle\Entity\Timeslice,
    Dime\TimetrackerBundle\Form\TimesliceType;

class ParsersController extends DimeController
{
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
     * parse the incoming text and create entity
     * [POST] /parser
     *
     * @return FOS\RestBundle\View\View
     */
    public function postProcessAction()
    {
        $content = $this->getRequest()->getContent();



        // Run parser
        $results = array();
        $matches = array();
        
        // time range 10:00-12:00, 10-12, 10:00- , -12:00
        if (preg_match('/((?P<start>\d+(:\d+)?)?(\s+)?-(\s+)?(?P<stop>\d+(:\d+)?)?)/', $content, $matches)) {
            $results['range'] = array(
                'start' => $matches['start'],
                'stop' => $matches['stop']
            );
            $content = trim(str_replace($matches[1], '', $content));
        }

        // time duration [+-]02:30:15 or [+-]2h 30m 15s
        if (preg_match('/(?P<sign>[+-])?(?P<duration>(\d+((:\d+)?(:\d+)?)?[hms]?(\s+)?(\d+[ms])?(\s+)?(\d+[s])?)?)/', $content, $matches)) {
            $duration = 0;
            if (preg_match_all('/(\d+)([hms])/', $matches['duration'], $items)) {
                foreach ($items[2] as $key => $unit) {
                    switch ($unit) {
                        case 'h':
                            $duration += $items[1][$key]*3600;
                        break;
                        case 'm':
                            $duration += $items[1][$key]*60;
                        break;
                        case 's':
                            $duration += $items[1][$key];
                        break;
                    }
                }
            } else {
                $time = explode(':', $matches['duration']);
                if (isset($time[0])) {
                    $duration += $time[0]*3600;
                }
                if (isset($time[1])) {
                    $duration += $time[1]*60;
                }
                if (isset($time[2])) {
                    $duration += $time[2];
                }
            }

            $results['duration'] = array(
                'sign' => $matches['sign'],
                'number' => $duration
            );
            $content = trim(str_replace($matches[0], '', $content));
        }

        // customer - project - serive (@ / :)
        if (preg_match_all('/([@:\/])(\w+)/', $content, $matches)) {
            foreach ($matches[1] as $key => $token) {
                switch($token) {
                    case '@':
                        $results['customer'] = $matches[2][$key];
                    break;
                    case ':':
                        $results['service'] = $matches[2][$key];
                    break;
                    case '/':
                        $results['project'] = $matches[2][$key];
                    break;
                }
            }

            foreach ($matches[0] as $token) {
                $content = trim(str_replace($token, '', $content));
            }
        }

        $results['description'] = $content;

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

        if (isset($results['project'])) {
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
       
        return $this->createView($activity);
    }
}