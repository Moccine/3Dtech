<?php

declare(strict_types=1);

namespace App\Controller\Middle;

use App\Entity\Incident;
use App\Manager\UserManager;
use App\Service\Incident\ExportService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class IncidentController extends AbstractController
{
    /**
     * @Route("/middle/incidents", name="middle_incidents", methods={"GET", "POST"})
     * @Security("is_granted(constant('\\App\\Security\\Voter\\IncidentVoter::INCIDENT_CONSULT_LISTING'))")
     */
    public function listIncidents(UserManager $userManager): Response
    {
        $listIncidents = $userManager->getListIncidents();

        return $this->render('middle/incident/incidentList.html.twig', [
            'listIncident' => $listIncidents,
        ]);
    }

    /**
     * @Route("/middle/incident/{id}", name="middle_incident", methods={"GET", "POST"})
     * @Security("is_granted(constant('\\App\\Security\\Voter\\IncidentVoter::INCIDENT_CONSULT'))")
     */
    public function detailIncident(Incident $incident, UserManager $userManager): Response
    {
        return $this->render('middle/incident/incidentDetail.html.twig', [
            'incident' => $incident,
        ]);
    }

    /**
     * @Route("/middle/incident/{id}/close", name="middle_incident_close", methods={"GET", "POST"})
     * @Security("is_granted(constant('\\App\\Security\\Voter\\IncidentVoter::INCIDENT_CLOSE'))")
     */
    public function closeIncident(
        Incident $incident,
        UserManager $userManager,
        TranslatorInterface $translator
    ): Response {
        $userManager->closeIncident($incident);
        $this->addFlash('success', $translator->trans('app.flash.closeIncident'));

        $listIncidents = $userManager->getListIncidents($this->getUser());

        $this->redirectToRoute('middle_incidents');

        return $this->redirectToRoute('middle_incidents', [
            'listIncident' => $listIncidents,
        ]);
    }

    /**
     * @Route("/middle/incidents/export", name="middle_incidents_export", methods={"GET", "POST"})
     * @Security("is_granted(constant('\\App\\Security\\Voter\\IncidentVoter::INCIDENT_UPLOAD'))")
     */
    public function exportIncidents(ExportService $exportService): Response
    {
        $export = $exportService->getExportZip();

        $response = new Response(file_get_contents($export));
        $response->headers->set('Content-Type', 'text/csv; charset=windows-1252');
        $response->headers->set('Content-Type', 'application/zip');
        $response->headers->set('Content-Disposition', 'attachment;filename="'.$export.'"');
        $response->headers->set('Content-length', filesize($export));

        unlink($export);

        return $response;
    }
}
