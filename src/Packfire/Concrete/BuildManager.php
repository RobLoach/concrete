<?php

/**
 * Packfire Concrete
 * By Sam-Mauris Yong
 * 
 * Released open source under New BSD 3-Clause License.
 * Copyright (c) 2012, Sam-Mauris Yong Shan Xian <sam@mauris.sg>
 * All rights reserved.
 */

namespace Packfire\Concrete;

use Symfony\Component\Finder\Finder;

/**
 * Build Set Management
 * 
 * @author Sam-Mauris Yong <sam@mauris.sg>
 * @copyright 2012 Sam-Mauris Yong Shan Xian <sam@mauris.sg>
 * @license http://www.opensource.org/licenses/BSD-3-Clause The BSD 3-Clause License
 * @package \Packfire\Concrete
 * @since 1.1.0
 * @link https://github.com/packfire/concrete
 */
class BuildManager{
    
    /**
     * Processed build set result
     * @var array
     * @since 1.1.0
     */
    private $result;
    
    /**
     * Process a build set
     * @param object $set The build configuration set
     * @return array Returns the complete process set
     * @since 1.1.0
     */
    public function process($set){
        $this->result = array();
        $this->processBuildSet($set);
        return $this->result;
    }
    
    /**
     * Process a build set recursively
     * @param object $set The build configuration set
     * @since 1.1.0
     */
    protected function processBuildSet($set){
        foreach($set->build as $entry){
            if(is_object($entry)){
                $this->processBuildSet($entry);
            }else{
                $find = new Finder();
                if(is_dir($entry)){
                    $find->files()
                         ->in($entry);
                }elseif(is_file($entry)){
                    $find->files()
                         ->depth('== 0')
                         ->name(basename($entry))
                         ->in(dirname($entry));
                }else{
                    $find = array();
                }
                foreach($find as $file){
                    $this->result[] = $file;
                }
            }
        }
    }
    
}