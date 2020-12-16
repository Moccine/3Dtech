<?php

namespace App\Controller\Admin;

use App\Entity\Admin;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/_easyadmin/logout", name="admin_logout", methods={"GET"})
     *
     * @throws \RuntimeException
     */
    public function logout()
    {
        throw new \RuntimeException('You must activate the logout in your security firewall configuration.');
    }

    /**
     * @Route("/_easyadmin/login", name="admin_login", methods={"GET","POST"})
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('@EasyAdmin/page/login.html.twig', [
            'error' => $error,
            'last_username' => $lastUsername,
            'translation_domain' => 'admin',
            'page_title' => 'Net rent',
            'csrf_token_intention' => 'authenticate',
            'target_path' => $this->generateUrl('easyadmin'),
            'username_label' => 'Identifiant',
            'password_label' => 'Mot de passe',
            'sign_in_label' => 'Log in',
            'username_parameter' => 'username',
            'password_parameter' => 'password',
        ]);
    }
}
