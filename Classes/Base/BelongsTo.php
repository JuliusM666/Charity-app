<?php
include_once("Database.php");
trait BelongsTo
{
    // Throw an error if parent doesn't exist
    public function belongsTo(Database $database, $id)
    {
        $database->find($id);

    }
}