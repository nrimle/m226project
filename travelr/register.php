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
    if (isset($_SESSION['uid'])) {
        echo "You are already registered!";
    } else {
        $meldung = "";
        if (empty($_POST['firstName']) || empty($_POST['lastName']) || empty($_POST['email']) || empty($_POST['password']) || empty($_POST['RPpassword'])) {

            if (empty($_POST['firstName']) & empty($_POST['lastName']) & empty($_POST['email']) & empty($_POST['password']) & empty($_POST['RPpassword'])) {
                $firstname = '';
                $lastname = '';
                $email = '';
                $password = '';
                $RPpassword = '';
            } else {
                $meldung = 'Bitte fühlen Sie alle Felder aus!';
            }
        } else {
            $firstname = $_POST['firstName'];
            $lastname = $_POST['lastName'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $RPpassword = $_POST['RPpassword'];

            if ($password != $RPpassword) {
                $meldung = "Bitte geben Sie zweimal das gleiche password ein!";
            } elseif (strlen($password) < 6) {
                $meldung = "Das password sollte mindestens 6 Zeichen beinhalten!";
            } elseif (emailExists($email)) {
                $meldung = "Email bereits vorhanden!";
            } else {
                addUser($firstname, $lastname, $email, $password);
                header('Location: login.php');
            }
        }
        ?>
        <div class="content center padding-16">
            <form method="post" action="register.php">
                <div class="container">
                    <h2 style="margin: 0">Register</h2>
                    <div class="half padding-small">
                        <label for="firstName" class="left label"><b>First Name</b></label>
                        <input type="text" placeholder="Enter First Name" name="firstName" required>
                    </div>
                    <div class="half padding-small">
                        <label for="lastName" class="left label"><b>Last Name</b></label>
                        <input type="text" placeholder="Enter Last Name" name="lastName" required>
                    </div>

                    <div class="padding-small">
                        <label for="email" class="left label"><b>Email</b></label>
                        <input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" placeholder="Enter Email" name="email" required>
                    </div>

                    <div class="half padding-small">
                        <label for="password" class="left label"><b>Password</b></label>
                        <input type="password" placeholder="Enter Password" name="password" required>
                    </div>

                    <div class="half padding-small">
                        <label for="RPpassword" class="left label"><b>Repeat Password</b></label>
                        <input type="password" placeholder="Repeat Password" name="RPpassword" required>
                    </div>
                    <button type="submit" class="registerbtn">Register</button>
                    <?php
                    if (isset($meldung)) {
                        echo "<p style='color: #c10000'>$meldung</p>";
                    }
                    ?>
                </div>
            </form>
            <p>Already have an account? <a href="login.php">Sign in</a>.</p>
        </div>
        <?php
    }
} else {
    require_once("databaseError.php");
}
require_once("footer.php")
?>
</body>
</html>