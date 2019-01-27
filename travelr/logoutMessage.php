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
if (isset($_SESSION['uid'])) {
    ?>
    <div class="content center padding-16">
        <h3 style="color: #c10000">Something went wrong. You are not logged out.</h3>
    </div>

    <?php
} else {
    ?>
    <div class="content center padding-16">
        <h3>You successfully logged out.</h3>
    </div>
    <?php
}
require_once("footer.php")
?>
</body>
</html>
