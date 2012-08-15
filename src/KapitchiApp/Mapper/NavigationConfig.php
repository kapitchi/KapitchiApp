<?php
namespace KapitchiApp\Mapper;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class NavigationConfig implements NavigationInterface
{
    protected $config;
    
    public function findByHandle($handle)
    {
        $config = $this->getConfig();
        if(!isset($config[$handle])) {
            return null;
        }
        
        $pages = $config[$handle];
        
        $nav = new \Zend\Navigation\Navigation($pages);
        return $nav;
    }
    
    public function getConfig()
    {
        return $this->config;
    }

    public function setConfig($config)
    {
        $this->config = $config;
    }
}