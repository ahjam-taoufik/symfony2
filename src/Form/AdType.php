<?php

namespace App\Form;

use App\Entity\Ad;
use App\Form\ImageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class AdType extends AbstractType
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
            ->add('title', TextType::class,$this->configure("Titre","Tapez votre Titre"))
            ->add('slug', TextType::class,$this->configure("Adresse web","Tapez Adresse web",[
                'required'=>false
            ]))
            ->add('price', MoneyType::class,$this->configure("prix par nuit","Tapez prix par nuit"))
            ->add('introduction', TextType::class,$this->configure("Introduction","Tapez Introduction"))
            ->add('content', TextareaType::class,$this->configure("description détaillée","Tapez votre description détaillée"))
            ->add('coverImage', UrlType::class,$this->configure("url de votre image","Tapez votre url de votre image"))
            ->add('rooms', IntegerType::class,$this->configure("Nombre de chambre","Nombre de chombre disponible"))
            ->add(
                //le nom de ce champ est ad_images :inspeter ce champ dans le navigateur
                'images',
                CollectionType::class,
                [
                    'entry_type' =>ImageType::class,
                    'allow_add'=>true
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
