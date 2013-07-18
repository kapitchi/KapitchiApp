<?php

/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

namespace KapitchiApp\Service;

use Zend\ServiceManager\Exception\ServiceNotFoundException;


/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class Plugin extends \KapitchiEntity\Service\EntityService
{
    protected $pluginManager;
    
    protected $canonicalNamesReplacements = array('-' => '', '_' => '', ' ' => '', '\\' => '', '/' => '');
    
    public function bootstrapEnabledPlugins(\Zend\EventManager\EventInterface $e)
    {
        $plugins = $this->fetchAll(array(
            'enabled' => true
        ));
        
        $pluginManager = $this->getPluginManager();
        foreach($plugins as $plugin) {
            $handle = $plugin->getHandle();
                
            if(!$pluginManager->has($handle)) {
                $this->getMapper()->remove($plugin);
            }
            
            $pluginManager->bootstrapPlugin($e, $handle);
        }
    }
    
    public function findByHandle($handle) {
        $handle = strtolower(strtr($handle, $this->canonicalNamesReplacements));
        return $this->findOneBy(array(
            'handle' => $handle
        ));
    }
    
    public function isEnabled($handle)
    {
        $plugin = $this->findByHandle($handle);
        if(!$plugin) {
            //throw new \Exception("Not existing plugin '$handle'");
            return false;
        }
        
        return (bool)$plugin->getEnabled();
    }
    
    /**
     * TODO
     */
    public function syncWithPluginManager()
    {
        $pluginManager = $this->getPluginManager();
        
        $canHandles= $pluginManager->getCanonicalNames();
        $handles = array_unique(array_values($canHandles));
        
        $mapper = $this->getMapper();
        
        foreach($handles as $handle) {
            $plugin = $pluginManager->get($handle);
            
            //TODO we really need Mapper::findOneBy() method!
            $entity = $mapper->getPaginatorAdapter(array(
                'handle' => $handle
            ))->getItems(0, 1)->current();
        
            if(!$entity) {
                //create new if it does not exist yet
                $entity = $this->createEntityFromArray(array(
                    'handle' => $handle,
                    'enabled' => 0
                ));
            }
            
            $this->getHydrator()->hydrate(array(
                'name' => $plugin->getName(),
                'description' => $plugin->getDescription(),
                'author' => $plugin->getAuthor(),
                'version' => $plugin->getVersion(),
            ), $entity);
            
            $mapper->persist($entity);
        }
        
        $res = $mapper->getPaginatorAdapter(array());
        $plugins = $res->getItems(0, (int)$res->count());
        
        foreach($plugins as $plugin) {
            $handle = $plugin->getHandle();
            if(!in_array($handle, $handles)) {
                $mapper->remove($plugin);
            }
        }
    }

    /**
     * @return \KapitchiApp\PluginManager\PluginManager
     */
    public function getPluginManager()
    {
        return $this->pluginManager;
    }

    public function setPluginManager(\KapitchiApp\PluginManager\PluginManager $pluginManager)
    {
        $this->pluginManager = $pluginManager;
    }
}