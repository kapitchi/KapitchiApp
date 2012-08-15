<?php

return array(
    'view_helpers' => array(
        'invokables' => array(
           'datetime' => 'KapitchiApp\View\Helper\DateTime',   
           'valueformatter' => 'KapitchiApp\View\Helper\ValueFormatter',   
        ),
        'factories' => array(
            'appPlugin' => function($sm) {
                $ins = new KapitchiApp\View\Helper\AppPlugin();
                $ins->setPluginService($sm->getServiceLocator()->get('KapitchiApp\Service\Plugin'));
                return $ins;
            }
        )
    ),
    'service_manager' => array(
        'factories' => array(
            'translator' => 'Zend\I18n\Translator\TranslatorServiceFactory',
        ),
    ),
    'navigation' => array(
        'default' => array()
    ),
    'router' => array(
        'routes' => array(
            'kapitchi-app' => array(
                'type'    => 'Literal',
                'options' => array(
                    'route'    => '/app',
                    'defaults' => array(
                        '__NAMESPACE__' => 'KapitchiApp\Controller',
                    ),
                ),
                'may_terminate' => false,
                'child_routes' => array(
                    'default' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/[:controller[/:action]]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                            ),
                        ),
                    ),
                    'plugin' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/plugin[/:action[/:id]]',
                            'constraints' => array(
                                'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'Plugin',
                            ),
                        ),
                    ),
                    'api' => array(
                        'type'    => 'Literal',
                        'options' => array(
                            'route'    => '/api',
                            'defaults' => array(
                                '__NAMESPACE__' => 'KapitchiApp\Controller\Api',
                            ),
                        ),
                        'may_terminate' => false,
                        'child_routes' => array(
                            'plugin' => array(
                                'type'    => 'Segment',
                                'options' => array(
                                    'route'    => '/plugin[/:action][/:id]',
                                    'constraints' => array(
                                        'action'     => '[a-zA-Z][a-zA-Z0-9_-]*',
                                    ),
                                    'defaults' => array(
                                        'controller' => 'Plugin',
                                    ),
                                ),
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),
);
