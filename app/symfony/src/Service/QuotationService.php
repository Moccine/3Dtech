<?php

namespace App\Service;
use App\Entity\Quotation;
use App\Tools\StringTools;
use Doctrine\ORM\EntityManagerInterface;
use Mpdf\Mpdf;
use Mpdf\Output\Destination;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class QuotationService
{

    /** @var Environment */
    private $twig;
    /** @var EntityManagerInterface */
    private $em;

    /**
     * QuotationService constructor.
     * @param Environment $twig
     * @param EntityManagerInterface $em
     */
    public function __construct(Environment $twig, EntityManagerInterface $em)
    {
        $this->twig = $twig;
        $this->em = $em;
    }

    public function generateQuotePDF(Quotation $quotation)
    {
      //  $filename = StringTools::slugify(sprintf('Muzeo devis %s  %s', $quotation->getProject(), $quotation->getDate()->format('Ymd')));
        $filename = 'facture';
        $filename .= '.pdf';
        $tempDir = '/tmp';
        $fullPath = $tempDir . '/' . $filename;

        try {
            $mpdf = new Mpdf([
                'tempDir' => '/tmp',
                'margin_top' => 11,
                'margin_left' => 11,
                'margin_right' => 11,
                'margin_bottom' => 0,
                'setAutoTopMargin' => 'stretch',
                'setAutoBottomMargin' => 'stretch',
            ]);

            $html = $this->twig->render('invoice/invoice.html.twig', ['quotation' => $quotation]);
            $header = $this->twig->render('invoice/header.html.twig');
            $footer = ($this->twig->render('invoice/footer.html.twig'));
            $mpdf->SetHTMLHeader($header);
            $mpdf->SetHTMLFooter($footer);
            $mpdf->WriteHTML($html);
            $mpdf->Output($fullPath, Destination::FILE);
            $response = new Response();
            $response->setStatusCode(200);
            $response->setContent(file_get_contents($fullPath));
            $response->headers->set('Content-type', 'application/force-download');
            $response->headers->set('Content-Transfer-Encoding', 'binary');
            $response->headers->set('Content-Length', filesize($fullPath));
            $response->headers->set('Content-disposition', 'attachment; filename=' . basename($fullPath));
            $response->headers->set('Pragma', 'no-cache');
            $response->headers->set('Expires', '0');

            unlink($fullPath);

            return $response;
        } catch (\Exception $exception) {
            dd($exception);
            return $exception->getMessage();
        }
    }


}
