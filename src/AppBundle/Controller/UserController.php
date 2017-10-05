<?php
/**
 * Created by PhpStorm.
 * User: voja
 * Date: 31.8.17.
 * Time: 15.53
 */

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\User;
use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;

class UserController extends FOSRestController
{



    /**
     * @Rest\Get("/api/user")
     */
    public function showUser()
    {

        if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) )
{
    $user = $this->container->get('security.token_storage')->getToken()->getUser();
    $temp_id = $user->getId();
}
        $singleresult = $this->getDoctrine()->getRepository('AppBundle:User')->find($temp_id);
        if ($singleresult === null) {
            return new View("User not found", Response::HTTP_NOT_FOUND);
        }
        return $singleresult;
    }

    /**
     * @Rest\Post("/api/user")
     */
    public function createUser(Request $request)
    {
        $data = new User;
        $email = $request->get('email');
        $firstName = $request->get('firstName');
        $lastName = $request->get('lastName');
        $password = $request->get('pass');
        if(empty($firstName) || empty($lastName) || empty($email) || empty($password))
        {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }
        $data->setEmail($email);
        $data->setFirstName($firstName);
        $data->setLastName($lastName);
        $data->setPassword($password);
//        prepraviti algoritam
        $data->setHashedPassword(md5($password));
        $em = $this->getDoctrine()->getManager();
        $em->persist($data);
        $em->flush();
        return new View("User Added Successfully", Response::HTTP_OK);
    }

    /**
     * @Rest\Put("/api/user/changepass")
     */
    public function updatePassword(Request $request)
    {
//        TODO: Popraviti kada proradi hashing
        $data = new User;
        $oldpass = $request->get('oldpass');
        $newpass = $request->get('newpass');
        
                       if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) )
{
    $user = $this->container->get('security.token_storage')->getToken()->getUser();
    $id = $user->getId();
}

        $sn = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);
        $currentPass = $user->getHashedPassword();
        $oldHashedPass = $oldpass;
        if (empty($user)) {
            return new View("User not found", Response::HTTP_NOT_FOUND);
        }
        elseif(!empty($oldpass) && !empty($newpass) && ($oldHashedPass != $currentPass)){
            $user->setPassword($newpass);
            $sn->flush();
            return new View("Password updated Successfully", Response::HTTP_OK);
        }
        else return new View("Error changing password", Response::HTTP_NOT_ACCEPTABLE);
    }

    /**
     * @Rest\Put("/api/user")
     */
    public function updateUserDetails(Request $request)
    {
        $data = new User;
        $firstName = $request->get('firstName');
        $lastName = $request->get('lastName');
                       if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) )
{
    $user = $this->container->get('security.token_storage')->getToken()->getUser();
    $id = $user->getId();
}
        $sn = $this->getDoctrine()->getManager();
        $user = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);
        if (empty($user)) {
            return new View("User not found", Response::HTTP_NOT_FOUND);
        }
        elseif(!empty($firstName) && !empty($lastName)){
            $user->setFirstName($firstName);
            $user->setLastName($lastName);
            $sn->flush();
            return new View("User Updated Successfully", Response::HTTP_OK);
        }
        else return new View("User details cannot be empty", Response::HTTP_NOT_ACCEPTABLE);
    }

    /**
     * @Rest\Delete("/api/user/{id}")
     */
    public function deleteUser($id)
    {
//        $data = new User;
//        $currentUserId = 1;
//        $sn = $this->getDoctrine()->getManager();
//        $user = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);
//        if (empty($user)) {
//            return new View("User not found", Response::HTTP_NOT_FOUND);
//        }
//        elseif ($user->getId() == $currentUserId) {
//            $sn->remove($user);
//            $sn->flush();
//            return new View("User deleted successfully", Response::HTTP_OK);
//        }
//        return new View("Unathorized", Response::HTTP_FORBIDDEN);

    }
}

//TODO: Cascade delete in mysql
//TODO: $oldHashedPass
//TODO: parameter groups in user model