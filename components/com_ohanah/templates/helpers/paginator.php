<?php

class ComOhanahTemplateHelperPaginator extends KTemplateHelperPaginator
{
    public function pagination($config = array())
    {
        $config = new KConfig($config);
        $config->append(array(
            'total'      => 0,
            'display'    => 4,
            'offset'     => 0,
            'limit'      => 0,
            'show_limit' => true,
            'show_count' => true
        ));
        
        $this->_initialize($config);
        
        $pages = $this->_items($config);

        $html = '';

        if (count($pages['pages']) > 1) {
            $html .= '<div id="filterFooter">';

            $pages = $this->_items($config);

            if ($config->current > 1) {
                $html .= $this->getTemplate()->renderHelper('button.button', array('type' => 'link', 'text' => JText::_('OHANAH_PAGINATOR_PREVIOUS_PAGE'), 'link' => $this->_getPageURL($pages['previous'])));                
            }
            
            $html .= $this->_pages($pages, $config->count, $config->current, $config->last);

            if ($config->current < $config->count) {
                $html .= $this->getTemplate()->renderHelper('button.button', array('type' => 'link', 'text' => JText::_('OHANAH_PAGINATOR_NEXT_PAGE'), 'link' => $this->_getPageURL($pages['next'])));
            }
            
            $html .= '</div>';   
        }

        return $html;
    }
    
    protected function _pages($pages, $count, $current, $last)
    {
        if (count($pages['pages']) > 1) {
            
            $html = '<span class="page">';

            $containsFirst = false;
            $containsLast = false;
            $firstInSeries = 0;
            $lastInSeries = 0;

            foreach($pages['pages'] as $page) {
                $html .= $this->_link($page, $page->page);

                if ($page->page == $pages['first']->page) $containsFirst = true;
                if ($page->page == $pages['last']->page) $containsLast = true;

                if (!$firstInSeries) $firstInSeries = $page->page;
                else if ($page->page < $firstInSeries) $firstInSeries = $page->page;
                if (!$lastInSeries) $lastInSeries = $page->page;
                else if ($page->page > $lastInSeries) $lastInSeries = $page->page;
            }

            if (!$containsFirst) {
                if ($current == 6 && $count >= 7) $html = $this->_link($pages['first'], 1).$html;
                if ($current >= 7) $html = $this->_link($pages['first'], 1).' .. '.$html;
            }

            if (!$containsLast) {
                if ($pages['last']->page - $lastInSeries > 1) $html .= ' .. '.$this->_link($pages['last'], $count);
                else $html .= $this->_link($pages['last'], $count);
            }

            $html .= '</span>';

            return $html;
        }
    }

    protected function _getPageURL($page) 
    {        
        $url   = clone KRequest::url();
        $query = $url->getQuery(true);

              //For compatibility with Joomla use limitstart instead of offset
        $query['limit']      = $page->limit;
        $query['limitstart'] = $page->offset;   
        
        $url->setQuery($query);

        return $url;
    }
    
    protected function _link($page, $title)
    {    
        $class = $page->current ? 'class="active"' : '';

        if($page->active && !$page->current) {
            $html = '<a href="'.$this->_getPageURL($page).'" '.$class.'>'.JText::_($title).'</a>';
        } else {
            $html = '<span '.$class.'>'.JText::_($title).'</span>';
        }

        return $html;
    }
}