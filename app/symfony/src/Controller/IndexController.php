<?php

namespace App\Controller;

use App\Entity\AskOfQuote;
use App\Entity\NewsLetter;
use App\Entity\SlideShow;
use App\Entity\User;
use App\Form\NewsLetterType;
use App\Manager\AskQuoteManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    /**
     * @Route("/", name="3dtech_index")
     */
    public function index(Request $request, AskQuoteManager $askQuoteManager)
    {
        return $this->render('home/index.html.twig', [
            'slideShow' => '',
        ]);
    }

    /**
     * @Route("/partners", name="3dtech_partners")
     */
    public function partners()
    {
        return $this->render('home/partners.html.twig');
    }
}
