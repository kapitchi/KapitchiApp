<?php

/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

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