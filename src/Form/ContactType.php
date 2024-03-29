<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;


class ContactType extends AbstractType
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
                'label_attr' => [
                    "class" => "form-label mt-4"
                ]
            ])
            ->add('email', EmailType::class, [
                'attr' => [
                    "class" => "form-control"
                ],
                'label' => 'Email',
                'label_attr' => [
                    "class" => "form-label mt-4"
                ]
            ])
            ->add('tel', TextType::class, [
                'attr' => [
                    "class" => "form-control",
                    'pattern' => '0\d{9}'
                ],
                'label' => 'Téléphone',
                'label_attr' => [
                    "class" => "form-label mt-4"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
