<?php

namespace FraisBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ForfaitFraisType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('quantity')
            /*->add('type', ChoiceType::class, array(
                'choices' => array(
                    'Repas' => 'repas',
                    'Nuitée' => 'nuitee',
                    'Repas + Nuitée' => 'frais + transport',
                    'frais transport' => 'frais transport',
                ),
            ))*/
            ->add('forfait', EntityType::class, array(
                // query choices from this entity
                'class' => 'FraisBundle:Forfait',
                'choice_label' => 'wording',
                // 'multiple' => true,
                 //'expanded' => true,
            ))
            ->add('dateDuFrais')
            //->add('created')
            //->add('derniereEdition')
            //->add('ficheFrais')
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'FraisBundle\Entity\ForfaitFrais'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'fraisbundle_forfaitfrais';
    }


}
