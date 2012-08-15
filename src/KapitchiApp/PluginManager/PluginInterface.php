<?php
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