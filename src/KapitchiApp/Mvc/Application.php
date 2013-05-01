<?php

/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

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
        $app = $serviceManager->get('Application');
        $app->bootstrap();
        return $app;
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