<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    
    
    /**
     * @Route("/", name="home")
     */
    public function homeAction(Request $request)
    {

        return $this->render('default/index.html.twig', array(
            'test' => 'test',
        ));

    }
}

