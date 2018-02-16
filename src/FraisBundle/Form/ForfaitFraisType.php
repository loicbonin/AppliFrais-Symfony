<?php

namespace FraisBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ForfaitFraisType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('quantity')
            ->add('Type', ChoiceType::class, array(
                'choices' => array(
                    'Repas' => 'repas',
                    'Nuitée' => 'nuitee',
                    'Repas + Nuitée' => 'frais + transport',
                    'frais transport' => 'frais transport',
                ),
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
