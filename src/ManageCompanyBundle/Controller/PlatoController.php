<?php
// src/ManageCompanyBundle/Controller/PlatoController.php
namespace ManageCompanyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Plato;
use ManageCompanyBundle\Form\PlatoType;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class PlatoController extends Controller
{
	private $em = null;
	private $params = null;

	/**
     * Muestra la lista de platos
     *
     * @Route("/platos", name="gestion_platos")
     */
    public function showAction()
	{
        $this->initialize();

        $this->params['platos'] = $this->em->getRepository('AppBundle:Plato')
            ->findAll([
                "nombre" => "DESC",
                "idRestaurante" => 18
            ]);

        return $this->render('ManageCompanyBundle:Restaurante:platos.html.twig', $this->params);
    }

	/**
     * @Route("/platos/insertar", name="add_plato")
	 *
     * @param  Request $request [description]
     * @return [type]           [description]
     */
	public function addAction(Request $request)
	{
		$this->initialize();
		
		$plato = new Plato();
        $form = $this->createForm(PlatoType::class, $plato);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
			
			$restaurante = $this->em->getRepository('AppBundle:Restaurante')
				->findOneBy([
					"id" => $request->request->get('id_restaurante'),
				]);
			$plato->setFoto(' ');
			$plato->setRestaurante($restaurante);
			$restaurante->addPlato($plato);

        	$this->em->persist($plato);
            $this->em->flush();

            /*$platos = $this->em->getRepository('AppBundle:Plato')
                ->findAll(["nombre" => "DESC"]);
            $this->params['platos'] = $platos;*/
			
			return $this->redirectToRoute('gestion_platos');
            //return $this->render("ManageCompanyBundle:Restaurante:registro.html.twig");
            //return $this->render('ManageCompanyBundle:Restaurante:platos_restaurante.html.twig', $this->params);
        }
		
		return $this->render('ManageCompanyBundle:Restaurante:platos_restaurante.html.twig', array(
            'form'	=> $form->createView()
        ));

        //return $this->redirectToRoute('gestion_restaurante');
	}
	
	/**
     * @Route("/platos/{id_plato}/edit", name="edit_plato")
     * 
     * @param  Request $request    [description]
     * @param  [type]  $id_plato [description]
     * @return [type]              [description]
     */
	public function updateAction(Request $request, $id_plato)
	{
		$this->initialize();
		
		$plato = $this->em->getRepository('AppBundle:Plato')
			->findOneBy([
                "id" => $id_plato,
            ]);
		
		if (!$plato) {
			throw $this->createNotFoundException(
				'No se encontró el plato con id '.$id_plato
			);
		}
		
		$form = $this->createForm(PlatoType::class, $plato);
		
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			
			$this->em->flush();
			return $this->redirectToRoute('gestion_platos');
		}
		
		return $this->render('ManageCompanyBundle:Restaurante:platos_restaurante.html.twig', array(
			'plato'	=> $plato,
            'form'  => $form->createView()
        ));
		
		/*$this->params['plato'] = $this->em->getRepository('AppBundle:Plato')
            ->findOneBy([
                "id" => $id_plato,
            ]);
		
		return $this->render('ManageCompanyBundle:Restaurante:plato.html.twig', $this->params);*/
	}
	
	/**
     * @Route("/platos/{id_plato}/delete", name="delete_plato")
     * 
     * @param  Request $request    [description]
     * @param  [type]  $id_plato [description]
     * @return [type]              [description]
     */
	public function deleteAction(Request $request, $id_plato)
	{
		$this->initialize();
		
		$plato = $this->em->getRepository('AppBundle:Plato')
			->findOneBy([
                "id" => $id_plato,
            ]);
		
		if (!$plato) {
			throw $this->createNotFoundException(
				'No se encontró el plato con id '.$id_plato
			);
		}
		
		$this->em->remove($plato);
		$this->em->flush();
		return $this->redirectToRoute('gestion_platos');
	}

	private function initialize()
	{
        $this->params = [];
        $this->em = $this->getDoctrine()->getManager();
    }
}