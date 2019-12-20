<?php

namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;

class PasswordUpdate
{
    /**
     * @SecurityAssert\UserPassword(message="Votre mot de passe actuel est éroné.")
     */
    private $oldPassword;

    /**
     * @Assert\length(min=8, minMessage="Votre mot de passe doit contenir au moins {{ limit }} caractères.")
     */
    private $newPassword;

    /**
     * @Assert\EqualTo(propertyPath="newPassword", message="Vous devez correctement confirmer votre nouveau mot de passe.")
     */
    private $confirmPassword;

    public function getOldPassword(): ?string
    {
        return $this->oldPassword;
    }

    public function setOldPassword(string $oldPassword): self
    {
        $this->oldPassword = $oldPassword;

        return $this;
    }

    public function getNewPassword(): ?string
    {
        return $this->newPassword;
    }

    public function setNewPassword(string $newPassword): self
    {
        $this->newPassword = $newPassword;

        return $this;
    }

    public function getConfirmPassword(): ?string
    {
        return $this->confirmPassword;
    }

    public function setConfirmPassword(string $confirmPassword): self
    {
        $this->confirmPassword = $confirmPassword;

        return $this;
    }
}
