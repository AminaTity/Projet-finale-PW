<?php

namespace App\Form;

use App\Entity\Licencie;
use App\Entity\Categorie;
use App\Entity\Contact;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class LicencieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => [
                    "class" => "form-control"
                ],
                'label' => 'Nom',
                'label_attr' => [
                    "class" => "form-label mt-4"
                ]
            ])
            ->add('prenom', TextType::class, [
                'attr' => [
                    "class" => "form-control"
                ],
                'label' => 'Prénom',
                "label_attr" => [
                    "class" => "form-label mt-4"
                ]
            ])
            ->add('contact', EntityType::class, [
                'class' => Contact::class,
                'choice_label' => function(Contact $contact) {
                    return $contact->getId() . ". " . $contact->getNom() . " " . $contact->getPrenom() . " " . $contact->getEmail(); 
                },
                'attr' => [
                    "class" => "form-control"
                ],
                'label' => 'Contact',
                'label_attr' => [
                    "class" => "form-label mt-4"
                ]
            ])
            ->add('categorie', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => function(Categorie $categorie) {
                    return $categorie->getId() . ". " . $categorie->getCode(); 
                },
                'attr' => [
                    "class" => "form-control"
                ],
                'label' => 'Catégorie',
                'label_attr' => [
                    "class" => "form-label mt-4"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Licencie::class,
        ]);
    }
}
