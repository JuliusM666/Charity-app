<?php

include_once("Classes/App.php");

class Main
{

    // Start CLI Application
    public static function startCliApp()
    {

        $app = new App();
        $app->run();

    }
}
Main::startCliApp();