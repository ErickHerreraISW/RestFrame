<?php

namespace src\Service;

class TestService {

    public function __construct() {
            
    }

    /**
     * @param string $name
     * @return string
     */
    public function postFunction(string $name) : string
    {

        return "Hi Mr./Mrs " . $name;
    }
}