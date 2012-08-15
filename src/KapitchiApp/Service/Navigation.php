<?php
namespace KapitchiApp\Service;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class Navigation
{
    protected $mapper;
    
    public function __construct($mapper)
    {
        $this->setMapper($mapper);
    }
    
    public function getByHandle($handle) {
        $nav = $this->getMapper()->findByHandle($handle);
        return $nav;
    }
    
    /**
     * 
     * @return \KapitchiApplication\Mapper\NavigationInterface
     */
    public function getMapper()
    {
        return $this->mapper;
    }

    public function setMapper(\KapitchiApplication\Mapper\NavigationInterface $mapper)
    {
        $this->mapper = $mapper;
    }

}