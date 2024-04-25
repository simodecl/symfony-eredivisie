<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * Form type for user registration.
 */
class RegistrationFormType extends AbstractType {

  /**
   * Build the form.
   *
   * @param \Symfony\Component\Form\FormBuilderInterface $builder
   *   The form builder.
   * @param array $options
   *   The form options.
   */
  public function buildForm(FormBuilderInterface $builder, array $options): void {
    $builder
      ->add('email')
      ->add('agreeTerms', CheckboxType::class, [
        'mapped' => FALSE,
        'constraints' => [
          new IsTrue([
            'message' => 'You should agree to our terms.',
          ]),
        ],
      ])
      ->add('plainPassword', PasswordType::class, [
              // Instead of being set onto the object directly,
              // this is read and encoded in the controller.
        'mapped' => FALSE,
        'attr' => ['autocomplete' => 'new-password'],
        'constraints' => [
          new NotBlank([
            'message' => 'Please enter a password',
          ]),
          new Length([
            'min' => 6,
            'minMessage' => 'Your password should be at least {{ limit }} characters',
                      // Max length allowed by Symfony for security reasons.
            'max' => 4096,
          ]),
        ],
      ]);
  }

  /**
   * Configure the form options.
   *
   * @param \Symfony\Component\OptionsResolver\OptionsResolver $resolver
   *   The option resolver.
   */
  public function configureOptions(OptionsResolver $resolver): void {
    $resolver->setDefaults([
      'data_class' => User::class,
    ]);
  }

}
