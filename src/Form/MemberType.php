<?php

namespace App\Form;

use App\Entity\Member;
use ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MemberType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('lastname')
            ->add('prename')
            ->add('tel1')
            ->add('tel2')
            ->add('email')
            ->add('website')
            ->add('rccm')
            ->add('id_national')
            ->add('num_impot')
            ->add('createdAt')
            ->add('updatedAt')
            ->add('deletedAt')
            ->add('lieu_nais')
            ->add('date_nais')
            ->add('picture')
            ->add('sexe')
            ->add('province')
            ->add('commune')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Member::class,
        ]);
    }
}
