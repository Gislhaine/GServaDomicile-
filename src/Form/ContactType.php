<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('lastName', TextType::class,[
            'label' => 'Nom: ' ,
            'required' => true
        ])
        ->add('firstName', TextType::class,[
            'label' => 'Prénom: ' ,
            'required' => true
        ])
        ->add('email', EmailType::class,[
            'label' => 'Adresse Email: ',
            'required' => true
        ])
        ->add('phone', TelType::class,[
            'label' => 'Téléphone: ',
            'required' => false
        ])
        ->add('message',TextareaType::class,[
            'label' => 'Message: ',
            'required' => true
        ])
    
        ->add('send', SubmitType::class,[
            'label' => 'Envoyer'

        ])

        ->add('type', ChoiceType::class, [
            'choices' => [
                'Particulier' => 'particulier',
                'Professionnel' => 'professionnel',
            ],
            'expanded' => true, // Afficher les choix sous forme de boutons radio
        ])
        ->add('lastName', TextType::class, [
            'label' => 'Nom : ',
            'required' => true,
        ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
            'csrf_protection' => true,
        ]);
        $resolver->setDefined('contact_type');
    }
}
