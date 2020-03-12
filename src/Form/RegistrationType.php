<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RegistrationType extends AbstractType
{
    private function configure($label,$placeholder,$options=[]){
        return array_merge([
            'label'=>$label,
            'attr'=> [
                'placeholder'=>$placeholder
            ]
            ],$options) ;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fistName',TextType::class,$this->configure("Prenom", "Votre prenom...."))
            ->add('lastName',TextType::class,$this->configure("Nom", "Votre Nom...."))
            ->add('email',EmailType::class,$this->configure("Email", "Votre Email...."))
            ->add('picture',UrlType::class,$this->configure("photo de profil ", "photo de profil avatar...."))
            ->add('hash',PasswordType::class,$this->configure("Mot de passe", "Tapez votre mot de passe...."))

            ->add('passwordConfirm',PasswordType::class,$this->configure("confirmation de mot de passe", "Retapez votre mot de passe...."))

            ->add('introduction',TextType::class,$this->configure("introduction", "Votre introduction...."))
            ->add('description',TextareaType::class,$this->configure("Description", "Votre description...."))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
