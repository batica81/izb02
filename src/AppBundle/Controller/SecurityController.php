<?php
/**
 * Created by PhpStorm.
 * User: Voja
 * Date: 04-Sep-17
 * Time: 20:59
 */

namespace AppBundle\Controller;

use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends FOSRestController
{

    /**
     * @Rest\Get("/login", name="security_login")
     */
    public function loginAction ()
    {
//        $authenticationUtils = $this->get('security.authentication_utils');
//
//        $error = $authenticationUtils->getLastAuthenticationError();
//
//        $lastUsername = $authenticationUtils->getLastUsername();

//        $whatever = array(
//            'last_username' => $lastUsername,
//            'error' => $error,
//        );

//        return $whatever;
//        return new Response('<html><body>Admin page!<br><a href="/logout">Logout</a></body></html>');
//        return new View("This will work eventually", Response::HTTP_OK);

    }
}