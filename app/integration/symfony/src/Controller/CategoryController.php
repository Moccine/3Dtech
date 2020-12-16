<?php

namespace App\Controller;

use App\Akeneo\AkeneoService;
use App\Akeneo\AttributeOptionService;
use App\Akeneo\AttributeService;
use App\Akeneo\ProductService;
use App\Entity\Category;
use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/index", name="ondex")
     *
     * @return Response
     */
    public function index(Request $request,
                          AkeneoService $akeneoService,
                          AttributeService $attributeService,
                          ProductService $productService,
                          AttributeOptionService $attributeOptionService
    ) {
        $akeneoService->upsertProduct();
        // creation de groupe d'attribut

        //createtion d'attribute
        //creation d'options
        //creation de famille
        // creation de produit

        $form = $this->createForm(CategoryType::class, new Category());
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()) {
            $datas = $request->request->all();
            $ids = $datas['category']['code'];
        }

        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
            'form' => $form->createView(),
        ]);
    }

    public function getResources()
    {
        return [
        ];
    }
}
