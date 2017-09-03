<?php
/**
 * Created by PhpStorm.
 * User: Voja
 * Date: 03-Sep-17
 * Time: 18:02
 */

namespace AppBundle\Controller;


use FOS\RestBundle\Controller\FOSRestController;
use AppBundle\Entity\Article;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\TestUser;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\Validator\Constraints\DateTime;

class CommentController extends FOSRestController
{
    /**
     * @Rest\Get("/api/comment")
     */
    public function getAllComments()
    {
        $restresult = $this->getDoctrine()->getRepository('AppBundle:Comment')->findAll();
        if ($restresult === null) {
            return new View("There are no comments", Response::HTTP_NOT_FOUND);
        }
        return $restresult;
    }

    /**
     * @Rest\Get("/api/comment/{id}")
     */
    public function getComment($id)
    {
        $singleresult = $this->getDoctrine()->getRepository('AppBundle:Comment')->find($id);
        if ($singleresult === null) {
            return new View("Comment not found", Response::HTTP_NOT_FOUND);
        }
        return $singleresult;
    }


}