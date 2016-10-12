<?php

namespace Telma\DashboardBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class EditType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('offres', CollectionType::class, array(
                'entry_type' => OffreType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => true,
                'label' => false,
                'attr' => array('class' => 'my-selector')))
            ->add('save', SubmitType::class)            
        ;
    }
    

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Telma\DashboardBundle\Entity\Edit',
            'csrf_protection' => false
        ));
    }
}
