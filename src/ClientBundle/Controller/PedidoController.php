<?php
// src/ClientBundle/Controller/PedidoController.php
namespace ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use AppBundle\Entity\Pedido;
use ClientBundle\Form\PedidoType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class PedidoController extends Controller
{
	private $params = null;
    private $em = null;

    /**
     * @Route("/{id_restaurante}/pedido", name="add_pedido")
     *
     * @param  Request $request [description]
     * @param  [type]  $id_restaurante [description]
     * @return [type]           [description]
     */
    public function addAction(Request $request, $id_restaurante)
    {
        $this->initialize();

        $session = $request->getSession();

        $pedido = new Pedido();
        $form = $this->createForm(PedidoType::class, $pedido);

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

            $pedido->setNumPedido(uniqid());
            $pedido->setFechaHoraRealizado(new \DateTime());

            $estado = $this->em->getRepository("AppBundle:Estado")
                ->findOneBy([
                    'id' => 2
                ]);
            $pedido->setEstado($estado);
            $estado->addPedido($pedido);

            $pedido->setRestaurante($restaurante);
            $restaurante->addPedido($pedido);

            $this->em->persist($pedido);

            $ticket = new \AppBundle\Entity\Ticket();

            $ticket->setFecha(new \DateTime());
            $ticket->setFormaPago('efectivo');
            $ticket->setPedido($pedido);
            $pedido->setTicket($ticket);

            $this->em->persist($ticket);
            $this->em->flush();

            foreach ($session->all() as $key => $value) {
            	if ($key != 'subtotal' && $key != '_csrf/pedido' && $key != '_csrf/authenticate' && $key != '_security_gestion') {
            		$pedidoProducto = new \AppBundle\Entity\PedidoProducto();
            		$pedidoProducto->setCantidad($value[1]['cantidad']);
            		$pedidoProducto->setPrecio($value[0]['precio']);
            		$pedidoProducto->setDescuento(0);
            		$pedidoProducto->setPedido($pedido);
            		$pedido->addPedidoProducto($pedidoProducto);
            		$producto = $this->em->getRepository("AppBundle:Producto")
                		->findOneBy([
                    		'id' => $value[0]['id']
                		]);
            		$pedidoProducto->setProducto($producto);
            		$producto->addPedidoProducto($pedidoProducto);
            		$this->em->persist($pedidoProducto);
            		$this->em->flush();
            	}
        	}

        	$session->clear();

            return $this->redirectToRoute('home_client');
        }
        
        return $this->render('ClientBundle:Restaurante:pedido.html.twig', array(
        	'restaurante' => $restaurante,
            'cliente' => $cliente,
            'form' => $form->createView()
        ));
    }

    private function initialize()
    {
        $this->params = [];
        $this->em = $this->getDoctrine()->getManager();
    }
}