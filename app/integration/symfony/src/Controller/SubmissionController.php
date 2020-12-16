<?php

namespace App\Controller;

use App\Entity\Submission;
use App\Form\SubmissionType;
use App\Manager\SubmissionManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class SubmissionController extends AbstractController
{
    /**
     * @Route("/submission", name="add_submission")
     */
    public function add(Request $request, SubmissionManager $submissionManager)
    {
        $submission = new Submission();
        $form = $this->createForm(SubmissionType::class, $submission);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $submissionManager->create($submission);
        }

        return $this->render('submission/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
