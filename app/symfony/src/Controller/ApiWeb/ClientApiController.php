<?php

namespace  App\Controller\ApiWeb;

use App\Entity\Address;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Client;

class ClientApiController extends AbstractController
{
    /**
     * @Route("/client/address/{id}", name="client_address")
     * @param Client $client
     * @return JsonResponse
     */
    public function clientAddressAction(Client $client)
    {
        $data = [
            'adddress' => $client->getStreet(),
            'postalCode' => $client->getPostalCode(),
            'city' => $client->getCity(),
            'Country' => $client->getCountry(),
        ];

        return $this->json($data);
    }
}
