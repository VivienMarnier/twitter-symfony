<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/twig-test", name="app_twig_test")
     */
    public function indexAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render(':default:index.html.twig',
            array('name' => 'john',
            'days' => array('monday','tuesday','wednesday','thursday','friday'),
            'html' => '<b>ce texte n\'est pas en gras</b>',
        ));
    }
}
