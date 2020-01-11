<?php

namespace App\Form\DataTransformer;

use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;

class FrenchToDateTimeTransformer implements DataTransformerInterface {

    // Méthode permettant de transformer une donnée originale avant d'afficher un formulaire, pour qu'elle s'affiche correctement dans le formulaire
    public function transform($date) {
        if ($date === null) return '';
        return $date->format('d/m/Y');
    }

    // Méthode permettant de transformer une donnée après l'envoit du formulaire, avant d'insérer la donnée dans l'entité.
    // Pour notre datepicker, on a typé les champs startDate et endDate en type Text dans notre formulaire. Alors que dans l'entité, ces propriétés sont typé comme étant de type DateTime
    // Il faut donc passer par le DataTransformer pour transformer la date à la base en format Text vers un format Datetime
    // Et ainsi éviter d'avoir une erreur nous indiquant que la date n'est pas au format DateTime
    public function reverseTransform($frenchDate) {
        if ($frenchDate === null) throw new TransformationFailedException("Vous devez fournir une date !");
        $date = \DateTime::createFromFormat('d/m/Y', $frenchDate);
        if ($date === false) throw new TransformationFailedException("Le format de la date n'est pas correct !");
        return $date;
    }
}