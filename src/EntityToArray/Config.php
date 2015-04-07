<?php

namespace EntityToArray;

use EntityToArray\Exceptions\EntityToArrayException;

class Config
{
    private $config = array(
        'numeric-keys' => false,
        'multidimensional' => true,
        'methodName-keys' => false,
        'only-names' => false,
        'custom-key' => false
    );

    public function configure(array $config) {
        foreach($config as $cng =>  $value) {
            if( ! array_key_exists($cng, $this->config)) {
                throw new EntityToArrayException('EntityToArray: Invalid config given: ' . $cng);
            }

            $this->config[$cng] = $value;
        }

        if($this->config['methodName-keys'] === true AND $this->config['multidimensional'] === false) {
            $this->config['multidimensional'] = true;
        }
    }

    public function reset() {
        $this->config = array(
            'numeric-keys' => true,
            'multidimensional' => true,
            'methodName-keys' => false,
            'only-names' => false,
            'custom-key' => false
        );
    }

    public function numericKeys($set = null) {
        if(is_bool($set)) {
            $this->config['numeric-keys'] = $set;
            return $this;
        }

        return $this->config['numeric-keys'];
    }

    public function multidimensional($set = null) {
        if(is_bool($set)) {
            $this->config['multidimensional'] = $set;
            return $this;
        }

        return $this->config['multidimensional'];
    }

    public function methodNameKeys($set = null) {
        if(is_bool($set)) {
            $this->config['methodName-keys'] = $set;
            return $this;
        }

        return $this->config['methodName-keys'];
    }

    public function onlyNames($set = null) {
        if(is_bool($set)) {
            $this->config['only-names'] = $set;
            return $this;
        }

        return $this->config['only-names'];
    }

    public function customKey($set = null) {
        if(is_bool($set)) {
            $this->config['custom-key'] = $set;
            return $this;
        }

        return $this->config['custom-key'];
    }
} 