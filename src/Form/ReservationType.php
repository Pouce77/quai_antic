<?php

namespace App\Form;

use App\Entity\Reservation;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ReservationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numberOfpeople', IntegerType::class,[
            "label" => "Nombre de couverts",
            "required" => true,
            "constraints" => [
                new NotBlank(["message" => "Le nombre de couvert ne peut être nul !"])
                
                ]
            ])
            ->add('email', EmailType::class,[
            "required" => true,
            "constraints" => [
                new NotBlank(["message" => "L'email ne doit pas être vide !"])
            ]
            ])
            ->add('allergie', TextType::class,[
                "label" => "Renseigner vos allergies",
               "required" => false, 
            ])
            ->add('creneaux', TextType::class,[
                "label" => "",
                "required" => true,
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'csrf_token_id'   => 'reservation_item'
        ]);
    }
}
