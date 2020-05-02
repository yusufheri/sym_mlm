<?php

namespace App\Form;

use App\Entity\PasswordUpdate;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class PasswordUpdateType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('oldPassword', PasswordType::class, $this->getConfiguration("Ancien mot de passe", "Entrez l'ancien mot de passe"))
                ->add('newPassword', PasswordType::class, $this->getConfiguration("Nouveau mot de passe", "Saisissez votre nouveau mot de passe"))
                ->add('confirmPassword', PasswordType::class, $this->getConfiguration("Confirmation de mot de passe", "Confirmer votre nouveau mot de passe"))
                ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PasswordUpdate::class,
        ]);
    }
}
