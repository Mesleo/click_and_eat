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
            $disponible = $request->request->has("plato_disponible");
            print_r($disponible);
            $plato->setRestaurante($restaurante);
            $restaurante->addPlato($plato);
            $plato->setDisponible($disponible);

            $this->em->persist($plato);
            $this->em->flush();

            return $this->redirectToRoute('gestion_platos');
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

    /**
     * @Route("/listar/imagenes", name="listar_imagenes")
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function findImages(Request $request){
        $baseUrl = $request->getSchemeAndHttpHost();
        $directory = new \RecursiveDirectoryIterator($this->container->getParameter('kernel.root_dir') .'/../web/uploads/');
        $iterator = new \RecursiveIteratorIterator($directory);
        $regex = new \RegexIterator($iterator, '/.[(png)|(jpg)|(gif)]+$/i', \RecursiveRegexIterator::GET_MATCH);

        $toRet = [
            'f' => '',
        ];

        foreach ($regex as $url => $value) {
            $toRet['f'][] = $baseUrl . substr($url, strpos($url, '/web') + 4);
        }

        return new JsonResponse($toRet);
    }

    /**
     * @Route("/subir/imagen", name="subir_imagen")
     * @param  Request $request [description]
     * @return [type]           [description]
     */
    public function uploadImage(Request $request){
        $toRet = [
            'Ok' => false
        ];
        $allowed = array('png', 'jpg', 'gif');

        if(isset($_FILES['upl']) && $_FILES['upl']['error'] == 0){

            $extension = pathinfo($_FILES['upl']['name'], PATHINFO_EXTENSION);

            if(in_array(strtolower($extension), $allowed)){
                $date = new \DateTime();
                $destinationFolder = $this->container->getParameter('kernel.root_dir') .'/../web/uploads/' . $date->format('Y')  . '/' . $date->format('m');
                if (!file_exists($destinationFolder)){
                    mkdir($destinationFolder, 0774, true);
                }

                if(move_uploaded_file($_FILES['upl']['tmp_name'], $destinationFolder . "/" . $_FILES['upl']['name'])){
                    $toRet['Ok'] = true;
                    $toRet['route'] = $request->getSchemeAndHttpHost() . '/uploads/' . $date->format('Y')  . '/' . $date->format('m') . '/' . $_FILES['upl']['name'];
                }
            }
        }

        return new JsonResponse($toRet);
    }
    

    private function initialize(){
        $this->params = [];
        $this->em = $this->getDoctrine()->getManager();
    }
}