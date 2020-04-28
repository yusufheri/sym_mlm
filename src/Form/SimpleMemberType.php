<?php

namespace App\Form;

use App\Entity\Commune;
use App\Entity\Sexe;
use App\Entity\Member;
use App\Entity\Province;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SimpleMemberType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, $this->getConfiguration("Nom du membre", "Tapez un super titre pour votre annonce"))
            ->add('lastname', TextType::class, $this->getConfiguration("Post nom du membre", "Tapez un super titre pour votre annonce"))
            ->add('prename', TextType::class, $this->getConfiguration("Prénom", "Tapez un super titre pour votre annonce"))
            ->add('tel1', TelType::class, $this->getConfiguration("Numéro de téléphone", "Tapez un super titre pour votre annonce"))
            ->add('tel2', TelType::class, $this->getConfiguration("Numéro de téléphone 2", "Tapez un super titre pour votre annonce"))
            ->add('email', EmailType::class, $this->getConfiguration("Adresse email", "Tapez un super titre pour votre annonce"))
            ->add('lieu_nais', TextType::class, $this->getConfiguration("Lieu de naissance", "Tapez un super titre pour votre annonce"))
            ->add('date_nais', DateTimeType::class, $this->getConfiguration("Date de naissance", "Tapez un super titre pour votre annonce"))
            ->add('picture', FileType::class, $this->getConfiguration("Photo passeport", "Tapez un super titre pour votre annonce"))
            ->add('sexe', EntityType::class,[
                'class' => Sexe::class,
                'choice_label' => 'libelle',
            ])
            ->add('province', EntityType::class,[
                'class' => Province::class,
                'choice_label' => 'libelle',
            ])
            ->add('commune', EntityType::class,[
                'class' => Commune::class,
                'choice_label' => 'libelle',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Member::class,
        ]);
    }
}
