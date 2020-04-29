<?php

namespace App\Form;

use App\Entity\Member;
use App\Entity\Commune;
use App\Entity\Province;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AdvanceMemberType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('parrain', EntityType::class,[
                'label' => "Parrain Direct ",
                'attr'  => [
                    'placeholder' => "Selectionnez le parrain direct du nouveau membre",
                ],
                'class' => Member::class,
                'choice_label' => function(Member $member){
                    return $member->getname().' '.$member->getLastname(). ' ('.$member->getToken().')';
                },
                "required" => false
            ])
            ->add('token', TextType::class, $this->getConfiguration("Token", "Token du nouveau membre"))
            ->add('name', TextType::class, $this->getConfiguration("Objet social", "Introduire le nom de l'entreprise"))
            ->add('tel1', TelType::class, $this->getConfiguration("Numéro de téléphone", "Introduire le numéro de téléphone"))
            ->add('tel2', TelType::class, $this->getConfiguration("Numéro de téléphone 2", "Introduire un deuxième numéro de téléphone", ["required" => false]))
            ->add('email', EmailType::class, $this->getConfiguration("Adresse email", "Introduire l'adresse mail", ["required" => false]))
            ->add('date_nais', DateType::class, $this->getConfiguration("Date de création", "Date de création de l'entreprise",[ 'widget' => 'single_text']))
            ->add('picture', FileType::class, $this->getConfiguration("Logo de l'entreprise", "Le logo de l'entreprise", ["required" => false]))
            ->add('website', UrlType::class, $this->getConfiguration("Site web de l'entreprise", "Introduire le site web de l'entreprise", ["required" => false]))
            ->add('rccm', TextType::class, $this->getConfiguration("Numéro de registre commercial", "Introduire le numéro RCCM", ["required" => false]))
            ->add('id_national', TextType::class, $this->getConfiguration("ID National", "Introduire le numéro d'identification national", ["required" => false]))
            ->add('num_impot', TextType::class, $this->getConfiguration("Numéro d'impôt", "Introduire le numéro d'impôt", ["required" => false]))
            ->add('province', EntityType::class,[
                'class' => Province::class,
                'choice_label' => 'libelle',
            ], $this->getConfiguration("Province implantée","Selectionnez la province où est implantée l'entreprise"))
            ->add('commune', EntityType::class,[
                'class' => Commune::class,
                'choice_label' => 'libelle',
            ], $this->getConfiguration("Commune","Selectionnez la commune"))
            ->add('address', TextareaType::class, $this->getConfiguration("L'adresse", "Introduire le nom de l'avenue et le numéro"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Member::class,
        ]);
    }
}
