<?php

namespace Dime\TimetrackerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller,
    Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use FOS\RestBundle\View\View AS FOSView;

class DimeController extends Controller
{
    protected $currentUser = null;

    protected function createView($data = null, $statuscode = 200)
    {
        $view = new FOSView($data, $statuscode);

        return $view;
    }

    protected function getCurrentUser() {
        if (!$this->currentUser) {
            $this->currentUser = $this->getDoctrine()->getRepository('DimeTimetrackerBundle:User')->findOneByEmail('johndoe@example.com');
        }

        return $this->currentUser;
    }

    /**
     * save form
     *
     * @param Form  $form
     * @param array $data
     *
     * @return FOS\RestBundle\View\View
     */
    protected function saveForm($form, $data)
    {
        // clean array from non existing keys to avoid extra data 
        foreach ($data as $key => $value) {
            if (!$form->has($key)) {
                unset($data[$key]);
            }
        }

        // bind data to form
        $form->bind($data);
        
        if ($form->isValid()) {
            
            $em = $this->getDoctrine()->getEntityManager();

            $entity = $form->getData();

            /** @todo: set user */
            $user = $em->getRepository('DimeTimetrackerBundle:User')->findOneByEmail('johndoe@example.com');

            if (is_object($entity) && method_exists($entity, 'setUser')) {
                $entity->setUser($user);
            }

            // save change to database
            $em->persist($entity);
            $em->flush();
            $em->refresh($entity);

            // push back the new object
            $view = $this->createView($entity, 200);
        } else {
            // return error string from form
            $view = $this->createView(array('error' => $form->getErrorsAsString()), 400);
        }
        
        return $view;
    }
}
