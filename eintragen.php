<META HTTP-EQUIV="Refresh" CONTENT="0; URL=kalender.php">
<?php
include 'db.php';
$EintragInTag = $_GET['tag'];
$oW = $_GET['ow'];
$uW = $_GET['uw'];
$Puls = $_GET['puls'];
if($oW > 0 and $uW > 0 and $Puls > 0)
EintragInDB($EintragInTag,$oW,$uW,$Puls);
else dbdelete($EintragInTag);
?>