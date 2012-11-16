<?php
namespace KapitchiApp\PluginManager;

use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

/**
 * 
 * @author Matus Zeman <mz@kapitchi.com>
 */
abstract class AbstractPlugin implements PluginInterface, ServiceLocatorAwareInterface
{
    protected $serviceLocator;
    
    /**
     * Dummy translate method to support PoEdit
     * @param string $msg
     * @return string
     */
    public function translate($msg)
    {
        return $msg;
    }
    
    /**
     * Set service locator
     *
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

    /**
     * Get service locator
     *
     * @return ServiceLocatorInterface
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }
}