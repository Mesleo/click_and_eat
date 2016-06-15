<?php
// src/ManageCompanyBundle/Form/TrabajadorType.php
namespace ManageCompanyBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class PedidoType extends AbstractType
{
    /**
     *
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('numpedido', TextType::class, array(
                "attr" => array('class' => 'form-control'),
                "label" => "Número de pedido"
            ))
            ->add('fechaHoraRealizado', EmailType::class, array(
                "attr" => array('class' => 'form-control')
            ))
            ->add('id_estado', TextType::class, array(
                "attr" => array('class' => 'form-control'),
                "label" => "Nombre"
            ))
            ->add('telefono', TextType::class, array(
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
        return 'managecompanybundle_pedidotype';
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Pedido'
        ));
    }
}