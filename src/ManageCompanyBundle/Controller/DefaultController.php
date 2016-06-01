<?php
// src/ManageCompanyBundle/Controller/DefaultController.php
namespace ManageCompanyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
	/**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('ManageCompanyBundle:Page:index.html.twig');
    }
}
