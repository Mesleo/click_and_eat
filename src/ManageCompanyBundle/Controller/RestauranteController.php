<?php
// src/ManageCompanyBundle/Controller/RestauranteController.php
namespace ManageCompanyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Restaurante;
use ManageCompanyBundle\Form\RestauranteType;
use Symfony\Component\HttpFoundation\Request;

class RestauranteController extends Controller
{
    public function registerAction(Request $request)
    {
        $restaurante = new Restaurante();
        $form = $this->createForm(RestauranteType::class, $restaurante);
        $form->handleRequest($request);

        $restaurante->setCoordenadas('102,30');
        $restaurante->setMapa('mapa');
        $localidad = $this->getLocalidad(1025);
        $restaurante->setLocalidad($localidad);

        if ($form->isValid()) {
            $em = $this->getDoctrine()
                       ->getManager();
            $em->persist($restaurante);
            $em->flush();

            //$this->get('session')->getFlashBag()->add('info', '¡Enhorabuena! Te has registrado correctamente.');

            //return $this->redirect($this->generateUrl('ManageCompanyBundle_homepage'));
            return $this->redirectToRoute('homepage');
        }

        return $this->render('ManageCompanyBundle:Restaurante:registro.html.twig', array(
            'restaurante' => $restaurante,
            'form'    => $form->createView()
        ));
    }

    protected function getLocalidad($localidad_id)
    {
        $em = $this->getDoctrine()
                    ->getManager();

        $localidad = $em->getRepository('AppBundle:Localidad')->find($localidad_id);

        if (!$localidad) {
            throw $this->createNotFoundException('Unable to find localidad.');
        }

        return $localidad;
    }

    /*public function loginAction(Request $request)
    {

    }*/
}