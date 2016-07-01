<?php

namespace SendGridTransportModule;

use Exception;
use SendGrid;

/**
 * Class Module
 * @package SendGrid
 */
class Module
{

    /**
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__
                ),
            ),
        );
    }

    /**
     * @return array
     */
    public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'SendGridTransport' => function ($serviceManager) {
                    $config = $serviceManager->get('config')['mail'];

                    if (!isset($config['sendgrid'])) {
                        throw new Exception('You must to copy the file "sendgrid.global.php.dist" to your config/autoload and set your API Key');
                    }
                    
                    $sendGrid = new SendGrid($config['sendgrid']['api_key']);
                    $email = new SendGrid\Email();

                    return new SendGridTransport($sendGrid, $email);
                },
            ),
        );
    }
}
