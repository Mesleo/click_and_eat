<?php
// src/ClientBundle/Controller/DefaultController.php
namespace ClientBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\Domicilio;
use AppBundle\Entity\Localidad;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;

class DefaultController extends Controller
{

    private $params = null;
    private $em = null;

    /**
     * @Route("/", name="home_client")
     */
    public function indexAction()
    {
        $this->initialize();
        if(!is_null($this->getUser())){
            $this->params['user'] = $this->em->getRepository("AppBundle:Usuario")
                ->findOneBy([
                    "id" => $this->getUser()->getId()
                ]);
        }
        return $this->render('ClientBundle:Page:index.html.twig', $this->params);
    }

    /**
     * @Route("/restaurantes", name="show_restaurantes")
     */
    public function showAction()
    {
        $this->initialize();
        $this->params['restaurantes'] = $this->em->getRepository("AppBundle:Restaurante")
                ->showRestaurantes();

        return $this->render('ClientBundle:Restaurante:show.html.twig', $this->params);

    }

    /**
     * Muestra las localidades a partir de una consulta pasada a JSON
     *
     * @Route("/localidad", name="show_restaurantes")
     */
    public function getLocalidades(Request $request){
        $this->initialize();
        $this->params['localidades'] = $this->em->getRepository('AppBundle:Localidad')
            ->findBy(
                array('provincia' => $request->query->get('provincia')),
                array('nombre' => 'ASC')
            );
        return $this->render('ClientBundle:FilesJson:localidades_cliente.json.twig', $this->params);
    }

    private function initialize()
    {
        $this->params = [];
        $this->em = $this->getDoctrine()->getManager();
    }
}
