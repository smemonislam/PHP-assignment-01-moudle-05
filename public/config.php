<?php
// Function to read data from the database file
function readDatabaseFile($filePath)
{
    if (file_exists($filePath) && is_readable($filePath)) {
        $data = json_decode(file_get_contents($filePath), true) ?? [];
        return $data;
    } else {
        throw new Exception('Database file is not accessible.');
    }
}

// Function to write data to the database file
function writeDatabaseFile($filePath, $data)
{
    if (file_exists($filePath) && is_writable($filePath)) {
        file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT), LOCK_EX);
    } else {
        throw new Exception('Database file is not writable.');
    }
}

// Function to validate and sanitize input
function validatedInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}


// Function to find data by ID
function findDataById($data, $id)
{
    foreach ($data as $key => $item) {
        if ($item["id"] == $id) {
            return $item;
        }
    }
    return null;
}


// Function to find data by Role
function findDataByRole($data, $role)
{
    foreach ($data as $key => $item) {
        if ($item["role"] == $role) {
            return $item;
        }
    }
    return null;
}

function isAdmin()
{
    return ('admin' == $_SESSION['role']);
}
