<?php
require_once("include/databaseFunctions.php");
?>
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
require_once("header.php");
if (@testDatabaseConnection()) {
    $meldung = "";
    if (isset($_SESSION['uid'])) {
        header('Location: index.php');
    }
    if (empty($_POST['email']) & empty($_POST['passwort'])) {
        $email = '';
        $passwort = '';
        $meldung = '';
    } else {
        $email = $_POST['email'];
        $passwort = $_POST['password'];

        $userID = getUserIdFromBd($email, $passwort);

        if (isset($userID)) {
            $_SESSION['uid'] = $userID;
            header('Location: index.php');
        } else {
            $meldung = "Login Daten sind nicht Korrekt!";
        }
    }
    ?>
    <div class="content center padding-16">
        <form method="post" action="login.php">
            <div class="container">
                <h2 style="margin: 0">Login</h2>
                <label for="email"><b class="left label">Email</b></label>
                <input type="text" placeholder="Enter Email" name="email" required>

                <label for="password"><b class="left label">Password</b></label>
                <input type="password" placeholder="Enter Password" name="password" required>

                <button type="submit">Login</button>
                <?php
                if (isset($meldung)) {
                    echo "<p style='color: #c10000'>$meldung</p>";
                }
                ?>
            </div>
        </form>
        <div class="content center">
            <p>Noch kein Login? <a href="register.php">Registriere dich hier!</a></p>

        </div>
    </div>
    <?php
} else {
    require_once("databaseError.php");
}
require_once("footer.php")
?>
</body>
</html>