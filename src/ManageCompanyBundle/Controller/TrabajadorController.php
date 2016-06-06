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

        $this->params['trabajadores'] = $this->em->getRepository("AppBundle:Trabajador")
				->showEmployeesRestaurant($this->getIdRestaurante());

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
		
		$usuario = new \AppBundle\Entity\Usuario();
		$form = $this->createForm(TrabajadorType::class, $usuario);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
			
			$restaurante = $this->em->getRepository("AppBundle:Restaurante")
				->findOneBy([
					'id' => $this->getIdRestaurante()
				]);
			$trabajador = new Trabajador();
			$trabajador->setApellidos($request->request->get("apellidos"));
			$trabajador->setRestaurante($restaurante);
			$restaurante->addTrabajadore($trabajador);
			
			$this->em->persist($trabajador);
			
			$password = $this->get('security.password_encoder')
                ->encodePassword($usuario, $usuario->getPassword());
            $usuario->setPassword($password);
            $usuario->addRole(2);
            $usuario->setTypeUser(2);
			$usuario->setTrabajador($trabajador);

        	$this->em->persist($usuario);
            $this->em->flush();
			
			return $this->redirectToRoute('gestion_trabajadores');
        }
		
		return $this->render('ManageCompanyBundle:Restaurante:trabajador.html.twig', array(
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
		
		$usuario = $this->em->getRepository("AppBundle:Usuario")
			->findOneBy([
				'trabajador' => $id_trabajador
			]);
		$trabajador = $this->em->getRepository("AppBundle:Trabajador")
			->findOneBy([
                'id' => $usuario->getTrabajador()->getId()
            ]);
		
		if (!$usuario or !$trabajador) {
			throw $this->createNotFoundException(
				'No se encontró el trabajador con id '.$id_trabajador
			);
		}
		
		if ($this->checkRestaurante($trabajador)) {
			$form = $this->createForm(TrabajadorType::class, $usuario);
			
			$form->handleRequest($request);
			
			if ($form->isSubmitted() && $form->isValid()) {
				$trabajador->setApellidos($request->request->get("apellidos"));
				$password = $this->get('security.password_encoder')
					->encodePassword($usuario, $usuario->getPassword());
				$usuario->setPassword($password);
				$usuario->setTypeUser(2);
				$usuario->setTrabajador($trabajador);
				$this->em->flush();
				return $this->redirectToRoute('gestion_trabajadores');
			}
			
			return $this->render('ManageCompanyBundle:Restaurante:trabajador.html.twig', array(
				'usuario' => $usuario,
				'trabajador' => $trabajador,
				'form' => $form->createView()
			));
		}
		return $this->redirectToRoute('gestion_trabajadores');
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
		
		$trabajador = $this->em->getRepository("AppBundle:Trabajador")
			->findOneBy([
                'id' => $id_trabajador
            ]);
		$this->em->getRepository("AppBundle:Trabajador")
			->showEmployeesRestaurant($id_trabajador);
		
		if (!$trabajador) {
			throw $this->createNotFoundException(
				'No se encontró el trabajador con id '.$id_trabajador
			);
		}
		
		if ($this->checkRestaurante($trabajador)) {
			$restaurante = $this->em->getRepository("AppBundle:Restaurante")
				->findOneBy([
					'id' => $this->getIdRestaurante()
				]);
			$restaurante->removeTrabajadore($trabajador);
			
			$this->em->remove($trabajador);
			$this->em->flush();
		}
		return $this->redirectToRoute('gestion_trabajadores');
	}
	
	/**
     * @Route("/trabajadores/{id_trabajador}/{value}", name="activar_trabajador")
     * 
     * @param  Request $request    [description]
     * @param  [type]  $id_trabajador [description]
	 * @param  [type]  $value [description]
     * @return [type]              [description]
     */
	public function activarAction(Request $request, $id_trabajador, $value)
	{
		$this->initialize();
		
		$trabajador = $this->em->getRepository("AppBundle:Trabajador")
			->findOneBy([
                'id' => $id_trabajador
            ]);
		
		if (!$trabajador) {
			throw $this->createNotFoundException(
				'No se encontró el trabajador con id '.$id_trabajador
			);
		}
		
		if ($this->checkRestaurante($trabajador)) {
			$usuario = $this->em->getRepository("AppBundle:Usuario")
				->findOneBy([
					'trabajador' => $trabajador->getId()
				]);
			$usuario->setEnabled($value);
			$this->em->flush();
		}
		return $this->redirectToRoute('gestion_trabajadores');
	}

	/**
     * Obtengo el id del usuario logeado (Tabla Usuarios)
     *
     * @return mixed
     */
    private function getIdUser()
    {
        $user = $this->em->getRepository("AppBundle:Usuario")
            ->findOneBy([
                'id' => $this->getUser()->getId()
            ]);
        return $this->getIdRestaurante($user->getId());
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
                'id' => $user->getRestaurante()->getId()
            ])->getId();
    }
	
	/**
     * Compruebo que id del usuario logeado sea el id del restaurante con el que estoy trabajando
     *
     * @param $trabajador
     * @return bool
     */
    private function checkRestaurante($trabajador)
	{
        return $trabajador->getRestaurante()->getId() == $this->getIdRestaurante();
    }

	private function initialize()
	{
        $this->params = [];
        $this->em = $this->getDoctrine()->getManager();
    }
}