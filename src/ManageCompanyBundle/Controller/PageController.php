<?php
// src/ManageCompanyBundle/Controller/PageController.php
namespace ManageCompanyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class PageController extends Controller
{
	/**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('ManageCompanyBundle:Page:index.html.twig');
    }
}
