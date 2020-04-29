<?php

namespace App\Form;

use App\Entity\Commune;
use App\Entity\Sexe;
use App\Entity\Member;
use App\Entity\Province;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class SimpleMemberType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('token', TextType::class, $this->getConfiguration("Token", "Token du nouveau membre"))
            ->add('name', TextType::class, $this->getConfiguration("Nom du membre", "Tapez le nom du nouveau membre"))
            ->add('lastname', TextType::class, $this->getConfiguration("Post nom du membre", "Tapez le Post nom du nouveau membre"))
            ->add('prename', TextType::class, $this->getConfiguration("Prénom", "Tapez le Prénom du nouveau membre", ["required" => false]))
            ->add('tel1', TelType::class, $this->getConfiguration("Numéro de téléphone", "Tapez le numéro de téléphone du nouveau membre"))
            ->add('tel2', TelType::class, $this->getConfiguration("Numéro de téléphone 2", "Tapez autre numéro de téléphone du nouveau membre", ["required" => false]))
            ->add('email', EmailType::class, $this->getConfiguration("Adresse email", "Tapez l'adresse mail du nouveau membre", ["required" => false]))
            ->add('lieu_nais', TextType::class, $this->getConfiguration("Lieu de naissance", "Tapez le lieu de naissance du nouveau membre"))
            ->add('date_nais', DateType::class, $this->getConfiguration("Date de naissance", "", ['widget' => 'single_text']))
            ->add('picture', FileType::class, $this->getConfiguration("Photo passeport", "",["required" => false]))
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
            ->add('address', TextareaType::class, $this->getConfiguration("L'adresse", "Introduire le nom de l'avenue et le numéro", ["required" => false]))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Member::class,
        ]);
    }
}
