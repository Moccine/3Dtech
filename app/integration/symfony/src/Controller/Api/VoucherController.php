<?php

declare(strict_types=1);

namespace App\Controller\Api;

use App\Entity\Voucher;
use App\Form\VoucherType;
use App\Manager\VoucherManager;
use OpenApi\Annotations as OA;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @OA\Info(title="Voucher Api", version="1.0")
 */
class VoucherController extends AbstractController
{
    /**
     * @OA\Post(
     *     path="/api/voucher.json",
     *     @OA\Response(response="200", description="create voucher")
     * )
     *  @OA\Put(
     *     path="/api/voucher{id}.json",
     *     @OA\Response(response="200", description="update voucher")
     * )
     *
     * @Route("api/voucher/", name="api_voucher_create", methods={"POST"})
     * @Route("api/voucher/{id}", name="api_voucher_update", methods={"PUT"})
     */
    public function voucherAction(Request $request, ?Voucher $voucher, VoucherManager $voucherManager)
    {
        if (!$voucher instanceof Voucher) {
            $voucher = new Voucher();
        }

        $form = $this->createForm(VoucherType::class, $voucher);
        $data = ([
            'machine' => $request->query->get('machine'),
            'order' => $request->query->get('order'),
        ]);
        $form->submit($data);

        if (!$form->isValid()) {
            return new JsonReponse(null, Response::HTTP_BAD_REQUEST);
        }

        if (false == (null === $voucher->getId())) {
            $voucherManager->update($voucher);
        } else {
            $voucherManager->create($voucher);
        }

        return new JsonResponse(['success' => 200]);
    }
}
