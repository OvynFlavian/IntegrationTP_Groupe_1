<?php
/**
 * Created by PhpStorm.
 * User: Flavian Ovyn
 * Date: 28/09/2015
 * Time: 11:14
 */

class User {
    private function __hydrate(array $tab)
    {
        foreach($tab as $key => $value)
        {
            $method = 'set'. $key;
            if(method_exists($this,$method))$this->$method($value);
        }
    }
    public function __construct(array $tab)
    {
        $this->__hydrate($tab);
    }

}