<?php
// src/RegisterBundle/Form/RestauranteType.php

namespace RegisterBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class RestauranteType extends AbstractType
{

    private $em = null;
    private $params = null;

    /**
     * Genera el formulario de registro
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, array(
            		"attr" => array('class' => 'form-control'),
                    "label" => "Nombre de usuario"
            	))
            ->add('password', RepeatedType::class, array(
                    'type' => PasswordType::class,
                    'invalid_message' => 'Las contraseñas deben coincidir',
                    'first_options'  => array('label' => 'Contraseña',
                    	"attr" => array('class' => 'form-control')),
                    'second_options' => array('label' => 'Confirmar contraseña',
                    	"attr" => array('class' => 'form-control')),
            	))
            ->add('email', EmailType::class, array(
            		"attr" => array('class' => 'form-control')
            	))
        ;
    }


    public function getProvincia(){
        $this->initialize();
        $toRet = false;
        $toRet = $this->getProvincias();
        if (!$toRet) {
            throw $this->createNotFoundException('No se ha podido localizar la provincia');
        }
        return new JsonResponse($toRet);
    }

    private function initialize(){
        $this->params = [];
        $this->em = $this->getDoctrine()->getManager();
    }

    /**
     * Devuelve todas las provincias
     *
     * @return JsonResponse
     */
    private function getProvincias()
    {
        foreach (($this->em->getRepository('AppBundle:Provincia')
            ->findBy(
                ['nombre' => "ASC"]
            )) as $provincia) {
            $this->params['provincias'][] = [
                'nombre' => $provincia->getNombre()
            ];
        }
        return $this->params;
    }

    /**
     * Returns the name of this type.
     *
     * @return string The name of this type
     *
     * @deprecated Deprecated since Symfony 2.8, to be removed in Symfony 3.0.
     *             Use the fully-qualified class name of the type instead.
     */
    public function getName()
    {
        return 'managecompanybundle_restaurantetype';
    }
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Usuario'
        ]);
    }
}