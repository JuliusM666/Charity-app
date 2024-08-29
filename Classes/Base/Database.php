<?php
abstract class Database
{


    protected $dbPath;
    protected $folderPath;
    protected $title;
    protected $columns;

    function __construct($title, $columns) // construct object
    {
        $this->columns = $columns;
        $this->title = $title;
        $this->folderPath = "database/";
        $this->dbPath = $this->folderPath . $title . ".csv";
        $this->fileExists($this->dbPath) ?: $this->addColumns(); // create database if it doesn't exist and add columns
    }
    protected function fileExists($path) // create file if it doesn't exist
    {
        if (!file_exists($path)) {
            touch($path);
            return false;
        }
        return true;

    }
    protected function addColumns() // add columns to file
    {
        $handle = fopen($this->dbPath, "a");
        fputcsv($handle, $this->columns);
        fclose($handle);
    }
    public function findAll() // return all rows
    {

        $data = [];
        foreach (file($this->dbPath) as $line) {
            $data[] = str_getcsv($line);
        }
        return $data;
    }
    public function find($id) // find row by id
    {
        foreach (file($this->dbPath) as $line) {
            $data = str_getcsv($line);
            if ($data[0] == $id) {
                return $data;

            }

        }
        throw new ErrorException("row with that id doesn't exist");
    }

    public function getIndex() // get index for new row
    {
        $file = file($this->dbPath);
        $lastRow = str_getcsv(array_pop($file)); // get last row
        $index = $lastRow[0] == "id" ? 1 : $lastRow[0] + 1; // set index
        return $index;
    }
    protected function setupTmpFile() // create tmp file and return instance
    {
        $tempFilePath = $this->folderPath . 'temp.csv';
        $this->fileExists($tempFilePath);
        return fopen($tempFilePath, "a+");
    }
    protected function saveTmpFile($tempFile) // replace db with tmp file
    {
        fclose($tempFile);
        unlink($this->dbPath);
        rename($this->folderPath . 'temp.csv', $this->dbPath);
    }



}