<?php

namespace EmployeeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class HomeController extends Controller
{

    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('EmployeeBundle:Base:base.html.twig');
    }
}
