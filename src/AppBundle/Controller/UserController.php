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
     * @Rest\Post("/api/user")
     *
     * @SWG\Response(
     * response=200,
     *     description="Registers a user",
     *     @SWG\Schema(
     *         type="array",
     *         @Model(type=User::class)
     *     )
     * )
     *
     * @SWG\Parameter(
     *     name="email",
     *     in="query",
     *     type="string",
     *     description="Users e-mail"
     * )
     *
     * @SWG\Parameter(
     *     name="firstName",
     *     in="query",
     *     type="string",
     *     description="Users firstname"
     * )
     *
     * @SWG\Parameter(
     *     name="lastName",
     *     in="query",
     *     type="string",
     *     description="Users lastname"
     * )
     * @SWG\Parameter(
     *     name="pass",
     *     in="query",
     *     type="string",
     *     description="Users password"
     * )
     *
     * @SWG\Tag(name="User")
     */
    public function registerAction(Request $request)
    {
        // Create a new blank user and process the form
        $user = new User();
        $email = $request->get('email');
        $firstName = $request->get('firstName');
        $lastName = $request->get('lastName');
        $password = $request->get('pass');
        if(empty($firstName) || empty($lastName) || empty($email) || empty($password))
        {
            return new View("NULL VALUES ARE NOT ALLOWED", Response::HTTP_NOT_ACCEPTABLE);
        }
        $user->setEmail($email);
        $user->setFirstName($firstName);
        $user->setLastName($lastName);
        $user->setPassword($password);

        // Encode the new users password
        $encoder = $this->get('security.password_encoder');
        $password = $encoder->encodePassword($user, $user->getPassword());
        $user->setPassword($password);

        // Set their role
        $user->setRole('ROLE_USER');

        // Save
        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

//        return $this->redirectToRoute('security_login_check');
//        return new View("User Added Successfully", Response::HTTP_OK);
        return $user;
    }


    /**
     * @Rest\Get("/api/user")
     *
     * @SWG\Response(
     * response=200,
     *     description="Retreives authenticated users information",
     *     @SWG\Schema(
     *         type="array",
     *         @Model(type=User::class)
     *     )
     * )
     *
     * @SWG\Tag(name="User")
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
     * @Rest\Put("/api/user/changepass")
     *
     * @SWG\Response(
     * response=200,
     *     description="Change authenticated users password",
     *     @SWG\Schema(
     *         type="array",
     *         @Model(type=User::class)
     *     )
     * )
     *
     * @SWG\Parameter(
     *     name="oldpass",
     *     in="query",
     *     type="string",
     *     description="Users old password"
     * )
     *
     * @SWG\Parameter(
     *     name="newpass",
     *     in="query",
     *     type="string",
     *     description="Users new password"
     * )
     *
     * @SWG\Tag(name="User")
     */
    public function updatePassword(Request $request)
    {
//        $data = new User;
//        $oldpass = $request->get('oldpass');
//        $newpass = $request->get('newpass');
//
//                       if( $this->container->get( 'security.authorization_checker' )->isGranted( 'IS_AUTHENTICATED_FULLY' ) )
//{
//    $user = $this->container->get('security.token_storage')->getToken()->getUser();
//    $id = $user->getId();
//}
//
//        $sn = $this->getDoctrine()->getManager();
//        $user = $this->getDoctrine()->getRepository('AppBundle:User')->find($id);
//        $currentPass = $user->getHashedPassword();
//        $oldHashedPass = $oldpass;
//        if (empty($user)) {
//            return new View("User not found", Response::HTTP_NOT_FOUND);
//        }
//        elseif(!empty($oldpass) && !empty($newpass) && ($oldHashedPass != $currentPass)){
//            $user->setPassword($newpass);
//            $sn->flush();
//            return new View("Password updated Successfully", Response::HTTP_OK);
//        }
//        else return new View("Error changing password", Response::HTTP_NOT_ACCEPTABLE);
    }

    /**
     * @Rest\Put("/api/user")
     *
     * @SWG\Response(
     * response=200,
     *     description="Change authenticated users details",
     *     @SWG\Schema(
     *         type="array",
     *         @Model(type=User::class)
     *     )
     * )
     *
     * @SWG\Parameter(
     *     name="firstName",
     *     in="query",
     *     type="string",
     *     description="Users new firstname"
     * )
     *
     * @SWG\Parameter(
     *     name="lastName",
     *     in="query",
     *     type="string",
     *     description="Users new lastname"
     * )
     *
     * @SWG\Tag(name="User")
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
     *
     * @SWG\Response(
     * response=200,
     *     description="Delete authenticated user",
     *     @SWG\Schema(
     *         type="array",
     *         @Model(type=User::class)
     *     )
     * )
     *
     * @SWG\Parameter(
     *     name="id",
     *     in="path",
     *     type="string",
     *     description="Users ID"
     * )
     *
     * @SWG\Tag(name="User")
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

//TODO: change password
//TODO: delete user account, all articles and comments
