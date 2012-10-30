<?php
namespace KapitchiApp\View\Helper;

use Zend\Form\View\Helper\AbstractHelper;

/**
 * @author Matus Zeman <mz@kapitchi.com>
 */
class AppPlugin extends AbstractHelper
{
    protected $pluginService;
    
    public function isEnabled($handle)
    {
        return $this->getPluginService()->isEnabled($handle);
    }
    
    public function getImpl($handle)
    {
        return $this->getPluginService()->getPluginManager()->get($handle);
    }
    
    public function getPluginService()
    {
        return $this->pluginService;
    }

    public function setPluginService($pluginService)
    {
        $this->pluginService = $pluginService;
    }
    
}