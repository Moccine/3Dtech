<?php

declare(strict_types=1);

namespace App\Controller\Middle;

use App\Form\Security\LoginMiddleType;
use App\Form\Security\OperatorPasswordType;
use App\Form\Security\UserPasswordType;
use App\Manager\OperatorManager;
use App\Model\OperatorPassword;
use App\Model\UserPassword;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/middle/login", name="middle_login", methods={"GET","POST"})
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils): Response
    {
        $form = $this->createForm(LoginMiddleType::class, [
            'email' => $authenticationUtils->getLastUsername(),
        ]);

        return $this->render('security/loginMiddle.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/middle/password", name="middle_change_password", methods={"GET", "POST"})
     */
    public function changePassword(Request $request, OperatorManager $operatorManager): Response
    {
        $operator = $this->getUser();

        $operatorPassword = new OperatorPassword();
        $form = $this->createForm(OperatorPasswordType::class, $operatorPassword);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $operatorManager->changePassword($operator, $operatorPassword->getNewPassword());
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }

        return $this->render('middle/edit/password.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/middle/logout", name="middle_logout")
     */
    public function logout()
    {
    }
}
