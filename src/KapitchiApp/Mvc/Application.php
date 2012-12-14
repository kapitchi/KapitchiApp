<?php

namespace KapitchiApp\Mvc;

use Zend\EventManager\EventManagerInterface;
use Zend\ServiceManager\ServiceManager;

class Application extends \Zend\Mvc\Application
{
    public static function init($configuration = array())
    {
        $smConfig = isset($configuration['service_manager']) ? $configuration['service_manager'] : array();
        //mz: use our service manager config
        $serviceManager = new ServiceManager(new Service\ServiceManagerConfig($smConfig));
        $serviceManager->setService('ApplicationConfig', $configuration);
        $moduleManager = $serviceManager->get('ModuleManager');
        
        //mz: TODO we should in different way... hack for now
        $moduleManager->getEventManager()->attach(\Zend\ModuleManager\ModuleEvent::EVENT_LOAD_MODULES_POST, function($e) {
            //$e->getParam('ServiceManager')->get('KapitchiApp\Service\Module')->onLoadModulesPost($e);
        });
        
        $moduleManager->loadModules();
        return $serviceManager->get('Application')->bootstrap();
    }
    
    public function setEventManager(EventManagerInterface $eventManager)
    {
        $eventManager->setIdentifiers(array(
            'Zend\Mvc\Application',
            __CLASS__,
            get_called_class(),
        ));
        $this->events = $eventManager;
        return $this;
    }
}