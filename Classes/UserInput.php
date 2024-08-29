<?php
include_once("CharityDB.php");
include_once("DonationDB.php");
include_once("OutputFormatter.php");
include_once("Validator.php");
class UserInput
{
    private $charityDB;
    private $donationDB;
    private $validator;
    public function __construct() // create object and set properties
    {
        $this->charityDB = new CharityDB();
        $this->donationDB = new DonationDB();
        $this->validator = new Validator();
    }
    public function userCommand($command)
    {
        // take action based on user input
        switch ($command) {
            case (1): // view charities
                OutputFormatter::printData($this->charityDB->findAll()); // output charities
                break;
            case (2): // Add charity
                $name = $this->input("name", "name: ");
                $email = $this->input("email", "representative email: ");
                $this->charityDB->store($name, $email);
                OutputFormatter::printMessage("Saved successfully", "success");
                break;
            case (3): // edit charity
                $id = $this->input("id", "id of charity you want to edit: ", $this->charityDB);
                $data = $this->charityDB->find($id);
                OutputFormatter::printRow($data);
                $name = $this->input("name", "new name: ", oldValue: $data[1]);
                $email = $this->input("email", "new representative email: ", oldValue: $data[2]);
                $this->charityDB->update($id, $name, $email);
                OutputFormatter::printMessage("Updated Successfully", "success");
                break;
            case (4): // delete
                $id = $this->input("id", "id of charity you want to delete: ", $this->charityDB);
                $this->charityDB->destroy($id);
                OutputFormatter::printMessage("Deleted Successfully", "success");
                break;
            case (5): // Add donation
                $name = $this->input("name", "donor name: ");
                $amount = $this->input("number", "amount: ");
                $charityId = $this->input("id", "charity id: ", $this->charityDB);
                $this->donationDB->store($name, $amount, $charityId);
                OutputFormatter::printMessage("Saved successfully", "success");
                break;
            case (6): // Import charity
                $path = readline("CSV file path: ");
                $this->charityDB->importCsv($path);
                OutputFormatter::printMessage("Imported successfully", "success");
                break;
            default:
                echo OutputFormatter::printMessage("Unknown command", "error");
        }

    }
    public function input($validationRule, $label, Database $db = null, $oldValue = null) // get and validate user input
    {

        while (True) {
            try {
                $value = readline($label);
                if (trim($value, " ") == "" && $oldValue != null) {
                    return $oldValue;
                }
                $this->validator->validate($validationRule, $value, $db);
                return $value;

            } catch (Throwable $e) {
                OutputFormatter::printMessage($e->getMessage(), "error");
            }
        }

    }

}