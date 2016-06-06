<?php

namespace EmployeeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="zone_employee")
     */
    public function indexAction()
    {
        return $this->render('EmployeeBundle:Default:index.html.twig');
    }
}
