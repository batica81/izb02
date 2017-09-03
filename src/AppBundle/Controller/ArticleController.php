<?php
/**
 * Created by PhpStorm.
 * User: voja
 * Date: 31.8.17.
 * Time: 12.01
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\TestUser;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Symfony\Component\Validator\Constraints\DateTime;

class ArticleController extends FOSRestController
{
    /**
     * @Rest\Get("/api/article")
     */
    public function getAllArticles()
    {
        $restresult = $this->getDoctrine()->getRepository('AppBundle:Article')->findBy(array(), array('datetime' => 'DESC'));
        if ($restresult === null) {
            return new View("there are no users exist", Response::HTTP_NOT_FOUND);
        }
        return $restresult;
    }

    /**
     * @Rest\Get("/api/article/{id}")
     */
    public function getArticle($id)
    {
        $singleresult = $this->getDoctrine()->getRepository('AppBundle:Article')->find($id);
        if ($singleresult === null) {
            return new View("Article not found", Response::HTTP_NOT_FOUND);
        }
        return $singleresult;
    }

    /**
     * @Rest\Post("/api/article")
     */
    public function postArticle(Request $request)
    {
        $data = new Article;
        $title = $request->get('title');
        $body = $request->get('body');
        $datetime = $request->get('datetime');
        $poster = $request->get('poster');
        if(empty($title) || empty($body))
        {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }
        if(empty($poster))
        {
            return new View("Unathorized", Response::HTTP_FORBIDDEN);
        }
        $data->setBody($body);
        $data->setTitle($title);
        $date = new \DateTime();
        $data->setDatetime($date);
        $data->setPoster($this->getDoctrine()->getRepository('AppBundle:User')->find($poster));
        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();
        return new View("Article Added Successfully", Response::HTTP_OK);
    }

    /**
     * @Rest\Put("/api/article/{id}")
     */
    public function updateArticle($id,Request $request)
    {
        $data = new Article();
        $title = $request->get('title');
        $body = $request->get('body');
        $poster = $request->get('poster');
        $sn = $this->getDoctrine()->getManager();
        $article = $this->getDoctrine()->getRepository('AppBundle:Article')->find($id);

        if (empty($article)) {
            return new View("Article not found", Response::HTTP_NOT_FOUND);
        } else {
            $originalPosterId = $article->getPoster()->getId();
        }
        if(empty($poster) || ($poster != $originalPosterId)) {
            return new View("Unathorized", Response::HTTP_FORBIDDEN);
        }

        if(!empty($title) && !empty($body)){
            $article->setTitle($title);
            $article->setBody($body);
            $sn->flush();
            return new View("Article Updated Successfully", Response::HTTP_OK);
        }
        else return new View("Article title or body cannot be empty", Response::HTTP_NOT_ACCEPTABLE);
    }
    /**
     * @Rest\Delete("/api/article/{id}")
     */
    public function deleteArticle($id)
    {
        $data = new Article;
        $sn = $this->getDoctrine()->getManager();
        $poster = 1;
        $article = $this->getDoctrine()->getRepository('AppBundle:Article')->find($id);
        if (empty($article)) {
            return new View("Article not found", Response::HTTP_NOT_FOUND);
        } else {
            $originalPosterId = $article->getPoster()->getId();
        }

        if (empty($poster) || ($poster != $originalPosterId)) {
            return new View("Unathorized", Response::HTTP_FORBIDDEN);
        } else {
            $sn->remove($article);
            $sn->flush();
        }
        return new View("Article deleted successfully", Response::HTTP_OK);
    }

}