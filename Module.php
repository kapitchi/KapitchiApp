<?php

namespace KapitchiApp;

use Zend\EventManager\EventInterface,
    KapitchiBase\ModuleManager\AbstractModule,
    Zend\ModuleManager\Feature\ServiceProviderInterface,
    Zend\ModuleManager\Feature\ControllerProviderInterface,
    KapitchiEntity\Mapper\EntityDbAdapterMapper,
    KapitchiEntity\Mapper\EntityDbAdapterMapperOptions;

class Module extends AbstractModule implements ServiceProviderInterface, ControllerProviderInterface
{
    
    public function onBootstrap(EventInterface $e)
    {
        parent::onBootstrap($e);
        
        $em = $e->getApplication()->getEventManager();
        $sm = $e->getApplication()->getServiceManager();
        
        //TODO mz: this should be ran after all modules are loaded -- EVENT_LOAD_MODULES_POST?
        $sm->get('KapitchiApp\Service\Plugin')->bootstrapEnabledPlugins($e);
    }
    
    public function getControllerConfig()
    {
        return array(
            'factories' => array(
                'KapitchiApp\Controller\Plugin' => function($sm) {
                    $cont = new Controller\PluginController();
                    $cont->setEntityService($sm->getServiceLocator()->get('KapitchiApp\Service\Plugin'));
                    return $cont;
                },
                //API
                'KapitchiApp\Controller\Api\Plugin' => function($sm) {
                    $cont = new Controller\Api\PluginRestfulController(
                        $sm->getServiceLocator()->get('KapitchiApp\Service\Plugin')
                    );
                    return $cont;
                },
            )
        );
    }

    public function getServiceConfig()
    {
        return array(
            'invokables' => array(
                'KapitchiApp\Entity\Plugin' => 'KapitchiApp\Entity\Plugin',
            ),
            'factories' => array(
                'KapitchiApp\PluginManager\PluginManager' => 'KapitchiApp\PluginManager\PluginManagerFactory',
                        
                //Plugin
                'KapitchiApp\Service\Plugin' => function ($sm) {
                    $ins = new Service\Plugin(
                        $sm->get('KapitchiApp\Mapper\PluginDbAdapter'),
                        $sm->get('KapitchiApp\Entity\Plugin'),
                        $sm->get('KapitchiApp\Entity\PluginHydrator')
                    );
                    $ins->setPluginManager($sm->get('KapitchiApp\PluginManager\PluginManager'));
                    return $ins;
                },
                'KapitchiApp\Mapper\PluginDbAdapter' => function ($sm) {
                    return new EntityDbAdapterMapper(
                        $sm->get('Zend\Db\Adapter\Adapter'),
                        new EntityDbAdapterMapperOptions(array(
                            'tableName' => 'app_plugin',
                            'primaryKey' => 'id',
                            'hydrator' => $sm->get('KapitchiApp\Entity\PluginHydrator'),
                            'entityPrototype' => $sm->get('KapitchiApp\Entity\Plugin'),
                        ))
                    );
                },
                'KapitchiApp\Entity\PluginHydrator' => function ($sm) {
                    return new \Zend\Stdlib\Hydrator\ClassMethods(false);
                },
            )
        );
    }
    
    public function getDir() {
        return __DIR__;
    }

    public function getNamespace() {
        return __NAMESPACE__;
    }

}