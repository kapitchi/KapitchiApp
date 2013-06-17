<?php

/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

namespace KapitchiApp\Controller;

use KapitchiEntity\Controller\EntityController;

class PluginController extends EntityController
{
    public function enableAction()
    {
        return $this->updatePluginEnabled(true);
    }
    
    public function disableAction()
    {
        return $this->updatePluginEnabled(false);
    }
    
    protected function updatePluginEnabled($status)
    {
        $service = $this->getEntityService();
        $entity = $service->get($this->getCurrentEntityId());
        
        $service->partialUpdate($entity, array(
            'enabled' => $status
        ));
        
        $msg = "Plugin '{$entity->getName()}' " . ($status ? 'enabled' : 'disabled');
        $this->flashMessenger()->addSuccessMessage($msg);
        
        $page = $this->getRequest()->getQuery()->get('redirect_page', 1);
        $this->redirect()->toRoute('app/plugin', array('action' => 'index'), array('query' => array('page' => $page)));
    }
    
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
