<?php

declare(strict_types=1);

namespace App\Controller\Account;

use App\Entity\Incident;
use App\Form\IncidentType;
use App\Manager\IncidentManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IncidentController extends AbstractController
{
    /**
     * @Route("/account/incident", name="account_incident", methods={"GET", "POST"})
     * @Security("is_granted(constant('\\App\\Security\\Voter\\IncidentVoter::INCIDENT_CREATE'))")
     * @param Request $request
     * @param IncidentManager $incidentManager
     * @return Response
     */
    public function add(Request $request, IncidentManager $incidentManager): Response
    {
        $incident = new Incident();

        $form = $this->createForm(IncidentType::class, $incident);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $incident->setUser($this->getUser());
            $incidentManager->create($incident);
        }

        return $this->render('account/incident/incident.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/account/incidents", name="account_incidents", methods={"GET", "POST"})
     * @Security("is_granted(constant('\\App\\Security\\Voter\\IncidentVoter::INCIDENT_CONSULT_LISTING'))")
     */
    public function listIncidents(): Response
    {
        return $this->render('account/incident/incidentList.html.twig', [
            'listIncident' => $this->getUser()->getIncidents(),
        ]);
    }
}
