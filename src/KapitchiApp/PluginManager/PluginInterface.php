<?php

/**
 * Kapitchi Zend Framework 2 Modules (http://kapitchi.com/)
 *
 * @copyright Copyright (c) 2012-2013 Kapitchi Open Source Team (http://kapitchi.com/open-source-team)
 * @license   http://opensource.org/licenses/LGPL-3.0 LGPL 3.0
 */

namespace KapitchiApp\PluginManager;

use Zend\EventManager\EventInterface;

/**
 * 
 * @author Matus Zeman <mz@kapitchi.com>
 */
interface PluginInterface
{
    public function onBootstrap(EventInterface $e);
    public function getName();
    public function getVersion();
    public function getAuthor();
    public function getDescription();
}