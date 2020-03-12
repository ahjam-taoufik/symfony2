<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class PasswordUpdateType extends AbstractType
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
            ->add('oldPassword',PasswordType::class,$this->configure("Ancien mot de passe", "Ancien MDP...."))
            ->add('newPassword',PasswordType::class,$this->configure("Nouveau mot de passe", "Nouveau MDP...."))
            ->add('confirmPassword',PasswordType::class,$this->configure("confirm mot de passe", "confirmation de MDP...."))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
