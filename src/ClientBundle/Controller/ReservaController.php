<?php
// src/ClientBundle/Controller/ReservaController.php
namespace ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Reserva;
use ClientBundle\Form\ReservaType;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class ReservaController extends Controller
{
	private $params = null;
    private $em = null;

    /**
     * @Route("/{id_restaurante}/reserva", name="add_reserva")
     *
     * @param  Request $request [description]
     * @param  [type]  $id_restaurante [description]
     * @return [type]           [description]
     */
    public function addAction(Request $request, $id_restaurante)
    {
    	$this->initialize();
    	$this->getUsuario();

        $reserva = new Reserva();
        $form = $this->createForm(ReservaType::class, $reserva);

        $form->handleRequest($request);

        if ($this->getUser()) {
            $cliente = $this->em->getRepository("AppBundle:Cliente")
                ->findOneBy([
                    'usuario' => $this->getUser()->getId()
                ]);
        } else {
            $cliente = null;
        }

        $restaurante = $this->em->getRepository("AppBundle:Restaurante")
            ->findOneBy([
                'id' => $id_restaurante
            ]);

        if ($form->isSubmitted() && $form->isValid()) {

            $reserva->setFechaHoraRealizada(new \DateTime());

            $estado = $this->em->getRepository("AppBundle:EstadoReserva")
                ->findOneBy([
                    'id' => 1
                ]);
            $reserva->setEstado($estado);
            $estado->addReserva($reserva);

            $reserva->setRestaurante($restaurante);
            $restaurante->addReserva($reserva);

            if ($cliente != null) {
                $reserva->setCliente($cliente);
                $cliente->addReserva($reserva);
            }

            $this->em->persist($reserva);
            $this->em->flush();
            $this->params['info'] = "Su reserva se ha realizado correctamente";
            return $this->redirectToRoute('home_client', array("info"=> $this->params));
        }

        return $this->render('ClientBundle:Restaurante:reserva.html.twig', array(
        	'restaurante' => $restaurante,
            'cliente' => $cliente,
            'user' => $this->params['user'],
            'form' => $form->createView()
        ));
    }

    private function getUsuario()
    {
        if (!is_null($this->getUser())) {
            $this->params['user'] = $this->em->getRepository("AppBundle:Usuario")
                ->findOneBy([
                    'id' => $this->getUser()->getId()
                ]);
            $this->params['cliente'] = $this->em->getRepository("AppBundle:Cliente")
                ->findOneBy([
                    'usuario' => $this->getUser()->getId()
                ]);
        } else {
            $this->params['user'] = null;
        }
    }

    private function initialize()
    {
        $this->params = [];
        $this->em = $this->getDoctrine()->getManager();
    }
}