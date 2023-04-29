<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Context\ExecutionContext;

class UserType extends AbstractType{

  public function buildForm(FormBuilderInterface $builder, array $options)
  {
    $builder
    ->add("email", EmailType::class, [
      "label" => "Email",
      "required" => true,
      "constraints" => [
          new NotBlank(["message" => "L'email ne doit pas être vide !"])
      ]
  ])
  ->add("password", PasswordType::class, [
      "label" => "Mot de passe",
      "required" => true,
      "constraints" => [
          new NotBlank(["message" => "Le mot de passe ne peut pas être vide !"])
      ]
  ])
  ->add("confirm", PasswordType::class, [
      "label" => "Confirmer le mot de passe",
      "required" => true,
      "constraints" => [
          new NotBlank(["message" => "Le mot de passe ne peut pas être vide !"]),
          // new EqualTo(["propertyPath" => "password", "message" => "Les mots de passe doivent être identique !"])
          new Callback(['callback' => function ($value, ExecutionContext $ec) {
              if ($ec->getRoot()['password']->getViewData() !== $value) {
                  $ec->addViolation("Les mots de passe doivent être identique !");
              }
          }
        ])]
  ])
  ->add("allergie", TextType::class, [
    "label" => "Allergie(s) éventuelle(s)",
    "required" => false,
  ])
  ->add("nbrCouvert", IntegerType::class, [
    "label" => "Nombre de couvert(s) habituellement",
    "required" => false,
  ])
  ;  
  }

  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults([
      "data_class" => User::class,
      'csrf_protection' => true,
      'csrf_field_name' => '_token',
      'csrf_token_id'   => 'user_item'
    ]);
  }

}