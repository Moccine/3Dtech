<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SitemapController extends AbstractController
{
    /**
     * @Route(path="/sitemap.{_format}", defaults={"_format"="xml"}, name="sitemap", methods={"GET"})
     */
    public function sitemap(): Response
    {
        return $this->render('front/default/sitemap.xml.twig');
    }
}
