<?php

namespace KapitchiApp\PluginManager;

use Zend\ServiceManager\AbstractPluginManager;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class PluginManager extends AbstractPluginManager
{
    protected $bootstrappedPlugins;
    
    public function bootstrapPlugin($e, $pluginName)
    {
        $pluginName = $this->canonicalizeName($pluginName);
        
        $plugin = $this->get($pluginName);
        $plugin->onBootstrap($e);
        $this->bootstrappedPlugins[$pluginName] = $plugin;
    }
    
    /**
     * TODO - implement according the spec of AbstractPluginManager
     */
    public function validatePlugin($plugin)
    {
        if(!$plugin instanceof PluginInterface) {
            throw new \Exception("Not PluginInterface object");
        }
        
    }
}