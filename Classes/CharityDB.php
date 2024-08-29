<?php
include_once("Base/Database.php");
include_once("Base/HasMany.php");
include_once("DonationDB.php");
class CharityDB extends Database
{
    use HasMany;
    public function __construct()
    {
        // pass data to parent
        parent::__construct("charities", ["id", "name", "representative_email"]);
    }
    public function update($id, $name, $email) // update row
    {
        $tempFile = $this->setupTmpFile();
        foreach (file($this->dbPath) as $line) {
            $data = str_getcsv($line);
            if ($data[0] == $id) {
                fputcsv($tempFile, [$id, $name, $email]);
            } else {

                fputcsv($tempFile, $data);
            }

        }
        $this->saveTmpFile($tempFile);

    }
    public function destroy($id) // delete row
    {

        $tempFile = $this->setupTmpFile();
        foreach (file($this->dbPath) as $line) {
            $data = str_getcsv($line);
            if ($data[0] == $id) {
                continue;
            } else {

                fputcsv($tempFile, $data);
            }

        }
        $this->saveTmpFile($tempFile);
        $this->hasMany(new DonationDB(), $id, "charity_id");

    }

    public function store($name, $email) // store data
    {


        $handle = fopen($this->dbPath, "a");
        fputcsv($handle, [$this->getIndex(), $name, $email]);
        fclose($handle);


    }
    public function importCsv($path) // import CSV data
    {
        if (file_exists($path)) { // check if file exists
            $file = file($path);
            $cols = str_getcsv(array_shift($file));
            if (serialize($cols) === serialize($this->columns)) { // compare if columns match
                $db = fopen($this->dbPath, "a+");
                foreach ($file as $line) {
                    $data = str_getcsv($line);
                    array_shift($data); // remove old id
                    array_unshift($data, $this->getIndex()); // add new id
                    fputcsv($db, $data);

                }
                fclose($db);

            } else {
                throw new ErrorException("Columns are not compatible with " . join("|", $this->columns));
            }
        } else {
            throw new ErrorException("that file doesn't exist");
        }
    }

}