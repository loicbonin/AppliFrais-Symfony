<?php

namespace UserBundle\Form;

use function PHPSTORM_META\type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName')
            ->add('lastName')
            ->add('oldPassword')
            ->add('job')
            ->add('address')
            ->add('zipCode')
            ->add('city')
            ->add('hiringDate', DateType::class, array(
                'widget' => 'single_text',
                'html5' => false,
                'attr' => [
                    'class' => 'datepicker',
                ],
                'format' => 'dd/MM/yyyy',
                'label' => "date d'embauche"))
            //->add('fuel')
            //->add('fiscalPower')
            //->add('hiringDate')
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
