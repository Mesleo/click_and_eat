<?php
// src/ManageCompanyBundle/Form/ProductoType.php
namespace ManageCompanyBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ProductoType extends AbstractType
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
			->add('tipo', ChoiceType::class, array(
					'required' => true,
					'choices'  => array(
						'Entrante' => 'Entrante',
						'Hamburguesa' => 'Hamburguesa',
						'Sandwich' => 'Sandwich',
						'Bocadillo' => 'Bocadillo',
						'Pizza' => 'Pizza',
						'Plato combinado' => 'Plato combinado',
						'Carne' => 'Carne',
						'Pescado' => 'Pescado',
						'Kebab' => 'Kebab',
						'Durum' => 'Durum',
						'Falafel' => 'Falafel',
						'Arroz' => 'Arroz',
						'Pasta' => 'Pasta',
						'Sopa' => 'Sopa',
						'Revuelto' => 'Revuelto',
						'Ensalada' => 'Ensalada',
						'Montado' => 'Montado',
						'Refresco' => 'Refresco',
						'Cerveza' => 'Cerveza',
						'Vino' => 'Vino',
						'Otro' => 'Otro',
					),
					"attr" => array('class' => 'form-control')
				))
            ->add('nombre', TextType::class, array(
					'required' => true,
            		"attr" => array('class' => 'form-control')
            	))
            ->add('descripcion', TextType::class, array(
            		"attr" => array('class' => 'form-control')
            	))
            ->add('precio', MoneyType::class, array(
            		"attr" => array('class' => 'form-control')
            	))
            ->add('img', FileType::class, array('required' => false,
            		"attr" => array('class' => 'form-control'),
					'data_class' => null
            	))
//			->add('disponible', CheckboxType::class, array(
//                    'label'    => 'Disponible',
//                    'required' => false
//                ))
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
        return 'managecompanybundle_productotype';
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Producto'
        ));
    }
}