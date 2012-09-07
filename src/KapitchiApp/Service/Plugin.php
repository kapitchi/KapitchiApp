<?php

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
        $plugins = $this->getPaginator(array(
            'enabled' => true
        ));
        $plugins->setItemCountPerPage(9999);
        
        $pluginManager = $this->getPluginManager();
        foreach($plugins as $plugin) {
            try {
                $handle = $plugin->getHandle();
                $pluginImp = $pluginManager->get($handle);
                $pluginImp->onBootstrap($e);
            } catch(ServiceNotFoundException $e) {
                //mz: plugin is not registered - remove it for now.
                //in the future we want to disable it so we keep e.g. plugin options?
                $this->remove($plugin);
            }
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
        
        foreach($handles as $handle) {
            $plugin = $pluginManager->get($handle);
            
            $entity = $this->findByHandle($handle);
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
            
            $this->persist($entity);
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