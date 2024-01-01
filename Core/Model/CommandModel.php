<?php

namespace Core\Model;

class CommandModel
{
    /**
     * @var string
     */
    private string $command;

    /**
     * @var mixed
     */
    private mixed $command_class_obj;

    public function getCommand(): string
    {
        return $this->command;
    }

    public function setCommand(string $command): CommandModel
    {
        $this->command = $command;
        return $this;
    }

    public function getCommandClassObj(): mixed
    {
        return $this->command_class_obj;
    }

    public function setCommandClassObj(mixed $command_class_obj): CommandModel
    {
        $this->command_class_obj = $command_class_obj;
        return $this;
    }
}