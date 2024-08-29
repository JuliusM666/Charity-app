<?php

class OutputFormatter
{

    public static function printData($data) // format and output data
    {
        echo str_repeat("-", 60);
        foreach ($data as $line) {

            echo ("\n " . join(" ", $line) . "\n");
            echo str_repeat("-", 60);
        }

    }
    public static function showMenu() // output menu
    {
        echo "\n| View charities: 1 | Add charity: 2  | Edit charity: 3    |\n| Delete charity: 4 | Add donation: 5 | Import charities 6 |\n";

    }
    public static function printMessage($message, $type) // output message to user
    {
        if ($type == "error") {
            echo "\e[1;31;40m" . $message . "\e[0m\n";
        } else if ($type == "success") {
            echo "\e[1;32;40m" . $message . "\e[0m\n";
        }

    }

    public static function printRow($data) // output row to user
    {
        echo join("|", $data) . "\n";

    }
}