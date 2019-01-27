<!DOCTYPE html>
<html>
<title>travelr</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style type="text/css" media="all">
    @import "css/style.css";
    @import "css/style2.css";
</style>
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
<body>
<?php
require("header.php");
if (empty($_SESSION['uid'])) {
    header('Location: index.php');
} else {
    unset($_SESSION['uid']);
    session_destroy();
    header('Location: logoutMessage.php');
}
require_once("footer.php")
?>
</body>
</html>
