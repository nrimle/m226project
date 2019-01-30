<?php
$from = isset($_GET['from']) ? $_GET['from'] : false;
$to = isset($_GET['to']) ? $_GET['to'] : false;
$date = isset($_GET['date']) ? $_GET['date'] : '';
$time = !empty($_GET['time']) ? $_GET['time'] : date('H:i');
$page = isset($_GET['page']) ? ((int)$_GET['page']) - 1 : 0;
$c = isset($_GET['c']) ? (int)$_GET['c'] : false;
if ($page == 0) {
    $limit = 5;
} else {
    $limit = 4;
}
$fromto = null;

$search = $from && $to;
if ($search) {
    $query = [
        'from' => $from,
        'to' => $to,
        'date' => $date,
        'time' => $time,
        'page' => $page,
        'limit' => $limit,
    ];
    if (!empty($_GET['fromto'])) {
        $fromto = 1;
        $query['isArrivalTime'] = $fromto;
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
    ?>
    <div class="content center padding-16">
        <div class="container white padding-16" id="connection_table">
            <h2 style="margin: 0">Timetable</h2>
            <div class="row">
                <div class="col-sm-7">

                    <?php if ($search && $response->connections) { ?>
                        <table class="table connections">
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
                            <?php $j = 0;
                            if ($page == 0) {
                                $connections = array_slice($response->connections, 1);
                            } else {
                                $connections = $response->connections;
                            }
                            foreach ($connections as $connection) { ?>
                                <?php $j++;

                                /**
                                 * ToDo: Display message if no connection could be found
                                 * */
                                ?>
                                <tbody>
                                <tr class="connection"<?php if ($j == $c) { ?> style="display: none;"<?php }; ?>
                                    data-c="<?php echo $j; ?>">
                                    <td>
                                        <?php echo date('H:i', strtotime($connection->from->departure)); ?>
                                        <?php if ($connection->from->delay) { ?>
                                            <span style="color: #a20d0d;"><?php echo '+' . $connection->from->delay; ?></span>
                                        <?php }; ?>
                                        <br/>
                                        <?php echo date('H:i', strtotime($connection->to->arrival)); ?>
                                        <?php if ($connection->to->delay) { ?>
                                            <span style="color: #a20d0d;"><?php echo '+' . $connection->to->delay; ?></span>
                                        <?php }; ?>
                                    </td>
                                    <td>
                                        <?php echo (substr($connection->duration, 0, 2) > 0) ? htmlentities(trim(substr($connection->duration, 0, 2), '0')) . 'd ' : ''; ?>
                                        <?php echo htmlentities(trim(substr($connection->duration, 3, 1), '0') . substr($connection->duration, 4, 4)); ?>
                                        <br/>
                                        <span class="muted">
                                    <?php echo htmlentities(implode(', ', $connection->products)); ?>
                                    </span>
                                    </td>
                                    <td class="right" style="margin-right: 20%; padding-right: 0;">
                                        <?php if ($connection->from->prognosis->platform) { ?>
                                            <span style="color: #a20d0d;"><?php echo htmlentities($connection->from->prognosis->platform, ENT_QUOTES, 'UTF-8'); ?></span>
                                        <?php } else { ?>
                                            <?php echo htmlentities($connection->from->platform, ENT_QUOTES, 'UTF-8'); ?>
                                        <?php }; ?>
                                        <br/>
                                    </td>
                                </tr>
                                <?php $i = 0;
                                foreach ($connection->sections as $section) { ?>
                                    <tr class="section"<?php if ($j != $c) { ?> style="display: none;"<?php }; ?>>
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
                                    <tr class="section"<?php if ($j != $c) { ?> style="display: none;"<?php }; ?>>
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
                                    <tr class="section"<?php if ($j != $c) { ?> style="display: none;"<?php }; ?>>
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
                                <tr class="section"<?php if ($j != $c) { ?> style="display: none;"<?php }; ?>>
                                    <td style="border-top: 0;">
                                        <div class="col-xs-6">
                                            <a id="connection_button" class="button blue-grey left"
                                               href="details.php?<?php echo htmlentities(http_build_query(['from' => $connection->from->station->name, 'to' => $connection->to->station->name, 'fromto' => $fromto, 'date' => date("d.m.Y", $connection->from->departureTimestamp), 'time' => date("H:i", $connection->from->departureTimestamp)]), ENT_QUOTES, 'UTF-8'); ?>">Details</a>
                                        </div>
                                    </td>
                                    <td style="border-top: 0;">

                                    </td>
                                    <td style="border-top: 0;">
                                        <div class="col-xs-6" style="margin-right: calc(20% - 8px)">
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

                        <div class="row">
                            <div class="col-xs-6">
                                <a id="page_button" class="button theme left"
                                   href="test.php?<?php echo htmlentities(http_build_query(['from' => $from, 'to' => $to, 'fromto' => $fromto, 'date' => $date, 'time' => $time, 'page' => $page]), ENT_QUOTES, 'UTF-8'); ?>">Earlier
                                    <u id="connection_text">connections</u></a>
                            </div>
                            <div class="col-xs-6 text-right">
                                <a id="page_button" class="button theme right"
                                   href="test.php?<?php echo htmlentities(http_build_query(['from' => $from, 'to' => $to, 'fromto' => $fromto, 'date' => $date, 'time' => $time, 'page' => $page + 2]), ENT_QUOTES, 'UTF-8'); ?>">Later
                                    <u id="connection_text">connections</u></a>
                            </div>
                        </div>
                        <form style="display: none; visibility: hidden" class="pager">
                            <input type="hidden" name="from"
                                   value="<?php echo htmlentities($from, ENT_QUOTES, 'UTF-8'); ?>"/>
                            <input type="hidden" name="to"
                                   value="<?php echo htmlentities($to, ENT_QUOTES, 'UTF-8'); ?>"/>
                            <input type="hidden" name="date"
                                   value="<?php echo htmlentities($date, ENT_QUOTES, 'UTF-8'); ?>"/>
                            <input type="hidden" name="time"
                                   value="<?php echo htmlentities($time, ENT_QUOTES, 'UTF-8'); ?>"/>
                            <input type="hidden" name="fromto"
                                   value="<?php echo htmlentities($fromto, ENT_QUOTES, 'UTF-8'); ?>"/>
                            <input type="hidden" name="page"
                                   value="<?php echo htmlentities($page + 1, ENT_QUOTES, 'UTF-8'); ?>"/>
                        </form>
                    <?php } else {
                        require("notfound.php");
                    } ?>
                </div>
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