<?php

namespace App\EventListener;

use App\Service\JsVars;
use Symfony\Component\HttpKernel\Event\ControllerEvent;

class JsVarsInitializeListener
{
    /**
     * @var JsVars
     */
    private $jsVars;

    /**
     * @var bool
     */
    private $appDebug;

    /**
     * @param JsVars $jsVars
     * @param bool   $appDebug
     */
    public function __construct(JsVars $jsVars, $appDebug)
    {
        $this->jsVars = $jsVars;
        $this->appDebug = $appDebug;
    }

    /**
     * Initialize js vars.
     *
     * @throws \Exception
     */
    public function onKernelController(ControllerEvent $event)
    {
        // JsVars service will only initialize for HTML request
        if ($event->getRequest()->isXmlHttpRequest()) {
            return;
        }

        // Simple variables
        $this->jsVars->debug = $this->appDebug;

        // Translations
        $this->jsVars->trans('app.title.add_customer');


        // Routes
        $this->jsVars->addRoute('client_address', ['id' => '__id__']);
        $this->jsVars->addRoute('search_product', ['id' => '__id__']);
        $this->jsVars->addRoute('new_quotationLine', ['id' => '__id__']);
        $this->jsVars->addRoute('remove_quotationLine', ['id' => '__id__']);
        //API
    }
}
