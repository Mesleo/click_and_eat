<?php
// src/ManageCompanyBundle/Form/RestauranteType.php
namespace ManageCompanyBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class RestauranteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('usuario', TextType::class, array(
            		"attr" => array('class' => 'form-control')
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
            ->add('nombre', TextType::class, array(
            		"attr" => array('class' => 'form-control')
            	))
            ->add('cif', TextType::class, array(
            		"attr" => array('class' => 'form-control')
            	))
            ->add('direccion', TextType::class, array(
            		"attr" => array('class' => 'form-control')
            	))
            /*->add('localidad', EntityType::class, array(
                    'class' => 'AppBundle:Localidad',
                    'choice_label' => 'Localidad',
            	))*/
            ->add('telefono', TextType::class, array(
            		"attr" => array('class' => 'form-control')
            	))
            ->add('foto', FileType::class, array('required' => false,
            		"attr" => array('class' => 'form-control')
            	))
            ->add('precio_envio', MoneyType::class, array(
            		"attr" => array('class' => 'form-control')
            	))
        ;
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
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Restaurante'
        ));
    }
}