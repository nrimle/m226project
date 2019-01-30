<?php if ("$_SERVER[REQUEST_URI]" == "/m226project/travelr/footer.php" || "$_SERVER[REQUEST_URI]" == "/travelr/footer.php") {
    require_once("accessDenied.php");
} else { ?>
    <footer class="footer">
        <p>No Copyright <u id="copyright">©</u> travelr 2019 <u id="footer_text">| No rights reserved</u></p>
    </footer>
<?php }