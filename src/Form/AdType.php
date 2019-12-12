<?php

namespace App\Form;

use App\Entity\Ad;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AdType extends AbstractType
{
    /**
     * Permet d'avoir la configuration de base d'un champ
     * @param string $label
     * @param string $placeholder
     * @return array
     */
    private function getConfiguration(string $label, string $placeholder): array {
        return [
            'label' => $label,
            'attr' => [
                'placeholder' => $placeholder
            ]
        ];
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, $this->getConfiguration('Titre', 'Veuillez renseigner un titre pour votre annonce'))
            ->add('coverImage', UrlType::class, $this->getConfiguration('URL de l\'image principale', 'Veuillez renseigner une adresse url de l\'image principale'))
            ->add('introduction', TextType::class, $this->getConfiguration('Introduction', 'Veuillez renseigner une description globale'))
            ->add('content', TextareaType::class, $this->getConfiguration('Description détaillée', 'Veuillez renseigner une description détaillée'))
            ->add('rooms', IntegerType::class, $this->getConfiguration('Nombre de chambres', 'Veuillez renseigner le nombre de chambres disponibles'))
            ->add('price', MoneyType::class, $this->getConfiguration('Prix par nuit', 'Veuillez renseigner le prix d\'une nuit'))
            ->add('save', SubmitType::class, [
                'label' => 'Créer l\'annonce',
                'attr' => [
                    "class" => 'btn btn-primary'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Ad::class,
        ]);
    }
}
