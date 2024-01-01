<?php

namespace Core\Console;

use Core\Interface\CommandInterface;
use Core\Model\CommandModel;

class CommandPerformer
{
    public function __construct()
    {
        $this->loadCommands();
    }

    public function executeCommand($args) : void
    {
        try {
            $commands = json_decode(file_get_contents("./Cache/commands.json"));

            foreach ($commands as $command) {

                if($command->command == $args[1]) {

                    $object = new $command->command_class_obj();

                    if($object instanceof CommandInterface) {

                        unset($args[0]);
                        unset($args[1]);

                        $object->build($args);
                    }

                    return;
                }
            }

            throw new \Exception("Command not found");
        }
        catch (\Exception $ex)
        {
            print $ex->getMessage() . "\n";
        }
    }

    private function loadCommands() : void
    {
        try {
            $coreCommands = $this->loadCoreCommands();
            $customCommands = $this->loadCustomCommands();

            $commands = array_merge($coreCommands, $customCommands);

            file_put_contents("./Cache/commands.json", json_encode($commands, JSON_PRETTY_PRINT));
        }
        catch (\Exception $ex) {
            print $ex->getMessage() . "\n";
        }
    }

    /**
     * @return CommandModel[]
     */
    private function loadCoreCommands() : array
    {
        $response = array();
        $commands = scandir("./Core/Console/CoreCommands");

        unset($commands[0]);
        unset($commands[1]);

        foreach ($commands as $command)
        {
            $command_class_name = "Core\\Console\\CoreCommands\\" . explode(".", $command)[0];

            $command_object = new $command_class_name();

            if($command_object instanceof CommandInterface) {

                $command_text = $command_object->getCommand();

                $response[] = array(
                    "command" => $command_text,
                    "command_class_obj" => $command_class_name
                );
            }
        }

        return $response;
    }

    /**
     * @return CommandModel[]
     */
    private function loadCustomCommands() : array
    {
        return array();
    }
}