<?php

namespace FraisBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;



class ForfaitFraisComptableType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('comment', TextType::class, array('label' => 'Commentaire', 'required' => false))
            ->add('etat', EntityType::class, array(
                // query choices from this entity
                'class' => 'FraisBundle:Etat',
                'choice_label' => 'wording',
                // 'multiple' => true,
                //'expanded' => true,
            ))
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
