<?php
include_once("Base/Database.php");
include_once("Base/BelongsTo.php");
include_once("CharityDB.php");
class DonationDB extends Database
{
    use BelongsTo;
    public function __construct()
    {
        // pass data to parent
        parent::__construct("donations", ["id", "donor_name", "amount", "charity_id", "date_time"]);
    }
    public function store($name, $amount, $charityId) // store Donation
    {
        $this->belongsTo(new CharityDB(), $charityId); // check if charity row exists
        date_default_timezone_set('Europe/Vilnius'); // set time zone
        $handle = fopen($this->dbPath, "a");
        fputcsv($handle, [$this->getIndex(), $name, $amount, $charityId, date("Y-m-d")]); // store data
        fclose($handle);


    }
}