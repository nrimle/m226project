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
            function reset() {
                $('table.connections tr.connection').show();
                $('table.connections tr.section').hide();
            }

            $('table.connections tr.connection').bind('click', function (e) {
                reset();
                let $this = $(this);
                $this.hide();
                $this.nextAll('tr.section').show();
                if ('replaceState' in window.history) {
                    history.replaceState({}, '', '?' + $('.pager').serialize() + '&c=' + $this.data('c'));
                }
            });
            $('.station input').bind('focus', function () {
                let that = this;
                setTimeout(function () {
                    that.setSelectionRange(0, 9999);
                }, 10);
            });
        });
    </script>
</head>
<title>travelr</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<style type="text/css" media="all">
    @import "css/style.css";
    @import "css/style2.css";
    @import "css/stylejquery.css";
    @import "css/clockpicker.css";
</style>
<link rel="shortcut icon" type="image/x-icon" href="images/favicon.ico">
<body>
<?php
require_once("header.php");
if (@testDatabaseConnection()) {
    $from = isset($_GET['from']) ? $_GET['from'] : false;
    $to = isset($_GET['to']) ? $_GET['to'] : false;
    $date = isset($_GET['date']) ? $_GET['date'] : '';
    $time = !empty($_GET['time']) ? $_GET['time'] : '';

    $fromto = null;

    $search = $from && $to;
    if ($search) {
        $query = [
            'from' => $from,
            'to' => $to,
            'date' => $date,
            'time' => $time,
            'limit' => 1,
        ];
        if (!empty($_GET['fromto'])) {
            $fromto = 1;
            $query['isArrivalTime'] = $fromto;
        }
        if (isset($_POST['save'])) {
            if (isset($_SESSION['uid'])) {

                $dateformat = date_format(date_create($date), 'Y-m-d');
                $fromtosave = isset($fromto) ? $fromto : 0;
                saveRequest($_SESSION['uid'], $from, $to, $dateformat, $time, $fromtosave);
            }
        }
        $url = 'https://transport.opendata.ch/v1/connections?' . http_build_query($query);
        $url = filter_var($url, FILTER_VALIDATE_URL);
        $response = json_decode(file_get_contents($url));
        if ($response->from) {
            $from = $response->from->name;
        }
        if ($response->to) {
            $to = $response->to->name;
        }
        if (isset($response->stations->from[0])) {
            if ($response->stations->from[0]->score < 101) {
                foreach (array_slice($response->stations->from, 1, 3) as $station) {
                    if ($station->score > 97) {
                        $stationsFrom[] = $station->name;
                    }
                }
            }
        }
        if (isset($response->stations->to[0])) {
            if ($response->stations->to[0]->score < 101) {
                foreach (array_slice($response->stations->to, 1, 3) as $station) {
                    if ($station->score > 97) {
                        $stationsTo[] = $station->name;
                    }
                }
            }
        }
    }
    ?>
    <div class="content center padding-16">
        <div class="container white padding-16" id="table_border">
            <h2 style="margin: 0">Details</h2>
            <?php if (isset($_POST['save'])) { ?>
                <div>
                    <h4 id="saved_info">Saved connection</h4>
                </div>
                <?php
                unset($_POST['save']);
            } ?>
            <div class="row">
                <div class="col-sm-7">

                    <?php if ($search && $response->connections) { ?>
                        <table class="table connections" style="margin-bottom: 16px">
                            <colgroup>
                                <col width="25%">
                                <col width="50%">
                                <col width="25%">
                            </colgroup>
                            <thead>
                            <tr>
                                <th>Time</th>
                                <th>Journey</th>
                                <th class="right" style="padding-right: 20%">
                                    <span id="pl">Pl.</span>
                                    <span id="platform">Platform</span>
                                </th>
                            </tr>
                            </thead>
                            <?php

                            $connections = $response->connections;
                            foreach ($connections as $connection) { ?>
                                <?php
                                /**
                                 * ToDo: Display message if no connection could be found
                                 * */
                                ?>
                                <tbody>
                                <?php
                                foreach ($connection->sections as $section) { ?>
                                    <tr class="section">
                                        <td rowspan="2">
                                            <?php echo date('H:i', strtotime($section->departure->departure)); ?>
                                            <?php if ($section->departure->delay) { ?>
                                                <span style="color: #a20d0d;"><?php echo '+' . $section->departure->delay; ?></span>
                                            <?php }; ?>
                                        </td>
                                        <td>
                                            <?php echo htmlentities($section->departure->station->name, ENT_QUOTES, 'UTF-8'); ?>
                                        </td>
                                        <td class="right" style="padding-right: 20%">
                                            <?php if ($section->departure->prognosis->platform) { ?>
                                                <span style="color: #a20d0d;"><?php echo htmlentities($section->departure->prognosis->platform, ENT_QUOTES, 'UTF-8'); ?></span>
                                            <?php } else { ?>
                                                <?php echo htmlentities($section->departure->platform, ENT_QUOTES, 'UTF-8'); ?>
                                            <?php }; ?>
                                        </td>
                                    </tr>
                                    <tr class="section">
                                        <td style="border-top: 0; padding: 4px 8px;" colspan="2">
                                        <span class="muted">
                                        <?php if ($section->journey) { ?>
                                            <?php echo htmlentities($section->journey->name, ENT_QUOTES, 'UTF-8'); ?>
                                        <?php } else { ?>
                                            Walk
                                        <?php }; ?>
                                        </span>
                                        </td>
                                    </tr>
                                    <tr class="section">
                                        <td style="border-top: 0;">
                                            <?php echo date('H:i', strtotime($section->arrival->arrival)); ?>
                                            <?php if ($section->arrival->delay) { ?>
                                                <span style="color: #a20d0d;"><?php echo '+' . $section->arrival->delay; ?></span>
                                            <?php }; ?>
                                        </td>
                                        <td style="border-top: 0;">
                                            <?php echo htmlentities($section->arrival->station->name, ENT_QUOTES, 'UTF-8'); ?>
                                        </td>
                                        <td class="right" style="border-top: 0; padding-right: 20%">
                                            <?php if ($section->arrival->prognosis->platform) { ?>
                                                <span style="color: #a20d0d;"><?php echo htmlentities($section->arrival->prognosis->platform, ENT_QUOTES, 'UTF-8'); ?></span>
                                            <?php } else { ?>
                                                <?php echo htmlentities($section->arrival->platform, ENT_QUOTES, 'UTF-8'); ?>
                                            <?php }; ?>
                                        </td>
                                    </tr>
                                <?php }; ?>
                                <tr class="section">
                                    <td style="border-top: 0; padding-bottom: 0;" colspan="2">
                                        <div class="tooltip">
                                            <button id="connection_button" class="button blue-gray left"
                                                    onclick="copy()"
                                                    onmouseout="outFunc()">
                                                <span class="tooltiptext"
                                                      id="copyinfo"><input class="copy_link"
                                                                           value='<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]" ?>'
                                                                           id='url' readonly></span>
                                                Copy link
                                            </button>
                                        </div>
                                    </td>
                                    <td style="border-top: 0;  padding-bottom: 0;">
                                        <div class="col-xs-6">
                                            <?php if (isset($_SESSION['uid'])) {
                                                ?>
                                                <form method="post"
                                                      action="details.php?<?php echo htmlentities(http_build_query(['from' => $connection->from->station->name, 'to' => $connection->to->station->name, 'fromto' => $fromto, 'date' => date("d.m.Y", $connection->from->departureTimestamp), 'time' => date("H:i", $connection->from->departureTimestamp)]), ENT_QUOTES, 'UTF-8'); ?>">
                                                    <input type="hidden" name="save" value="true">
                                                    <input class="button blue-gray right" type="submit" value="Save" id="connection_button">
                                                </form>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                                </tbody>
                            <?php }; ?>
                        </table>
                    <?php } else {
                        require("notfound.php");
                    } ?>
                </div>
            </div>
        </div>
    </div>
    <script>
        function copy() {
            let copyText = document.getElementById("url");
            copyText.select();
            document.execCommand('copy');

            console.log(copyText);

            let tooltip = document.getElementById("copyinfo");
            tooltip.innerHTML = "Copied link";
        }

        function outFunc() {
            let tooltip = document.getElementById("copyinfo");
            tooltip.innerHTML = "<input class='copy_link' value='<?php echo (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"?>' id='url' readonly>";
        }
    </script>
    <?php
} else {
    require_once("databaseError.php");
}
require_once("footer.php")
?>
</body>
</html>