<?php

declare(strict_types=1);

namespace App\Controller\Account;

use App\Entity\User;
use App\Form\Security\UserPasswordType;
use App\Manager\UserManager;
use App\Model\UserPassword;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    /**
     * @Route("/account/password", name="change_password", methods={"GET", "POST"})
     * @param Request $request
     * @param UserManager $userManager
     * @return Response
     */
    public function changePasswordAction(Request $request, UserManager $userManager): Response
    {
        /** @var User $user */
        $user = $this->getUser();
        $userPassword = new UserPassword();
        $form = $this->createForm(UserPasswordType::class, $userPassword);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $userManager->changePassword($user, $userPassword->getNewPassword());
            } catch (\Exception $e) {
                return $e->getMessage();
            }
        }

        return $this->render('account/edit/password.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
