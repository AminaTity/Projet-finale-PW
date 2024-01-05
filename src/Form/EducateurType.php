<?php

namespace App\Form;

use App\Entity\Educateur;
use App\Entity\Licencie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class EducateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'attr' => [
                    "class" => "form-control"
                ],
                'label' => 'Email',
                'label_attr' => [
                    "class" => "form-label mt-4"
                ]
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options'  => [
                    'label' => 'Mot de passe',
                    'hash_property_path' => 'password',
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Saisir le mot de passe',
                        ]),
                        new Length([
                            'min' => 6,
                            'minMessage' => 'Votre mot de passe doit faire au minimum {{ limit }} characters',
                            // max length allowed by Symfony for security reasons
                            'max' => 4096,
                        ]),
                    ],
                ],
                'second_options' => ['label' => 'Répéter le mot de passe'],
                'mapped' => false,
                'label' => ' '
            ])
            ->add('roles', ChoiceType::class, [
                'choices'  => [
                    'ROLE_USER' => 'ROLE_USER',
                    'ROLE_ADMIN' => 'ROLE_ADMIN'
                ],
                'multiple' => true,
                'attr' => [
                    'class' => "form-control"
                ],
                'label' => 'Statut',
                'label_attr' => [
                    "class" => "form-label mt-4"
                ]
            ])
            ->add('licencie', EntityType::class, [
                'class' => Licencie::class,
                'choice_label' => function(Licencie $licencie) {
                    return $licencie->getId() . ". " . $licencie->getNom() . " " . $licencie->getPrenom(); 
                },
                'attr' => [
                    "class" => "form-control"
                ],
                'label' => 'Licencié',
                'label_attr' => [
                    "class" => "form-label mt-4"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Educateur::class,
        ]);
    }
}
