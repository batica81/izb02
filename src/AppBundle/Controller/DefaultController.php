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

//    /**
//     * @Route("/admin", name="adminhomepage")
//     */
//    public function adminAction(Request $request)
//    {
//        // replace this example code with whatever you need
////        return $this->render('default/index.html.twig', [
////            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
////        ]);
////        return new View("there are no users exist", Response::HTTP_NOT_FOUND);
////        return new View("Hello", Response::HTTP_OK);
//
//
//        return new Response('<html><body>Admin page!<br><a href="/logout">Logout</a></body></html>');
//    }
//
//    /**
//     * @Route("/logout", name="logout")
//     */
//    public function logoutAction(Request $request)
//    {
//        // replace this example code with whatever you need
////        return $this->render('default/index.html.twig', [
////            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
////        ]);
////        return new View("there are no users exist", Response::HTTP_NOT_FOUND);
////        return new View("Bye Bye!", Response::HTTP_UNAUTHORIZED);
////        return new Response('<html><body>Bye Bye!</body></html>', Response::HTTP_UNAUTHORIZED);
//
//        $response = new RedirectResponse('/admin',302,['Authorization' => 'Basic bG9nb3V0OmxvZ291dA==']);
//
////        $response->headers->set('Authorization', 'Basic bG9nb3V0OmxvZ291dA==');
//
//        $response->headers->set('Authorization', 'Basic bG9nb3V0OmxvZ291dA==');
//
//        return $response;
////        $request = Request::create(
////            '/hello-world',
////            'GET',
////            array('name' => 'Fabien')
////        );
////
////        $request::send();
////        return new Response('<html><body>Admin page!</body></html>');
//    }
}
