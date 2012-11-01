<?php

namespace Dime\TimetrackerBundle\Controller;

use Dime\TimetrackerBundle\Entity\Tag;
use Dime\TimetrackerBundle\Entity\TagRepository;
use FOS\RestBundle\View\View;

class TagsController extends DimeController
{
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
     * get a list of all tags
     *
     * [GET] /tags
     *
     * @return View
     */
    public function getTagsAction()
    {
        $tags = $this->getTagRepository();

        $qb = $tags->createQueryBuilder('x');

        // Pagination
        return $this->paginate($qb,
            $this->getRequest()->get('limit'),
            $this->getRequest()->get('offset')
        );
    }

    /**
     * get a tag by its id
     *
     * [GET] /tags/{id}
     *
     * @param  int  $id
     * @return View
     */
    public function getTagAction($id)
    {
        // find tag
        $tag = $this->getTagRepository()->find($id);

        // check if it exists
        if ($tag) {
            // send array
            $view = $this->createView($tag);
        } else {
            // send 404, if tag does not exist
            $view = $this->createView("Tag does not exist.", 404);
        }

        return $view;
    }

    /**
     * delete a tag by its id
     * [DELETE] /tags/{id}
     *
     * @param  int  $id
     * @return View
     */
    public function deleteTagAction($id)
    {
        // find tag
        $tag = $this->getTagRepository()->find($id);

        // check if it exists
        if ($tag) {
            // remove service
            $em = $this->getDoctrine()->getManager();
            $em->remove($tag);
            $em->flush();

            // send status message
            $view = $this->createView("Tag has been removed.");
        } else {
            // send 404, if tag does not exist
            $view = $this->createView("Tag does not exist.", 404);
        }

        return $view;
    }
}
