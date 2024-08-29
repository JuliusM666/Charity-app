<?php
include_once("UserInput.php");
include_once("OutputFormatter.php");
class App
{

    private $userInput;

    public function __construct()
    {
        $this->userInput = new UserInput();

    }
    public function run()
    {
        // Set base exception handler
        set_exception_handler(function (\Throwable $e) {
            OutputFormatter::printMessage($e->getMessage(), "error");
        });
        // App cycle
        while (True) {
            try {
                // Show menu and read use input
                OutputFormatter::showMenu();
                $value = readline(":");
                if ($value == "exit") {
                    break;
                }
                // process user input
                $this->userInput->userCommand($value);
            } catch (Throwable $e) {
                OutputFormatter::printMessage($e->getMessage(), "error");
            }
        }

    }
}