<?php
namespace KapitchiApp\Controller;

use KapitchiEntity\Controller\EntityContoller;

class PluginController extends EntityContoller
{
    
    protected function attachDefaultListeners()
    {
        parent::attachDefaultListeners();
        
        $events = $this->getEventManager();
        $instance = $this;
        
        $events->attach('index.pre', function($e) use ($instance) {
            $instance->getEntityService()->syncWithPluginManager();
        });
    }
}
