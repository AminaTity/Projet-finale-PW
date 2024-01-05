<?php

namespace App\Form;

use App\Entity\Educateur;
use App\Entity\MailEdu;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class MailEduType extends AbstractType
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
            ->add('educateurs', EntityType::class, [
                'class' => Educateur::class,
                'choice_label' => function(Educateur $educateur) {
                    return $educateur->getEmail() . " : " . $educateur->getLicencie()->getNom() . " " . $educateur->getLicencie()->getPrenom(); 
                },
                'multiple' => true,
                'attr' => [
                    "class" => "form-control"
                ],
                'label' => 'Éducateur(s)',
                'label_attr' => [
                    "class" => "form-label mt-4"
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MailEdu::class,
        ]);
    }
}
