<?php

namespace KapitchiApp\PluginManager;

use Zend\ServiceManager\AbstractPluginManager;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class PluginManager extends AbstractPluginManager
{
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