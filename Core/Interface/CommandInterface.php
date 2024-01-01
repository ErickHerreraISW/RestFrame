<?php

namespace Core\Interface;

interface CommandInterface
{
    /**
     * @param array $params
     * @return void
     */
    public function build(array $params) : void;

    /**
     * @return string
     */
    public function getCommand() : string;
}