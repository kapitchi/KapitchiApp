<?php
namespace KapitchiApp\View\Model;

use Zend\View\Model\ViewModel;

/**
 *
 * @author Matus Zeman <mz@kapitchi.com>
 */
class Paginator extends ViewModel
{
    protected $template = 'kapitchi-app/default/paginator';
    
    public function getPaginator() {
        return $this->__get('paginator');
    }
    
    
}