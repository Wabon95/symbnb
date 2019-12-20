<?php

namespace App\Form;

use App\Form\ApplicationType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class PasswordUpdateType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'oldPassword',
                PasswordType::class,
                $this->getConfiguration("Ancien mot de passe", "Renseignez votre mot de passe actuel...")
            )
            ->add(
                'newPassword',
                PasswordType::class,
                $this->getConfiguration("Nouveau mot de passe", "Renseignez votre nouveau mot de passe...")
            )
            ->add(
                'confirmPassword',
                PasswordType::class,
                $this->getConfiguration("Confirmation du mot de passe", "Confirmer votre nouveau mot de passe...")
            )
            ->add(
                'save', SubmitType::class, [
                    'label' => "Enregistrer",
                    'attr' => [
                        "class" => 'btn btn-primary'
                    ]
                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
