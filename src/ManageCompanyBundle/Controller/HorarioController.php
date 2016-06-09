<?php
// src/ManageCompanyBundle/Controller/HorarioController.php
namespace ManageCompanyBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Horario;
use ManageCompanyBundle\Form\HorarioType;
use Symfony\Component\HttpFoundation\Request;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class HorarioController extends Controller
{
	private $em = null;
	private $params = null;
	
	/**
     * Muestra la lista de horarios
     *
     * @Route("/horarios", name="gestion_horarios")
     */
    public function showAction()
	{
        $this->initialize();

        $this->params['horarios'] = $this->em->getRepository("AppBundle:Horario")
            ->findBy(
				['restaurante' => $this->getIdRestaurante()],
                ['id' => 'ASC']
            );

        return $this->render('ManageCompanyBundle:Restaurante:horarios.html.twig', $this->params);
    }
	
	/**
     * @Route("/horarios/insertar", name="add_horario")
	 *
     * @param  Request $request [description]
     * @return [type]           [description]
     */
	public function addAction(Request $request)
	{
		$this->initialize();
		
		$horario = new Horario();
        $form = $this->createForm(HorarioType::class, $horario);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
			
			$restaurante = $this->em->getRepository("AppBundle:Restaurante")
				->findOneBy([
					'id' => $this->getIdRestaurante()
				]);
			$horario->setRestaurante($restaurante);
			$restaurante->addHorario($horario);

        	$this->em->persist($horario);
            $this->em->flush();
			
			return $this->redirectToRoute('gestion_horarios');
        }
		
		return $this->render('ManageCompanyBundle:Restaurante:horarios.html.twig', array(
            'form' => $form->createView()
        ));
	}
	
	/**
     * @Route("/horarios/{id_horario}/edit", name="edit_horario")
     * 
     * @param  Request $request    [description]
     * @param  [type]  $id_horario [description]
     * @return [type]              [description]
     */
	public function updateAction(Request $request, $id_horario)
	{
		if ($request->request->has('edit-horario')) 
		{
			$this->initialize();
			
			$horario = $this->em->getRepository("AppBundle:Horario")
				->findOneBy([
					'id' => $id_horario
				]);
			
			if (!$horario) {
				throw $this->createNotFoundException(
					'No se encontró el horario con id '.$id_horario
				);
			}
			
			if ($this->checkRestaurante($horario)) {
				$horario->setDescripcion($request->request->get('descripcion'.$id_horario));
				$horario->setHoraApertura(\DateTime::createFromFormat('H:i', $request->request->get('hora_apertura'.$id_horario)));
				$horario->setHoraCierre(\DateTime::createFromFormat('H:i', $request->request->get('hora_cierre'.$id_horario)));
			
				$this->em->flush();
			}
			return $this->redirectToRoute('gestion_horarios');
			
		}
		return $this->redirectToRoute('gestion_horarios');
	}
	
	/**
     * @Route("/horarios/{id_horario}/delete", name="delete_horario")
     * 
     * @param  Request $request    [description]
     * @param  [type]  $id_horario [description]
     * @return [type]              [description]
     */
	public function deleteAction(Request $request, $id_horario)
	{
		$this->initialize();
		
		$horario = $this->em->getRepository("AppBundle:Horario")
			->findOneBy([
                'id' => $id_horario
            ]);
		
		if (!$horario) {
			throw $this->createNotFoundException(
				'No se encontró el horario con id '.$id_horario
			);
		}
		
		if ($this->checkRestaurante($horario)) {
			$restaurante = $this->em->getRepository('AppBundle:Restaurante')
				->findOneBy([
					'id' => $this->getIdRestaurante()
				]);
			$restaurante->removeHorario($horario);
			
			$this->em->remove($horario);
			$this->em->flush();
		}
		return $this->redirectToRoute('gestion_horarios');
	}
	
	/**
     * Obtengo el id del restaurante logeado (Tabla Restaurante)
     *
     * @return mixed
     */
    private function getIdRestaurante()
	{
        $user = $this->em->getRepository("AppBundle:Usuario")
            ->findOneBy([
                'id' => $this->getUser()->getId()
            ]);
        return  $this->em->getRepository("AppBundle:Restaurante")
            ->findOneBy([
                'id' => $user->getIdRestaurante()->getId()
            ])->getId();
    }
	
	/**
	 * Compruebo que id del usuario logeado sea el id del restaurante con el que estoy trabajando
	 *
	 * @param $horario
	 * @return bool
	 */
	private function checkRestaurante($horario)
	{
		return $horario->getRestaurante()->getId() == $this->getIdRestaurante();
	}
	
	private function initialize()
	{
        $this->params = [];
        $this->em = $this->getDoctrine()->getManager();
    }
}