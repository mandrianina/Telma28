<?php

namespace Telma\DashboardBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;



class OffreType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('isSelected',  CheckboxType::class,array('required' => false, 'label' => false,
                                                              'attr' => array('class' => 'input-sm isSelected')))
            ->add('position',       HiddenType::class, array('attr' => array('class' => 'positionInput input_edit input-sm')))
            ->add('classe',         HiddenType::class,   array('required' => false, 'attr' => array('class' => 'input-sm input_edit classe')))
            ->add('nomOffre',       HiddenType::class, array( 'attr' => array('class' => 'input-sm input_edit nomOffre')))
            ->add('type',           HiddenType::class,    array('required' => false, 'attr' => array('class' => 'input-sm input_edit type')))
            ->add('config',         HiddenType::class,   array('required' => false, 'attr' => array('class' => 'input-sm input_edit config')))
            ->add('typeDebit',      HiddenType::class,   array('required' => false, 'attr' => array('class' => 'input-sm input_edit typeDebit')))
            ->add('debitMax',       HiddenType::class, array('required' => false, 'attr' => array('class' => 'input-sm input_edit debitMax')))
            ->add('debitMin',       HiddenType::class, array('required' => false, 'attr' => array('class' => 'input-sm input_edit debitMin')))
            ->add('debitMinObtenu', HiddenType::class, array('required' => false, 'attr' => array('class' => 'input-sm input_edit debitMinObtenu')))
            ->add('debitMaxGlobal', HiddenType::class, array( 'attr' => array('class' => 'input-sm input_edit debitMG')))
            ->add('typeConnexion',  CheckboxType::class,array('required' => false, 'label' => false,
                                                              'attr' => array('class' => 'input-sm typeConnexion')))
            ->add('configCalculee', HiddenType::class, array('required' => false, 'attr' => array('class' => 'input-sm input_edit configCalulee')))
            ->add('maxHost',        HiddenType::class, array('required' => false, 'attr' => array('class' => 'input-sm input_edit maxHost')))
            ->add('taux',           HiddenType::class,   array('required' => false, 'attr' => array('class' => 'input-sm input_edit taux')))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Telma\DashboardBundle\Entity\Offre'
        ));
    }
}
