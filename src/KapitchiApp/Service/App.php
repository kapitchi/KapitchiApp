<?php

namespace KapitchiApp\Service;

use Zend\ServiceManager\Exception\ServiceNotFoundException;


/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class App extends \KapitchiBase\Service\AbstractService
{
    public function getDateTime()
    {
        return new \DateTime();
    }
}