<?php
namespace KapitchiApp\View\Helper;

use Zend\Form\View\Helper\AbstractHelper;

/**
 * TODO This needs to be implemented properly - hardcoded for now!
 * @author Matus Zeman <mz@kapitchi.com>
 */
class ValueFormatter extends AbstractHelper
{
    public function render($value, $type)
    {
        switch ($type) {
            case 'bool':
            case 'boolean':
                if((bool)$value) {
                    $ret = 'Enabled';
                }
                else {
                    $ret = 'Disabled';
                }
                break;
            default:
                throw new \Exception("How to render '$type' type?");
        }
        
        return $ret;
    }
    
}