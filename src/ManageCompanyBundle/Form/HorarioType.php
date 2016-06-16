<?php
// src/ManageCompanyBundle/Form/HorarioType.php
namespace ManageCompanyBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;

class HorarioType extends AbstractType
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
            ->add('descripcion', TextType::class, array(
					'required' => true,
            		"attr" => array('class' => 'form-control')
            	))
			->add('hora_apertura', TimeType::class, array(
					'label' => false,
					"attr" => array(
							'class' => 'form-control input-small')
				))
			->add('hora_cierre', TimeType::class, array(
					'label' => false,
					"attr" => array(
							'class' => 'form-control input-small')
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
        return 'managecompanybundle_horariotype';
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Horario'
        ));
    }
}