<?php
// Function to read data from the database file
function readDatabaseFile($filePath)
{
    $data = file_exists($filePath) ? json_decode(file_get_contents($filePath), true) : [];
    return $data;
    // if (file_exists($filePath) && is_readable($filePath)) {
    //     $data = json_decode(file_get_contents($filePath), true) ?? [];
    //     return $data;
    // } else {
    //     throw new Exception('Database file is not accessible.');
    // }
}

// Function to write data to the database file
function writeDatabaseFile($filePath, $data)
{
    // if (file_exists($filePath) && is_writable($filePath)) {
    //     file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT));
    // } else {
    //     throw new Exception('Database file is not writable.');
    // }

    file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT));
}

// Function to validate and sanitize input
function validatedInput($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Function Validation 
function validateEmail($email)
{
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Email is invalid.');
    }

    // if (isDisposableEmail($email)) {
    //     throw new Exception('Disposable email addresses are not allowed.');
    // }

    // if (!isValidEmailDomain($email)) {
    //     throw new Exception('Email domain does not exist.');
    // }
}

function validateUsername($username)
{
    $maxUsernameLength = 20;
    if (strlen($username) > $maxUsernameLength) {
        throw new Exception('Username is too long. Maximum ' . $maxUsernameLength . ' characters allowed.');
    }

    if (!preg_match('/^[A-Za-z0-9_]+$/', $username)) {
        throw new Exception('Username can only contain letters, numbers, and underscores.');
    }

    // if (containsProfanity($username)) {
    //     throw new Exception('Username contains profanity and is not allowed.');
    // }
}

function validatePassword($password)
{
    $minPasswordLength = 8;
    if (strlen($password) < $minPasswordLength) {
        throw new Exception('Password must be at least ' . $minPasswordLength . ' characters long.');
    }

    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@#$%^&!*_])[A-Za-z\d@#$%^&!*_]{8,}$/', $password)) {
        throw new Exception('Password must contain at least one lowercase letter, one uppercase letter, one number, and one special character.');
    }
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


// Function to find data by Role
function findDataByEmail($data, $email)
{
    foreach ($data as $key => $item) {
        if ($item["email"] == $email) {
            return $item;
        }
    }
    return null;
}

function isAdmin()
{
    return ('admin' == $_SESSION['role']);
}

// Password Generator
function generatePassword($length = 8)
{
    $uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $lowercase = 'abcdefghijklmnopqrstuvwxyz';
    $numbers = '0123456789';
    $specialChars = '!@#$%^&*()-_=+[]{}|;:,.<>?';
    $allChars = $uppercase . $lowercase . $numbers . $specialChars;

    $password = $uppercase[rand(0, 25)] . $lowercase[rand(0, 25)] . $numbers[rand(0, 9)] . $specialChars[rand(0, 22)];

    for ($i = 0; $i < $length - 4; $i++) {
        $password .= $allChars[rand(0, 61)];
    }

    return str_shuffle($password);
}
