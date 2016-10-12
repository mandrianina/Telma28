<?php

namespace Telma\DashboardBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class ProductType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('referenceProduit', TextType::class)
            ->add('regionProduit', ChoiceType::class, array( 'choices' => array( 'Tana' => 'TANA' ,'Tulear' => 'TULEAR' , 'Tous' => 'TOUS')))
            ->add('offresFixes', TextareaType::class, array('required' => false))
            ->add('fichier', FileType::class)
            ->add('send', SubmitType::class)
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Telma\DashboardBundle\Entity\Product',
            'csrf_protection' => false
        ));
    }
}
