<?php

namespace App\Form;

use App\Entity\Booking;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class BookingType extends AbstractType
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
            ->add('startDate',DateType::class,$this->configure("date d'arrivée","arrivée.... "/* ,["widget"=>"single_text"] */))
            ->add('endDate',DateType::class,$this->configure("date de départ","départ.... "/* ,["widget"=>"single_text"] */))
            ->add('comment',TextareaType::class,$this->configure(false,".... ",[
                  'required'=>false
            ]))

            ;
    }
 
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Booking::class,
        ]);
    }
}
