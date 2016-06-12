<?php
// src/ClientBundle/Form/UsuarioType.php
namespace RegisterBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UsuarioType extends AbstractType
{
    private $em = null;
    private $params = null;

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username', TextType::class, array(
					'label' => 'Usuario',
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
        return 'clientbundle_usuariotype';
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Usuario'
        ));
    }
}