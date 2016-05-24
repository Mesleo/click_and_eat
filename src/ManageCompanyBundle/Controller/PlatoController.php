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
     * @Security("has_role('ROLE_ADMIN')")
     * @Route("/platos", name="gestion_platos")
     * @return [type]              [description]
     */
    public function showAction(){
        $this->initialize();

        $this->params['platos'] = $this->em->getRepository('AppBundle:Plato')
            ->findAll([
                "nombre" => "DESC",
                "idRestaurante" => 2
                ]);

        return $this->render('ManageCompanyBundle:Restaurante:platos.html.twig', $this->params);
    }

	/**
     * 
     *
     * @Route("/platos/insertar", name="gestion_ins_plato")
     * @Security("has_role('ROLE_EDITOR')")
     * @Method({"POST"})
     *
     * @param Request $request
     * @return [type][description]
     */
	public function newAction(Request $request)
	{
        $this->initialize();
        $restaurante = $this->em->getRepository('AppBundle:Restaurante')
            ->findOneBy([
                "id" => $request->request->get('restaurante-id'),
            ]);
        if ($request->request->has("nombre-plato") && $request->request->get("nombre-plato") != "") {
            $restaurante = $this->em->getRepository('AppBundle:Restaurante')
                ->findOneBy([
                    "id" => $request->request->get('restaurante-id'),
                ]);
            print_r($request->request->get("nombre-plato"));
            $plato = new \AppBundle\Entity\Plato();
            $plato->setNombre($request->request->get("nombre-plato"));
            $plato->setDescripcion($request->request->get("descripcion-plato"));
            $plato->setPrecio($request->request->get("precio-plato"));
            $plato->setRestaurante($restaurante);
            $plato->setTrash(1);
            print_r($plato->getNombre());
            $restaurante->addPlato($plato);
            $this->em->persist($plato);
            $this->em->flush();
            $this->params['pagina'] = $restaurante;
//            return $this->render('GestionBundle:Web:platos.html.twig', $this->params);
        }

        return $this->redirectToRoute('gestion_platos');
	}

	private function initialize(){
        $this->params = [];
        $this->em = $this->getDoctrine()->getManager();
    }
}