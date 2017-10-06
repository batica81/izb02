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
use Swagger\Annotations as SWG;


class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction(Request $request)
    {
       $helper = $this->get('security.authentication_utils');

       return $this->render(
           'auth/login.html.twig',
           array(
               'last_username' => $helper->getLastUsername(),
               'error'         => $helper->getLastAuthenticationError(),
           )
       );
    }

    /**
     * @Route("/login_check", name="security_login_check", methods={"POST"})
     *
     * @SWG\Response(
     * response=200,
     *     description="Logs in a user"
     * )
     *
     * @SWG\Parameter(
     *     name="_email",
     *     in="query",
     *     type="string",
     *     description="Users email"
     * )
     *
     * @SWG\Parameter(
     *     name="_password",
     *     in="query",
     *     type="string",
     *     description="Users password"
     * )
     *
     * @SWG\Tag(name="Login")
     */
    public function loginCheckAction()
    {

    }

    /**
     * @Route("/logout", name="logout", methods={"GET"})
     *
     * @SWG\Response(
     * response=200,
     *     description="Logs out a user"
     * )
     *
     * @SWG\Tag(name="Login")
     */
    public function logoutAction()
    {

    }


}