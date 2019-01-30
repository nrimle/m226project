<?php if ("$_SERVER[REQUEST_URI]" == "/m226project/travelr/databaseError.php" || "$_SERVER[REQUEST_URI]" == "/travelr/databaseError.php") {
    require_once("accessDenied.php");
} else { ?>
    <div class="content center" style="max-width:800px; position:relative">
        <h3>Oh no. Our services are currently unavailable.</h3>
        <h4>Please try again later. Our maintenance team is working on it.</h4>
        <h4>Error Code: 34252</h4>
        <img src="images/gears.png" alt="Gears" height="40%" width="40%">
    </div>
<?php }