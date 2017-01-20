<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 16.01.2017
 * Time: 14:24
 */
class View
    implements Iterator, Countable


{

    protected $data = [];



    public function __set($k, $v)
    {
        $this->data[$k] = $v;
    }

    public function __get($k)
    {
      return $this->data[$k];
    }

    public function render($template)
    {

        foreach ($this->data as $key =>$val){
            $$key = $val;
        }
        ob_start();
        include __DIR__.'/../views/'.$template.'';
        $content = ob_get_contents();
        ob_get_clean();
        return $content;
    }

    public function display($template)
    {
        echo $this->render($template);
    }


    public function current()
    {
        // TODO: Implement current() method.
    }


    public function next()
    {
        // TODO: Implement next() method.
    }


    public function key()
    {
        // TODO: Implement key() method.
    }


    public function valid()
    {
        // TODO: Implement valid() method.
    }


    public function rewind()
    {
        // TODO: Implement rewind() method.
    }


    public function count()
    {
       return count($this->data);
    }
}