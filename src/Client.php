<?php

namespace UnionJd;

class Client
{
    protected $config;

    protected $error;

    public function __construct(array $config = [])
    {
        if (empty($config)) {
            throw new \Exception('no config');
        }

        $this->config = $config;
        return $this;
    }

    public function __get($api)
    {
        try {
            $classname = __NAMESPACE__ . "\\Api\\" . ucfirst($api);
            if (!class_exists($classname)) {
                throw new \Exception('api undefined');
            }

            $new = new $classname($this->config, $this);
            return $new;
        } catch (\Exception $e) {
            throw new \Exception('api undefined');
        }
    }

    public function setError($error)
    {
        $this->error = $error;
        return false;
    }

    public function getError()
    {
        return $this->error;
    }

}