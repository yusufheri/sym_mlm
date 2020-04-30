<?php

namespace App\Form;

use App\Entity\CatPaiement;
use App\Entity\Member;
use App\Entity\Paiement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PaiementType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', EntityType::class,[
                'label' => "Type de paiement",
                'class' => CatPaiement::class,
                'choice_label' => 'libelle',
            ], $this->getConfiguration("Type", "Selectionnez la catégorie"))
            ->add('payer', EntityType::class,[
                'label' => "ID Membre",
                'attr'  => [
                    'placeholder' => "Selectionnez le membre concerné",
                ],
                'class' => Member::class,
                'choice_label' => function(Member $member){
                    return $member->getname().' '.$member->getLastname(). ' ('.$member->getToken().')';
                },
                "required" => false
            ])
            ->add('paidAt', DateType::class,$this->getConfiguration("Date de paiement", "Date de paiement",[ 'widget' => 'single_text']))
            ->add('amount', IntegerType::class,$this->getConfiguration("Montant en chiffres", "Montant en chiffres"))
            ->add('amount_letter', TextareaType::class,$this->getConfiguration("Montant en lettres", "Montant en lettres"))
            ->add('comment', TextareaType::class,$this->getConfiguration("Commentaire", "Saisir un commentaire si possible", ["required" => false]))
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Paiement::class,
        ]);
    }
}
