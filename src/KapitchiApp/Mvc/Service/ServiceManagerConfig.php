<?php
namespace KapitchiApp\Mvc\Service;

use Zend\ServiceManager\ServiceManager;

class ServiceManagerConfig extends \Zend\Mvc\Service\ServiceManagerConfig
{
    public function configureServiceManager(ServiceManager $serviceManager)
    {
        parent::configureServiceManager($serviceManager);
        
        $serviceManager->addInitializer(function ($instance) use ($serviceManager) {
            if($instance instanceof \KapitchiBase\ServiceManager\InitializerInitEvent) {
                $instance->getEventManager()->trigger('init', $instance);
            }
        }, false);
    }
}
