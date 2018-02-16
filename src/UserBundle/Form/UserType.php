<?php

namespace UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstName')->add('lastName')->add('oldPassword')->add('job')->add('address')->add('zipCode')->add('city')->add('birthDate')->add('fuel')->add('fiscalPower')->add('hiringDate')
        ->add('roles', ChoiceType::class, array(
                                'choices'   => array(
                                    'Administrateur'   => 'ROLE_ADMIN',
                                    'Comptable'      => 'ROLE_C',
                                    'Visiteur'      => 'ROLE_V',
                                ),
                                'multiple'  => true,
                                'expanded' => true,
                            ))  
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UserBundle\Entity\User'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'userbundle_user';
    }


}
