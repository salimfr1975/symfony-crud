<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        $post=$this->getDoctrine()->getRepository('AppBundle:Post')->findAll();
        
        return $this->render('pages/index.html.twig',['posts'=>$post]);
    
    }
}
