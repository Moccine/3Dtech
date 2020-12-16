<?php

declare(strict_types=1);

namespace App\Controller\Account;

use App\Form\Security\ClientType;
use App\Manager\ClientManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{
    /**
     * @Route("/account/client", name="edit_profile", methods={"GET", "POST"})
     */
    public function editAction(Request $request, ClientManager $clientManager): Response
    {
        $user = $this->getUser();
        $form = $this->createForm(ClientType::class, $user->getClient());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            try {
                $clientManager->edit($user);
            } catch (Exception $e) {
                return $e->getMessage();
            }
        }

        return $this->render('account/edit/profile.html.twig', [
            'form' => $form->createView(),
            'user' => $user,
        ]);
    }
}
