<?php
namespace KapitchiApp\Mapper;

/**
 * 
 * @author Matus Zeman <mz@kapitchi.com>
 */
interface NavigationInterface
{
    public function findByHandle($handle);
}