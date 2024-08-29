<?php
include_once("Base/Database.php");
class Validator
{
    public function validate($rule, $value, Database $db = null) // validate user input
    {
        switch ($rule) {
            case ("name"):
                $this->name($value);
                break;
            case ("email"):
                $this->email($value);
                break;
            case ("number"):
                $this->number($value);
                break;
            case ("id"):
                $this->number($value);
                $db->find($value);
                break;
        }
    }

    public function name($value) // validate name
    {
        if (!preg_match("/^[A-z]+\s?(?=[A-z])[A-z]*$/", $value)) {
            throw new ErrorException("incorrect name");
        }
    }
    public function email($value) // validate email
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new ErrorException("incorrect email");
        }
    }
    public function number($value) // validate amount
    {
        if (!is_numeric($value) or $value < 0) {
            throw new ErrorException("incorrect numeric value");
        }

    }
}


