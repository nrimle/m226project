<?php
if ("$_SERVER[REQUEST_URI]" == "/m226project/travelr/header.php" || "$_SERVER[REQUEST_URI]" == "/travelr/header.php") {
    require_once("accessDenied.php");
} else {
    session_start();
    require_once("include/databaseFunctions.php");
    ?>
    <header class="container theme padding" id="header_container">
        <div class="dropdown right" style="margin: 20px">
            <input type="image" id="user_picture" src="./images/user.svg" alt="Submit Form" onclick="myFunction()"
                   class="dropbtn"/>
            <div id="myDropdown" class="dropdown-content">
                <?php
                if (@testDatabaseConnection()) {
                    if (isset($_SESSION['uid'])) {
                        $uid = $_SESSION['uid'];
                        $name = getFirstName($uid);
                        ?>
                        <p>Hi, <?php echo $name['first_name'] ?></p>
                        <a href="test.php">Saved requests</a>
                        <a href="logout.php">Logout</a>
                        <?php
                    } else {
                        ?>
                        <a href="login.php">Login</a>
                        <a href="register.php">Register</a>
                        <?php
                    }
                }
                ?>
            </div>
        </div>
        <div class="centered-axis-x">
            <div class="xxxlarge" id="title" style="width: auto;">
                <a href="index.php" style="text-decoration: none; color: #fff;">travelr</a>
            </div>
            <h1 class="xlarge center" id="title_message">The preferred travel planning tool</h1>
        </div>
    </header>
    <script>
        function myFunction() {
            document.getElementById("myDropdown").classList.toggle("show");
        }

        // Close the dropdown menu if the user clicks outside of it
        window.onclick = function (event) {
            if (!event.target.matches('.dropbtn')) {
                let dropdowns = document.getElementsByClassName("dropdown-content");
                let i;
                for (i = 0; i < dropdowns.length; i++) {
                    let openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
    </script>
<?php }