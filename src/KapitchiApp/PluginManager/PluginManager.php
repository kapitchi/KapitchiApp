<?php

/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

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