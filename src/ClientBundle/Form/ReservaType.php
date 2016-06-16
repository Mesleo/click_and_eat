<?php
// src/ClientBundle/Form/ReservaType.php
namespace ClientBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ReservaType extends AbstractType
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
            ->add('nombre', TextType::class, array(
            		"attr" => array('class' => 'form-control')
            	))
            ->add('telefono', TextType::class, array(
                    "attr" => array('class' => 'form-control')
                ))
            ->add('email', EmailType::class, array(
            		"attr" => array('class' => 'form-control')
            	))
            ->add('numPersonas', NumberType::class, array(
                    'label' => 'Número de personas',
                    "attr" => array('class' => 'form-control')
                ))
            ->add('fechaHora', DateTimeType::class, array(
                    'label' => 'Fecha',
                    'input'  => 'datetime',
                    'widget' => 'single_text',
                    "attr" => array('class' => 'input-date form-control')
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
        return 'clientbundle_reservatype';
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Reserva'
        ));
    }
}