<?php
// src/ManageCompanyBundle/Controller/MesaController.php
namespace ManageCompanyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Mesa;
use ManageCompanyBundle\Form\MesaType;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class MesaController extends Controller
{
	private $em = null;
	private $params = null;

	/**
     * Muestra la lista de mesas
     *
     * @Route("/mesas", name="gestion_mesas")
     */
    public function showAction()
	{
        $this->initialize();

        $this->params['mesas'] = $this->em->getRepository('AppBundle:Mesa')
            ->findBy(
				['restaurante' => $this->getIdRestaurante()],
                ['id' => 'ASC']
            );

        return $this->render('ManageCompanyBundle:Restaurante:mesas.html.twig', $this->params);
    }

	/**
     * @Route("/mesas/insertar", name="add_mesa")
	 *
     * @param  Request $request [description]
     * @return [type]           [description]
     */
	public function addAction(Request $request)
	{
		$this->initialize();
		
		$mesa = new Mesa();
        $form = $this->createForm(MesaType::class, $mesa);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
			
			$restaurante = $this->em->getRepository('AppBundle:Restaurante')
				->findOneBy([
					'id' => $this->getIdRestaurante()
				]);
			$mesa->setRestaurante($restaurante);
			$restaurante->addMesa($mesa);

        	$this->em->persist($mesa);
            $this->em->flush();
			
			return $this->redirectToRoute('gestion_mesas');
        }
		
		return $this->render('ManageCompanyBundle:Restaurante:mesas_restaurante.html.twig', array(
            'form' => $form->createView()
        ));
	}
	
	/**
     * @Route("/mesas/{id_mesa}/edit", name="edit_mesa")
     * 
     * @param  Request $request    [description]
     * @param  [type]  $id_mesa [description]
     * @return [type]              [description]
     */
	public function updateAction(Request $request, $id_mesa)
	{
		$this->initialize();
		
		$mesa = $this->em->getRepository('AppBundle:Mesa')
			->findOneBy([
                'id' => $id_mesa
            ]);
		
		if (!$mesa) {
			throw $this->createNotFoundException(
				'No se encontró la mesa con id '.$id_mesa
			);
		}
		
		$form = $this->createForm(MesaType::class, $mesa);
		
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			$this->em->flush();
			return $this->redirectToRoute('gestion_mesas');
		}
		
		return $this->render('ManageCompanyBundle:Restaurante:mesas_restaurante.html.twig', array(
			'mesa' => $mesa,
            'form' => $form->createView()
        ));
	}
	
	/**
     * @Route("/mesas/{id_mesa}/delete", name="delete_mesa")
     * 
     * @param  Request $request    [description]
     * @param  [type]  $id_mesa [description]
     * @return [type]              [description]
     */
	public function deleteAction(Request $request, $id_mesa)
	{
		$this->initialize();
		
		$mesa = $this->em->getRepository('AppBundle:Mesa')
			->findOneBy([
                'id' => $id_mesa
            ]);
		
		if (!$mesa) {
			throw $this->createNotFoundException(
				'No se encontró la mesa con id '.$id_mesa
			);
		}
		
		$restaurante = $this->em->getRepository('AppBundle:Restaurante')
			->findOneBy([
				'id' => $this->getIdRestaurante()
			]);
		$restaurante->removeMesa($mesa);
		
		$this->em->remove($mesa);
		$this->em->flush();
		return $this->redirectToRoute('gestion_mesas');
	}
	
	private function getIdRestaurante()
	{
		$user = $this->getUser()->getId();
		return $user;
    }

	private function initialize()
	{
        $this->params = [];
        $this->em = $this->getDoctrine()->getManager();
    }
}