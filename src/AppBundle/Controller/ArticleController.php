<?php
/**
 * Created by PhpStorm.
 * User: voja
 * Date: 31.8.17.
 * Time: 12.01
 */

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Entity\Comment;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;


/**
 * Class ArticleController
 * @package AppBundle\Controller
 */
class ArticleController extends FOSRestController
{
    /**
     * @Rest\Get("/api/article")
     *
     */
    public function getAllArticles()
    {
        $restresult = $this->getDoctrine()->getRepository('AppBundle:Article')->findBy(array(), array('datetime' => 'DESC'));
        if ($restresult === null) {
            return new View("There are no articles to show", Response::HTTP_NOT_FOUND);
        }
        return $restresult;
    }

    /**
     * @Rest\Get("/api/article/{id}")
     * @param int $id
     * @return Article|View|null|object
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
     * @param Request $request
     * @return View
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
     * @Rest\Put("/api/article")
     * @param Request $request
     * @return View
     */
    public function updateArticle(Request $request)
    {
        $data = new Article();
        $title = $request->get('title');
        $body = $request->get('body');
        $poster = $request->get('poster');
        $articleId = $request->get('id');
        $sn = $this->getDoctrine()->getManager();
        $article = $this->getDoctrine()->getRepository('AppBundle:Article')->find($articleId);

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
     * @param int $id
     * @return View
     */
    public function deleteArticle($id)
    {
        $data = new Article;
        $sn = $this->getDoctrine()->getManager();
//        $poster = 1; - temporary workaraound
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

//    COMMENTS

    /**
     * @Rest\Get("/api/article/{id}/comment")
     * @param int $id
     * @return View
     */
    public function getArticleComments($id)
    {
        $singleresult = $this->getDoctrine()->getRepository('AppBundle:Article')->find($id)->getComments();
        if ($singleresult === null) {
            return new View("Article not found", Response::HTTP_NOT_FOUND);
        }
        return $singleresult;
    }

    /**
     * @Rest\Delete("/api/article/{aid}/comment/{cid}")
     * @param int $aid
     * @param int $cid
     * @return View
     */
    public function deleteArticleComment($aid, $cid)
    {
        $data = new Article;
        $sn = $this->getDoctrine()->getManager();
        $poster = 1;
        $comment = $this->getDoctrine()->getRepository('AppBundle:Comment')->find($cid);
        if (empty($comment)) {
            return new View("Comment not found", Response::HTTP_NOT_FOUND);
        } else {
            $originalPosterId = $comment->getPoster()->getId();
        }

        if (empty($poster) || ($poster != $originalPosterId)) {
            return new View("Unathorized", Response::HTTP_FORBIDDEN);
        } else {
            $sn->remove($comment);
            $sn->flush();
        }
        return new View("Comment deleted successfully", Response::HTTP_OK);
    }

    /**
     * @Rest\Post("/api/article/{aid}/comment")
     * @param int $aid
     * @param Request $request
     * @return Comment|View|null|object
     */
    public function postComment($aid, Request $request)
    {
        $data = new Comment;
        $title = $request->get('title');
        $body = $request->get('body');
        $datetime = $request->get('datetime');
//        $poster = $request->get('poster');
        $poster = 1;
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
        $data->setArticle($this->getDoctrine()->getRepository('AppBundle:Article')->find($aid));
        $date = new \DateTime();
        $data->setDatetime($date);
        $data->setPoster($this->getDoctrine()->getRepository('AppBundle:User')->find($poster));
        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();
        return new View("Comment Added Successfully", Response::HTTP_OK);
    }

    /**
     * @Rest\Put("/api/article/{aid}/comment")
     * @param int $aid
     * @param Request $request
     * @return View
     */
    public function updateComment($aid, Request $request)
    {
        $title = $request->get('title');
        $body = $request->get('body');
        $poster = $request->get('poster');
        $cid = $request->get('id');
        $sn = $this->getDoctrine()->getManager();
        $comment = $this->getDoctrine()->getRepository('AppBundle:Comment')->find($cid);

        if (empty($comment)) {
            return new View("Comment not found", Response::HTTP_NOT_FOUND);
        } else {
            $originalPosterId = $comment->getPoster()->getId();
        }
        if(empty($poster) || ($poster != $originalPosterId)) {
            return new View("Unathorized", Response::HTTP_FORBIDDEN);
        }

        if(!empty($title) && !empty($body)){
            $comment->setTitle($title);
            $comment->setBody($body);
            $sn->flush();
            return new View("Comment Updated Successfully", Response::HTTP_OK);
        }
        else return new View("Comment title or body cannot be empty", Response::HTTP_NOT_ACCEPTABLE);
    }
}

//        TODO: poster authorization
