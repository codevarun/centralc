<?php

class ComOhanahDatabaseBehaviorSluggable extends KDatabaseBehaviorSluggable
{
    /**
     * Override to use our filter that takes care of J1.6/1.7 unicode aliases
     *
     * @return void
     */
    protected function _createFilter()
    {
        $config = array();
        $config['separator'] = $this->_separator;

        if(!isset($this->_length)) {
            $config['length'] = $this->getTable()->getColumn('slug')->length;
        } else {
            $config['length'] = $this->_length;
        }

        $filter = null;

        //Create the filter
        $filter = $this->getService('com://admin/ohanah.filter.slug', $config);

        return $filter;
    }
    
    /**
     * Override to add dash fix
     *
     * @return void
     */
    protected function _createSlug()
    {
        //Create the slug filter
        $filter = $this->_createFilter();
        
        if(empty($this->slug))
        {
            $slugs = array();
            foreach($this->_columns as $column) {
                $slugs[] = $filter->sanitize($this->$column);
            }

            $this->slug = implode($this->_separator, array_filter($slugs));
            
            //Canonicalize the slug
            $this->_canonicalizeSlug();
        }
        else
        {
            if(in_array('slug', $this->getModified())) 
            {
                $this->slug = $filter->sanitize($this->slug);
                
                //Canonicalize the slug
                $this->_canonicalizeSlug();
            }
        }
    }
}