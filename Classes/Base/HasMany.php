<?php
include_once("Database.php");
trait HasMany
{
    // If parent is deleted children relatiosnhip field is set to null
    public function hasMany(Database $database, $id, $relationshipField)
    {

        $fieldId = array_search($relationshipField, $database->columns);  // find which array index is relatiosnhip field 
        $file = file($database->dbPath);
        $tempFilePath = $database->folderPath . 'temp.csv';
        $this->fileExists($tempFilePath);    // create temp file
        $tempFile = fopen($tempFilePath, "a+");
        foreach ($file as $line) {
            $data = str_getcsv($line);
            if ($data[$fieldId] == $id) {   // check if relatiosnhip field matches deleted parent id
                $data[$fieldId] = "null";   // set field to null
                fputcsv($tempFile, $data);
            } else {
                fputcsv($tempFile, $data);  // else just copy data
            }
        }

        fclose($tempFile);  // close temp file
        unlink($database->dbPath);  // delete old database and replace it with new
        rename($tempFilePath, $database->dbPath);
    }
}