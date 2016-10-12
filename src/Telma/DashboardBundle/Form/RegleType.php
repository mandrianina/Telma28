<?php

namespace Telma\DashboardBundle\Form;

use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RegleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('offre', EntityType::class, array(
                'class' => 'TelmaDashboardBundle:Offre',
                'choice_label' => 'NomOffre',
                'attr'=> array('class'=>'nom'),
                'placeholder' => '-Choose offers'))
            ->add('alias', TextType::class, array('required' => false,
                                                   'attr' => array('class'=>'alias')))
            ->add('contenu', TextareaType::class, array('attr'=> array('class'=>'contenu')))
            ->add('save', SubmitType::class)
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Telma\DashboardBundle\Entity\Regle'
        ));
    }
}
