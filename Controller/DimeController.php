<?php

namespace Dime\TimetrackerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use FOS\RestBundle\View\View;
use Doctrine\ORM\Tools\Pagination\Paginator;

class DimeController extends Controller
{
    protected $currentUser = null;

    protected function createView($data = null, $statuscode = 200)
    {
        $view = new View($data, $statuscode);

        return $view;
    }

    protected function paginate(\Doctrine\ORM\QueryBuilder $qb, $limit = null, $offset = null)
    {
        if (!$limit) {
            $limit = $this->container->getParameter('dime_timetracker.pagination.limit');
        }

        if (!$offset) {
            $offset = $this->container->getParameter('dime_timetracker.pagination.offset');
        }

        $qb->setFirstResult($offset)
            ->setMaxResults($limit);

        $paginator = new Paginator($qb, $fetchJoinCollection = true);

        $view = $this->createView($paginator);
        $view->setHeader('X-Pagination-Total-Results', count($paginator));

        return $view;
    }

    protected function getCurrentUser()
    {
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
     * @return View
     */
    protected function saveForm(Form $form, $data)
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
            $errors = array();

            $text = '';
            foreach ($form->getErrors() as $error) {
              if (!empty($text)) $text .= "\n";
              $text .= $error->getMessage();
            }

            if (!empty($text)) {
              $errors['global'] = $text;
            }

            foreach ($form as $child) {
              if ($child->hasErrors()) {
                $text = '';
                foreach ($child->getErrors() as $error) {
                  if (!empty($text)) $text .= "\n";
                  $text .= $error->getMessage();
                }

                $errors[$child->getName()] = $text;
              }
            }
            // return error string from form
            $view = $this->createView(array('errors' => $errors), 400);
        }

        return $view;
    }
}
