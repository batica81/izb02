<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpFoundation\RedirectResponse;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="htmlhomepage")
     */
    public function indexAction(Request $request)
    {

        $response = new RedirectResponse('http://izb02.dev/index.html');
        return $response;
    }



    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction()
    {

//        $response = new RedirectResponse('/',302,['Authorization' => 'Basic bG9nb3V0OmxvZ291dA==']);
//
//
//        $response->headers->set('Authorization', 'Basic bG9nb3V0OmxvZ291dA==');

//        return $response;
        return new Response('<html><body>Logged out!<br></body></html>');

    }
}
