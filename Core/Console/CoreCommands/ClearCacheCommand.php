<?php

namespace Core\Console\CoreCommands;

use Core\Interface\CommandInterface;

class ClearCacheCommand implements CommandInterface
{
    /**
     * @var string
     */
    private string $command = "clear:cache";

    /**
     * @param array $params
     * @return void
     */
    public function build(array $params): void
    {
        try {
            print "Cleaning cache...\n";

            $caches = scandir("./Cache");

            if(is_array($caches))
            {
                unset($caches[0]);
                unset($caches[1]);

                foreach ($caches as $cache) {
                    unlink("./Cache/" . $cache);
                }
            }

            print "Cache cleaned successfully...\n";
        }
        catch (\Exception $ex) {
            print $ex->getMessage() . "\n";
        }
    }

    /**
     * @return string
     */
    public function getCommand(): string
    {
        return $this->command;
    }
}