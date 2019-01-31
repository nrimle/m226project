<?php
if ("$_SERVER[REQUEST_URI]" == "/m226project/travelr/include/databaseFunctions.php" || "$_SERVER[REQUEST_URI]" == "/travelr/include/databaseFunctions.php") {
    require_once("../accessDenied.php");
} else {
    $databaseConfig = require_once('./config/databaseConfig.php');

    $databaseParams = @new mysqli($databaseConfig['host'], $databaseConfig['username'], $databaseConfig['password'], $databaseConfig['database']);

    function testDatabaseConnection()
    {
        global $databaseParams;
        if ($databaseParams->ping()) {
            return true;
        } else {
            return false;
        }
    }

    function getUserIdFromBd($email, $password)
    {
        global $databaseParams;
        $result = $databaseParams->query("SELECT user_id, password FROM user WHERE lower(email)='" . strtolower($email) . "'");
        if ($user = mysqli_fetch_array($result)) {
            if (password_verify($password, $user['password'])) {
                return $user[0];
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    function emailExists($email)
    {
        global $databaseParams;
        $result = $databaseParams->query("SELECT * FROM user WHERE LOWER(email) = '" . strtolower($email) . "'");
        if (mysqli_num_rows($result) >= 1) return true;
        else return false;
    }

    function addUser($firstName, $lastName, $email, $password)
    {
        global $databaseParams;
        $created = date("Y-m-d H:i:s", time());
        $databaseParams->query("INSERT INTO user (email, password, first_name, last_name, created) VALUES ('$email', '" . password_hash($password, PASSWORD_DEFAULT) . "', '$firstName', '$lastName', '$created')");
        $response = $databaseParams->query("SELECT * FROM user WHERE email = '$email'");
        return $response;
    }

    function getUserDetails($uid)
    {
        global $databaseParams;
        $result = $databaseParams->query("SELECT * FROM user WHERE user_id = $uid");
        if ($user = mysqli_fetch_array($result)) {
            return $user;
        } else return "";
    }

    function getFirstName($uid)
    {
        global $databaseParams;
        $result = $databaseParams->query("SELECT first_name FROM user WHERE user_id = $uid");
        if ($user = mysqli_fetch_array($result)) {
            return $user;
        } else return "";
    }

    function saveRequest($uid, $departure, $destination, $date, $time, $fromto)
    {
        global $databaseParams;
        $result = $databaseParams->query("SELECT EXISTS(SELECT * FROM request WHERE destination = '$destination' AND departure = '$departure' AND date = '$date' AND time = '$time' AND from_to = '$fromto' AND user_id__fk = '$uid') AS exist;");
        $result = mysqli_fetch_assoc($result);
        if ($result['exist'] == 0) {
            $databaseParams->query("INSERT INTO request (departure, destination, date, time, user_id__fk, from_to) VALUES ('$departure', '$destination', '$date', '$time', '$uid', '$fromto');");
        }
        return $result;
    }

    function getAllRequests($uid)
    {
        $all = [];
        global $databaseParams;
        $result = $databaseParams->query("SELECT * FROM request WHERE user_id__fk = '$uid'");
        while ($request = mysqli_fetch_array($result)){
            $all[] = $request;
        }
        return $all;

    }
    function getRequestOwner($rid){
        global $databaseParams;
        $result = $databaseParams->query("SELECT user_id__fk AS owner FROM request WHERE request_id = '$rid'");
        return mysqli_fetch_assoc($result);
    }

    function deleteRequest($rid){
        global $databaseParams;
        $databaseParams->query("DELETE FROM request WHERE request_id = '$rid'");
    }
}