<?php
// src/ManageCompanyBundle/Controller/TrabajadorController.php
namespace ManageCompanyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Trabajador;
use ManageCompanyBundle\Form\TrabajadorType;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class TrabajadorController extends Controller
{
	private $em = null;
	private $params = null;
	
	/**
     * Muestra la lista de trabajadores
     *
     * @Route("/trabajadores", name="gestion_trabajadores")
     */
    public function showAction()
	{
        $this->initialize();

        $this->params['trabajadores'] = $this->em->getRepository('AppBundle:Trabajador')
            ->findBy(
				['restaurante' => $this->getIdRestaurante()],
                ['nombre' => 'ASC']
            );

        return $this->render('ManageCompanyBundle:Restaurante:trabajadores.html.twig', $this->params);
    }
	
	/**
     * @Route("/trabajadores/insertar", name="add_trabajador")
	 *
     * @param  Request $request [description]
     * @return [type]           [description]
     */
	public function addAction(Request $request)
	{
		$this->initialize();
		
		$trabajador = new Trabajador();
        $form = $this->createForm(TrabajadorType::class, $trabajador);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
			
			$restaurante = $this->em->getRepository('AppBundle:Restaurante')
				->findOneBy([
					'id' => $this->getIdRestaurante()
				]);
			$trabajador->setRestaurante($restaurante);
			$restaurante->addTrabajadore($trabajador);
			
			$password = $this->get('security.password_encoder')
                ->encodePassword($trabajador, $trabajador->getPassword());
            $trabajador->setPassword($password);

        	$this->em->persist($trabajador);
            $this->em->flush();
			
			return $this->redirectToRoute('gestion_trabajadores');
        }
		
		return $this->render('ManageCompanyBundle:Restaurante:trabajadores_restaurante.html.twig', array(
            'form' => $form->createView()
        ));
	}
	
	/**
     * @Route("/trabajadores/{id_trabajador}/edit", name="edit_trabajador")
     * 
     * @param  Request $request    [description]
     * @param  [type]  $id_trabajador [description]
     * @return [type]              [description]
     */
	public function updateAction(Request $request, $id_trabajador)
	{
		$this->initialize();
		
		$trabajador = $this->em->getRepository('AppBundle:Trabajador')
			->findOneBy([
                'id' => $id_trabajador
            ]);
		
		if (!$trabajador) {
			throw $this->createNotFoundException(
				'No se encontró el trabajador con id '.$id_trabajador
			);
		}
		
		$form = $this->createForm(TrabajadorType::class, $trabajador);
		
		$form->handleRequest($request);
		
		if ($form->isSubmitted() && $form->isValid()) {
			
			$password = $this->get('security.password_encoder')
                ->encodePassword($trabajador, $trabajador->getPassword());
            $trabajador->setPassword($password);
			
			$this->em->flush();
			return $this->redirectToRoute('gestion_trabajadores');
		}
		
		return $this->render('ManageCompanyBundle:Restaurante:trabajadores_restaurante.html.twig', array(
			'trabajador' => $trabajador,
            'form' => $form->createView()
        ));
	}
	
	/**
     * @Route("/trabajadores/{id_trabajador}/delete", name="delete_trabajador")
     * 
     * @param  Request $request    [description]
     * @param  [type]  $id_trabajador [description]
     * @return [type]              [description]
     */
	public function deleteAction(Request $request, $id_trabajador)
	{
		$this->initialize();
		
		$trabajador = $this->em->getRepository('AppBundle:Trabajador')
			->findOneBy([
                'id' => $id_trabajador
            ]);
		
		if (!$trabajador) {
			throw $this->createNotFoundException(
				'No se encontró el trabajador con id '.$id_trabajador
			);
		}
		
		$restaurante = $this->em->getRepository('AppBundle:Restaurante')
			->findOneBy([
				'id' => $this->getIdRestaurante()
			]);
		$restaurante->removeTrabajadore($trabajador);
		
		$this->em->remove($trabajador);
		$this->em->flush();
		return $this->redirectToRoute('gestion_trabajadores');
	}
	
	/**
     * @Route("/trabajadores/{id_trabajador}", name="activar_trabajador")
     * 
     * @param  Request $request    [description]
     * @param  [type]  $id_trabajador [description]
     * @return [type]              [description]
     */
	public function activarAction(Request $request, $id_trabajador)
	{
		$this->initialize();
		
		$trabajador = $this->em->getRepository('AppBundle:Trabajador')
			->findOneBy([
                'id' => $id_trabajador
            ]);
		
		if (!$trabajador) {
			throw $this->createNotFoundException(
				'No se encontró el trabajador con id '.$id_trabajador
			);
		}
		
		$trabajador->setEnabled(true);
		
		$this->em->flush();
		return $this->redirectToRoute('gestion_trabajadores');
	}
	
	/**
     * @Route("/trabajadores/{id_trabajador}", name="desactivar_trabajador")
     * 
     * @param  Request $request    [description]
     * @param  [type]  $id_trabajador [description]
     * @return [type]              [description]
     */
	public function desactivarAction(Request $request, $id_trabajador)
	{
		$this->initialize();
		
		$trabajador = $this->em->getRepository('AppBundle:Trabajador')
			->findOneBy([
                'id' => $id_trabajador
            ]);
		
		if (!$trabajador) {
			throw $this->createNotFoundException(
				'No se encontró el trabajador con id '.$id_trabajador
			);
		}
		
		$trabajador->setEnabled(false);
		
		$this->em->flush();
		return $this->redirectToRoute('gestion_trabajadores');
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