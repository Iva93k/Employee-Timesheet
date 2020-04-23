<?php
/* src/View/Helper/Iva.php */
namespace App\View\Helper;

use Cake\View\Helper;

class UIElementsHelper extends Helper
{
    public function pagination($paginator = null)
    {
    	if(empty($paginator))
    		return "";

    	$html = '<div class="paginator">';
    		$html .= '<ul class="pagination">';
    			$html .= $paginator->first('<< ' . __('first'));
    			$html .= $paginator->prev('<< ' . __('previous'));
    			$html .= $paginator->numbers();
    			$html .= $paginator->next(__('next') . ' >');
    			$html .= $paginator->last(__('last') . ' >');
    		$html .= '</ul>';
    		$html .= '<p>';
    		$html .= $paginator->counter(['format' => __('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')]);
    		$html .= '</p>';
    	$html .= '</div>';

    	return $html;
    }

    public function breadcrumb($items = [])
    {
    	$html = '<ul class="breadcrumb">';
    	
    	foreach ($items as $item) 
    	{
    		$html .= '<li>';

    		if(!isset($item['url']))
    			$item['url'] = '#';
    		if(!isset($item['title']))
    			$item['title'] = '';
        		
        		if($item['url'] === false)
        			$html .= '<span>';
        		else
        			$html .= '<a href="' . $item['url'] . '">';
            	
            	if(isset($item['iconClass']) && !empty($item['iconClass']))
            		$html .= '<i class="' . $item['iconClass'] . '"></i> ';

            		$html .= $item['title'];

            	if($item['url'] === false)
            		$html .= '</span>';
            	else
            		$html .= '</a>';

            $html .= '</li>';
        }

		$html .= '</ul>';

		return $html;
    }

   	public function alertBar($options = [])
    {
        $alertType = 'info';
        $message = __('No results found!');

        if(isset($options['message']) && !empty($options['message']))
        	$message = $options['message'];

        if(isset($options['type']) && !empty($options['type']))
        	$alertType = $options['type'];

        $html = '<div class="alert alert-' . $alertType . ' col-lg-8 col-md-offset-2">';
        	$html .= '<p align="center">' . $message . '</p>';
        $html .= '</div>';

        return $html;   
    }
}