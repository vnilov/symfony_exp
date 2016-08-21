<?php
/**
 * User: vnilov
 * Date: 8/15/16
 */

namespace AppBundle\API;


use Symfony\Component\Config\Definition\Exception\Exception;

class PhraseGenerator
{
    public $entities;
    
    private $data = null;
    private $codes = [
      500 => "Invalid request params", 
      404 => "Element not found",
      422 => "Validation error",
      503 => "Something goes wrong"  
    ];
    private static $instance;
    
    protected function __construct() {}
    private function __clone() {}
    private function __wakeup() {}
    
    public static function i() {
        if (static::$instance === null){
            static::$instance = new static();
        }
        return static::$instance;
    }
    
    private $error_message = ['error' => ""];
    
    private  function getError($code) {
        $this->error_message['error'] = $this->codes[$code];
        return $this->error_message;
    }
    
    private function setResponse($code) {
        if (isset($this->codes[$code])) {
            return ['code' => $code, 'response' => $this->getError($code)];
        } else {
            if (!isset($this->data)) {
                $code = 503;
                return ['code' => $code, 'response' => $this->getError($code)];
            }
            return ['code' => $code, 'response' => $this->data];   
        }
    }

    function get($id = null)
    {
        if (isset($id)) {
            if (isset($this->entities[$id])) {
                $this->data = [$id => $this->entities[$id]];
                $code = 200;
            } else {
                $code = 404;
            }
        } else {
            $code = 500;
        }
        return $this->setResponse($code);
    }

    function getAll()
    {
        if (count($this->entities)>0) {
            $this->data = $this->entities;
            $code = 200;
        } else {
            $code = 404;
        }
        
        return $this->setResponse($code);
    }

    function create($phrase)
    {
        if (isset($phrase) && strlen($phrase) > 0) {
            $this->entities[] = ['phrase' => $phrase];
            end($this->entities);
            $this->data = key($this->entities);
            $code = 201;
        } else {
            $code = 422;
        }
        
        return $this->setResponse($code);
    }

    function update($data)
    {
        if (isset($data['id'], $data['phrase'])) {
            if (isset($this->entities[$data['id']])) {
                $this->entities[$data['id']]['phrase'] = $data['phrase'];
                $this->data = true;
                $code = 202;
            } else {
                $code = 404;
            }
        } else {
            $code = 422;    
        }
        
        return $this->setResponse($code);
    }

    function delete($id)
    {
        if (isset($id) && isset($this->entities[$id])) {
            unset($this->entities[$id]); 
            $this->data = true;
            $code = 200;
        } else {
            $code = 500;
        }
        
        return $this->setResponse($code);
    }
}