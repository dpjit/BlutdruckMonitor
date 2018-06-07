<?php 
include 'db.php';
function monthBack( $timestamp ){
    return mktime(0,0,0, date("m",$timestamp)-1,date("d",$timestamp),date("Y",$timestamp) );
}
function yearBack( $timestamp ){
    return mktime(0,0,0, date("m",$timestamp),date("d",$timestamp),date("Y",$timestamp)-1 );
}
function monthForward( $timestamp ){
    return mktime(0,0,0, date("m",$timestamp)+1,date("d",$timestamp),date("Y",$timestamp) );
}
function yearForward( $timestamp ){
    return mktime(0,0,0, date("m",$timestamp),date("d",$timestamp),date("Y",$timestamp)+1 );
}
function blutdruck($datum ){
    return "<div class=\"blutdruck\">".dbselect($datum)."</div>";
}

function blutdruckeintragen($EintragInTag){	
		$bd_daten = dbselect2($EintragInTag);
		//echo $daten[0]."<br>".$daten[1]."<br>".$daten[2];
    echo "<br>hier<br>Eintrag<br>bitte";
}

function blutdruckform(){	
if(isset($_GET['EintragInTag']))
			$EintragInTag = $_GET['EintragInTag'];
		else $EintragInTag = date("Y-m-d");
$bd_daten = dbselect2($EintragInTag);

echo "<form action='eintragen.php' ><div><input name='tag' value='".$EintragInTag."' type='hidden'><table><th colspan='2'>Eintrag für ".explode("-",$EintragInTag)[2].".".explode("-",$EintragInTag)[1].".".explode("-",$EintragInTag)[0]."</th><tr>  <td>oberster Wert: </td>  <td><input type='text' name='ow' value='";
if($bd_daten[0]>0) echo $bd_daten[0];
echo "'></td></tr><tr>  <td>unterster Wert: </td>  <td><input type='text' name='uw' value='";
if($bd_daten[1]>0) echo $bd_daten[1];
echo "'></td></tr>  <tr>  <td>Puls: </td>  <td><input type='text' name='puls' value='";
if($bd_daten[2]>0) echo $bd_daten[2];
echo "'></td></tr>  <tr><td></td><td><input type='submit' value='Eintragen'></td></tr></div></form>";
}

function daycurrent($i,$date){
	$datum = date("Y-m-d",mktime(0,0,0,date('m',$date),$i,date('Y',$date)) );	
	echo "<a href = 'kalender.php?EintragInTag=".$datum."'><div class=\"day current\"><b>".sprintf("%02d",$i)."</b>".blutdruck($datum)."</div></a>\n";
}
function daynormal($i,$date){
	$datum = date("Y-m-d",mktime(0,0,0,date('m',$date),$i,date('Y',$date)) );		
	echo "<a href = 'kalender.php?EintragInTag=".$datum."'><div class=\"day normal\"><b>".sprintf("%02d",$i)."</b>".blutdruck($datum)."</div></a>\n";
}

function getCalender($date,$headline = array('Mo','Di','Mi','Do','Fr','Sa','So')) {
    $sum_days = date('t',$date);
    $LastMonthSum = date('t',mktime(0,0,0,(date('m',$date)-1),0,date('Y',$date)));
    
    foreach( $headline as $key => $value ) {
        echo "<div class=\"day headline\">".$value."</div>\n";
    }
    
    for( $i = 1; $i <= $sum_days; $i++ ) {
        $day_name = date('D',mktime(0,0,0,date('m',$date),$i,date('Y',$date)));
        $day_number = date('w',mktime(0,0,0,date('m',$date),$i,date('Y',$date)));
        
        if( $i == 1) {
            $s = array_search($day_name,array('Mon','Tue','Wed','Thu','Fri','Sat','Sun'));
            for( $b = $s; $b > 0; $b-- ) {
                $x = $LastMonthSum-$b;
                echo "<div class=\"day before\">".sprintf("%02d",$x)."</div>\n";
            }
        }		
        
        if( $i == date('d',$date) && date('m.Y',$date) == date('m.Y')) {
			daycurrent($i,$date);
            //echo "<div class=\"day current\">".sprintf("%02d",$i).blutdruck($i,date('m',$date),date('Y',$date))."</div>\n";
        } else {
			daynormal($i,$date);
            //echo "<div class=\"day normal\">".sprintf("%02d",$i).blutdruck($i,date('m',$date),date('Y',$date))."</div>\n";
        }
        
        if( $i == $sum_days) {
            $next_sum = (6 - array_search($day_name,array('Mon','Tue','Wed','Thu','Fri','Sat','Sun')));
            for( $c = 1; $c <=$next_sum; $c++) {
                echo "<div class=\"day after\"> ".sprintf("%02d",$c)."</div>\n"; 
            }
        }
    }
}
?>
<html>
<head>
<style type="text/css">
body {
    font-family:verdana;
    font-size:12px;
}
a {
    color:black;
    text-decoration: none;
}
a:hover {
    text-decoration: underline;
    background: #eaeaea;
}
.bd_eintragen {
    width:100%;
    border:1px solid black;
}
.calender {	
	margin-top:45px;
    width:100%;
    border:1px solid black;
}
* html .calender,
* + html .calender {
    width:100%;
}
.calender div.after,
.calender div.before{
    color:silver;
}
.day {
    float:left;
    width:14.285%;    
    line-height: 40px;
    text-align: center;
}
.day.headline {
    background:grey;
}
.day.current {
	color: red;
    font-weight:bold;
}
.day.normal {
    
}
.blutdruck { 
	line-height: 125%;
    text-align: center;
}
.clear {
    clear:left;
}
.pagination {
    text-align: center;
    height:40px;
    line-height:20px;
    font-weight: bold;
}
.pagihead { 
   display:inline-block;
   background: white;
   width: 140px;
   height: 20px;
   color: black;
}
.pagination a {
    width:10%;
    height:40px;
	font-size: 200%;
}

ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
    background-color: grey;
    position: fixed;
    top: 0;
    width: 99%;
}

li {
    float: left;
}

li a {
    display: block;
    color: white;
    text-align: center;
    padding: 14px 16px;
    text-decoration: none;
}
</style>
</head>
<body>



<?php


if( isset($_REQUEST['timestamp'])) $date = $_REQUEST['timestamp'];
else $date = time();

$arrMonth = array(
    "January" => "Januar",
    "February" => "Februar",
    "March" => "M&auml;rz",
    "April" => "April",
    "May" => "Mai",
    "June" => "Juni",
    "July" => "Juli",
    "August" => "August",
    "September" => "September",
    "October" => "Oktober",
    "November" => "November",
    "December" => "Dezember"
);
    
$headline = array('Mon','Die','Mit','Don','Fre','Sam','Son');

?>
<div class="calender">
    <div class="pagination">
        <a href="?timestamp=<?php echo yearBack($date); ?>" class="last">|&laquo;</a> 
        <a href="?timestamp=<?php echo monthBack($date); ?>" class="last">&laquo;</a> 
        <div class="pagihead">
           <span><?php echo $arrMonth[date('F',$date)];?> <?php echo date('Y',$date); ?></span>
        </div>
        <a href="?timestamp=<?php echo monthForward($date); ?>" class="next">&raquo;</a>
        <a href="?timestamp=<?php echo yearForward($date); ?>" class="next">&raquo;|</a>  
    </div>
    <?php getCalender($date,$headline); ?>
    <div class="clear"></div>
</div>
<div class="bd_eintragen">    
        <?php 		
		include 'header.html';
		blutdruckform(); ?>	
</div>

</body>
</html>