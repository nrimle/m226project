<h3>Oh no. Your request did not return any results.</h3>
<h4>Please check your input and try again.</h4>
<div style="margin: 16px">
    <a class="button blue-grey center"
       href="index.php?<?php echo htmlentities(http_build_query(['from' => $_GET['from'], 'to' => $_GET['to']]), ENT_QUOTES, 'UTF-8'); ?>">Home</a>
</div>
<img style="margin: 16px" src="images/magnifying_glass.png" alt="Magnifying Glass" height="25%" width="25%">
