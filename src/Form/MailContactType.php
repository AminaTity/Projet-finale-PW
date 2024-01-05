<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\MailContact;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class MailContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('objet', TextType::class, [
                'attr' => [
                    "class" => "form-control"
                ],
                'label' => 'Objet',
                'label_attr' => [
                    "class" => "form-label mt-4"
                ]
            ])
            ->add('message', TextareaType::class, [
                'attr' => [
                    "class" => "form-control"
                ],
                'label' => 'Message',
                'label_attr' => [
                    "class" => "form-label mt-4"
                ]
            ])
            ->add('categories', EntityType::class, [
                'class' => Categorie::class,
                'choice_label' => function(Categorie $categorie) {
                    return $categorie->getCode() . ' : "' . $categorie->getNom() . '"'; 
                },
                'multiple' => true,
                'attr' => [
                    "class" => "form-control"
                ],
                'label' => 'Catégorie(s)',
                'label_attr' => [
                    "class" => "form-label mt-4"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MailContact::class,
        ]);
    }
}
