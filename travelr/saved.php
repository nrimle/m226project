<?php
require_once("include/databaseFunctions.php");
?>
<!DOCTYPE html>
<html>
<head>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.13.0/moment.min.js"></script>
    <script>
        $(function () {

            $(document).ready(resize);
            $(window).resize(resize);

            function resize() {
                if ($(window).width() <= 600) {
                    $('table.connections td.date_time').hide();
                    $('table.connections th.date_time').hide();
                } else {
                    $('table.connections td.date_time').show();
                    $('table.connections th.date_time').show();
                }
            }
        });
    </script>
</head>
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

    if (isset($_GET['delete'])) {
        $owner = getRequestOwner($_GET['delete']);
        if ($owner['owner'] == $_SESSION['uid']) {
            deleteRequest($_GET['delete']);
        } else {
            ?>
            <script>
                window.alert("You are not permitted to delete this object!")
            </script>
            <?php
        }
    }
    ?>
    <div class="content center padding-16">
        <div class="container white padding-16" id="table_border">
            <h2 style="margin: 0">Saved</h2>
            <div class="row-padding" style="margin:0 -16px; overflow-x: auto;">
                <table class="table connections">
                    <thead>
                    <tr>
                        <th>From</th>
                        <th>To</th>
                        <th class="date_time">Date</th>
                        <th class="date_time">Time</th>
                        <th>View</th>
                        <th>Delete</th>
                    </tr>
                    </thead>
                    <?php
                    $requests = getAllRequests($_SESSION['uid']);
                    foreach ($requests

                    as $request) {
                    $from = $request['departure'];
                    $to = $request['destination'];
                    $date = $request['date'];
                    $time = $request['time'];
                    ?>
                    <tbody>
                    <tr class="connection clickable-row" data-href="index.php">
                        <td>
                            <?php echo $request['departure'] ?>
                        </td>
                        <td>
                            <?php echo $request['destination'] ?>
                        </td>
                        <td class="date_time">
                            <?php echo date("d.m.Y", strtotime($request['date'])) ?>
                        </td>
                        <td class="date_time">
                            <?php echo date("H:i", strtotime($request['time'])) ?>
                        </td>
                        <td class="center">
                            <a href="#">
                                <img border="0" alt="View" src="images/eye.png" width="25" height="25">
                        </td>
                        <td class="center">
                            <a href="saved.php?delete=<?php echo $request['request_id'] ?>">
                                <img border="0" alt="Delete" src="images/trash.png" width="25" height="25">
                        </td>
                    </tr>

                    <?php
                    }
                    ?>
            </div>
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
