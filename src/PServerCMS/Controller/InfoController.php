<?php


namespace PServerCMS\Controller;

use PServerCMS\Helper\HelperService;
use PServerCMS\Helper\HelperServiceLocator;
use Zend\Mvc\Controller\AbstractActionController;

class InfoController extends AbstractActionController
{
    use HelperServiceLocator, HelperService;

    public function onlinePlayerAction()
    {
        /** @var \Zend\Http\PhpEnvironment\Response $response */
        $response = $this->getResponse();
        $response->getHeaders()->addHeaderLine('Content-Type', "image/png");

        $this->getPlayerHistory()->outputCurrentPlayerImage();

        $response->setStatusCode(200);

        return $response;
    }
}