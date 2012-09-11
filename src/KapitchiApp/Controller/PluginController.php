<?php
namespace KapitchiApp\Controller;

use KapitchiEntity\Controller\AbstractEntityController;

class PluginController extends AbstractEntityController
{
    public function getIndexUrl()
    {
        return $this->url()->fromRoute('app/plugin', array(
            'action' => 'index'
        ));
    }

    public function getUpdateUrl($entity)
    {
        return $this->url()->fromRoute('app/plugin', array(
            'action' => 'update', 'id' => $entity->getId()
        ));
    }
    
    public function syncAction()
    {
        $this->getEntityService()->syncWithPluginManager();
        return $this->redirect()->toUrl($this->getIndexUrl());
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
