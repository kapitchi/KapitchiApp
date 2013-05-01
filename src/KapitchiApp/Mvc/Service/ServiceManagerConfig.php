<?php

/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

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
