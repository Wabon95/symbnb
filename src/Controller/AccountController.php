<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AccountType;
use App\Entity\PasswordUpdate;
use App\Form\RegistrationType;
use App\Form\PasswordUpdateType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController {

    /** @Route("/login", name="account_login") */
    public function login(AuthenticationUtils $utils) {
        $error = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();
        return $this->render('account/login.html.twig', [
            'hasError' => $error !== null,
            'username' => $username
        ]);
    }

    /** @Route("/logout", name="account_logout") */
    public function logout() {
    }

    /** @Route("/register", name="account_register") */
    public function register(Request $request, EntityManagerInterface $manager, UserPasswordEncoderInterface $encoder) {
        $user = new User();
        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setHash($encoder->encodePassword($user, $user->getHash()));
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success', 'Votre compte à bien été crée ! Vous pouvez dès à présent vous connecter.');

            return $this->redirectToRoute('account_login');
        }
        return $this->render('account/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /** @Route("/account/profile", name="account_profile") */
    public function profile(Request $request, EntityManagerInterface $manager) {
        $user = $this->getUser();
        $form = $this->createForm(AccountType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($user);
            $manager->flush();
            $this->addFlash('success', 'Les données du profil ont bien été enregistrée avec succès.');
        }
        return $this->render('account/profile.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /** @Route("/account/password-update", name="account_password") */
    public function updatePassword(Request $request, UserPasswordEncoderInterface $encoder, EntityManagerInterface $manager) {
        $passwordUpdate = new PasswordUpdate();
        $user = $this->getUser();
        $form = $this->createForm(PasswordUpdateType::class, $passwordUpdate);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // On vérifie que le nouveau mot de passe renseigné est bien différent du précédent
            if (password_verify($passwordUpdate->getNewPassword(), $user->getHash())) {
                $this->addFlash('warning', 'Votre nouveau mot de passe est identique au précédent.');
                return $this->redirectToRoute('account_password');
            } else {
                $user->setHash($encoder->encodePassword($user, $passwordUpdate->getNewPassword()));
                $manager->persist($user);
                $manager->flush();
                $this->addFlash('success', 'Votre mot de passe à bien été modifié.');
                return $this->redirectToRoute('account_logout');
            }
        }
        return $this->render('account/password.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
