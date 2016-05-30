<?php
// src/ManageCompanyBundle/Form/PlatoType.php
namespace ManageCompanyBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class PlatoType extends AbstractType
{
	private $em = null;
    private $params = null;

    /**
     * Genera el formulario de registro
     * 
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
    	$builder
            ->add('nombre', TextType::class, array(
                    "required" => true,
            		"attr" => array('class' => 'form-control')
            	))
            ->add('descripcion', TextType::class, array(
            		"attr" => array('class' => 'form-control')
            	))
            ->add('precio', MoneyType::class, array(
            		"attr" => array('class' => 'form-control')
            	))
            ->add('foto', FileType::class, array('required' => false,
            		"attr" => array('class' => 'form-control'),
					'data_class' => null
            	))
            ->add('disponible', CheckboxType::class, array(
                    'label'    => 'Disponible',
                    'required' => false,
                    'attr' => array('class' => 'form-control')
                )
            )
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
        return 'managecompanybundle_platotype';
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Plato'
        ));
    }
}