<?php
$databaseConfig = require_once('./config/databaseConfig.php');

$databaseParams = @new mysqli($databaseConfig['host'], $databaseConfig['username'], $databaseConfig['password'], $databaseConfig['database']);

function testDatabaseConnection(){
    global $databaseParams;
    if ($databaseParams->ping()){
        return true;
    } else {
        return false;
    }
}

function getUserIdFromBd($email, $password){
    global $databaseParams;
    $result = $databaseParams->query("SELECT user_id, password FROM user WHERE lower(email)='" . strtolower($email) . "'");
    if ($user = mysqli_fetch_array($result)) {
        if (password_verify($password, $user['password'])) {
            return $user[0];
        } else {
            return 0;
        }
    } else {
        return 0;
    }
}

function emailExists($email){
    global $databaseParams;
    $result = $databaseParams->query("SELECT * FROM user WHERE LOWER(email) = '" . strtolower($email) . "'");
    if (mysqli_num_rows($result) >= 1) return true;
    else return false;
}

function addUser($firstName, $lastName, $email, $password){
    global $databaseParams;
    $created = date("Y-m-d H:i:s", time());
    $databaseParams->query("INSERT INTO user (email, password, first_name, last_name, created) VALUES ('$email', '" . password_hash($password, PASSWORD_DEFAULT) . "', '$firstName', '$lastName', '$created')");
    $response = $databaseParams->query("SELECT * FROM user WHERE email = '$email'");
    return $response;
}

function getUserDetails($uid){
    global $databaseParams;
    $result = $databaseParams->query("SELECT * FROM user WHERE user_id = $uid");
    if ($user = mysqli_fetch_array($result)){
        return $user;
    } else return "";
}

function getFirstName($uid){
    global $databaseParams;
    $result = $databaseParams->query("SELECT first_name FROM user WHERE user_id = $uid");
    if ($user = mysqli_fetch_array($result)){
        return $user;
    } else return "";
}