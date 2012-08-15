<?php
namespace KapitchiApp\PluginManager;

use Zend\ServiceManager\Config as ServiceConfig,
    Zend\ServiceManager\FactoryInterface,
    Zend\ServiceManager\ServiceLocatorInterface;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class PluginManagerFactory implements FactoryInterface
{
    
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $config = $serviceLocator->get('Config');
        $pluginConfig = empty($config['plugin_manager']) ? array() : $config['plugin_manager'];
        
        $pluginManager = new PluginManager();
        
        $serviceConfig = new ServiceConfig($pluginConfig);
        $serviceConfig->configureServiceManager($pluginManager);
        
        return $pluginManager;
    }
}