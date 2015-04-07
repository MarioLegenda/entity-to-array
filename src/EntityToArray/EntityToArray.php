<?php

namespace EntityToArray;


use EntityToArray\Exceptions\EntityToArrayException;

class EntityToArray
{
    private $entityMethods = array();
    private $entities = array();

    private $config;


    public function __construct(array $entities, array $entityMethods) {
        $this->entities = $entities;
        $this->entityMethods = $entityMethods;

        $this->config = new Config();
    }

    public function config(array $config) {
        $this->config->configure($config);

        if($this->config->methodNameKeys() === true AND $this->config->multidimensional() === false) {
            $this->config->multidimensional(true);
        }

        if($this->config->multidimensional() === false AND count($this->entityMethods) > 1) {
            $this->config->multidimensional(true);
        }

        return $this;
    }

    public function toArray() {
        $entityArr = array();
        $entityIt = new \ArrayIterator($this->entityMethods);
        foreach($this->entities as $entity) {
            $temp = array();
            $entityIt->rewind();
            while($entityIt->valid()) {
                $methodName = $entityIt->current();

                if($this->config->numericKeys() === true) {
                    if($this->config->multidimensional() === false) {
                       $entityArr[] = $entity->$methodName();
                    }
                    else {
                        $temp[] = $entity->$methodName();
                    }
                }
                else if($this->config->methodNameKeys() === true) {
                    if($this->config->onlyNames() === true) {
                        $nameKey = strtolower(preg_replace('#^(is|get|set)#', '', $methodName));
                        $temp[$nameKey] = $entity->$methodName();
                    }
                    else {
                        $temp[$methodName] = $entity->$methodName();
                    }
                }
                else if($this->config->customKey() !== false) {
                    $cstKey = $this->config->customKey();
                    if( ! is_string($cstKey)) {
                        throw new EntityToArrayException('EntityToArray: custom-key config has to be an array');
                    }

                    $temp[$cstKey] = $entity->$methodName();
                }

                $entityIt->next();
            }

            if($this->config->multidimensional() === true) {
                $entityArr[] = $temp;
            }
        }

        return $entityArr;
    }
} 