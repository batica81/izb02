<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

//use FOS\RestBundle\View\View;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\HttpFoundation\RedirectResponse;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="htmlhomepage")
     */
    public function indexAction(Request $request)
    {

//        $response = new RedirectResponse('/index.html');
//        return $response;
//        return $this->render('/index.html');

            $file = "index.html";
            return new Response(file_get_contents($file));

    }



}
