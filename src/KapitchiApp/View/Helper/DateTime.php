<?php
namespace KapitchiApp\View\Helper;

use Zend\Form\View\Helper\AbstractHelper;

/**
 * TODO usage of DateFormat view helper - I18n
 * @author Matus Zeman <mz@kapitchi.com>
 */
class DateTime extends AbstractHelper
{
    protected $formats = array(
        'full' => 'd.m.Y H:i'
    );
    
    protected $emptyValue = 'N/A';
            
    public function render($datetime, $type = 'full')
    {
        if(empty($datetime)) {
            //no datetime - is null
            return $this->getEmptyValue();
        }
        
        $formats = $this->getFormats();
        if(!isset($formats[$type])) {
            throw new \Exception("No format '$type'");
        }
        
        $format = $formats[$type];
        
        return $datetime->format($format);
    }
    
    public function getFormats() {
        return $this->formats;
    }
    
    public function setFormats(array $formats) {
        $this->formats = $formats;
    }
    
    public function getEmptyValue()
    {
        return $this->emptyValue;
    }

    public function setEmptyValue($emptyValue)
    {
        $this->emptyValue = $emptyValue;
    }

}