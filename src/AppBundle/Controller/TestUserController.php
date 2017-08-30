<?php
/**
 * Created by PhpStorm.
 * User: Voja
 * Date: 29-Aug-17
 * Time: 23:46
 */

namespace AppBundle\Controller;

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


class TestUserController extends FOSRestController
{
    /**
     * @Rest\Get("/api/user")
     */
    public function getAction()
    {
        $restresult = $this->getDoctrine()->getRepository('AppBundle:TestUser')->findAll();
        if ($restresult === null) {
            return new View("there are no users exist", Response::HTTP_NOT_FOUND);
        }
        return $restresult;
    }

    /**
     * @Rest\Get("/api/user/{id}")
     */
    public function idAction($id)
    {
        $singleresult = $this->getDoctrine()->getRepository('AppBundle:TestUser')->find($id);
        if ($singleresult === null) {
            return new View("user not found", Response::HTTP_NOT_FOUND);
        }
        return $singleresult;
    }

    /**
     * @Rest\Post("/api/user")
     */
    public function postAction(Request $request)
    {
        $data = new TestUser;
        $name = $request->get('name');
        $role = $request->get('role');
        if(empty($name) || empty($role))
        {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }
        $data->setName($name);
        $data->setRole($role);
        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();
        return new View("User Added Successfully", Response::HTTP_OK);
    }

    /**
     * @Rest\Put("/api/user/{id}")
     */
    public function updateAction($id,Request $request)
    {
        $data = new TestUser;
        $name = $request->get('name');
        $role = $request->get('role');
        $sn = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository('AppBundle:TestUser')->find($id);
        if (empty($user)) {
            return new View("user not found", Response::HTTP_NOT_FOUND);
        }
        elseif(!empty($name) && !empty($role)){
            $user->setName($name);
            $user->setRole($role);
            $sn->flush();
            return new View("User Updated Successfully", Response::HTTP_OK);
        }
        elseif(empty($name) && !empty($role)){
            $user->setRole($role);
            $sn->flush();
            return new View("role Updated Successfully", Response::HTTP_OK);
        }
        elseif(!empty($name) && empty($role)){
            $user->setName($name);
            $sn->flush();
            return new View("User Name Updated Successfully", Response::HTTP_OK);
        }
        else return new View("User name or role cannot be empty", Response::HTTP_NOT_ACCEPTABLE);
    }

    /**
     * @Rest\Delete("/api/user/{id}")
     */
    public function deleteAction($id)
    {
        $data = new TestUser;
        $sn = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository('AppBundle:TestUser')->find($id);
        if (empty($user)) {
            return new View("user not found", Response::HTTP_NOT_FOUND);
        }
        else {
            $sn->remove($user);
            $sn->flush();
        }
        return new View("deleted successfully", Response::HTTP_OK);
    }
}

