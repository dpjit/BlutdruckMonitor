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
table.tag th,td{
	text-align:right;
	border: none;
}

table.tag {
	float: left;
	width:100%;	
	padding: 0px;
	margin:0px;
}

table.monat {
	width:100%;
	border: 1px solid black;
	page-break-inside: avoid;
}
table.monat td {
	width:5.8823529%;
	padding: 0px;	
}
table.monat tr {
	border: 1px solid black;	
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
@media print {
.no-print {
	display: none !important;}
}
</style>
<?php 
include 'header.html';
echo "<div class='no-print' style='height:40px;'></div>";
include 'db.php';
function printDrucken() {
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
    "December" => "Dezember");	
	
	$firstdate = mktime(0,0,0,explode("-",selectfirstorlast(True))[1],1,explode("-",selectfirstorlast(True))[0]);	
	$lastdate = mktime(0,0,0,explode("-",selectfirstorlast(False))[1],1,explode("-",selectfirstorlast(False))[0]);    		
	
	for( $m = $firstdate; $m <= $lastdate; $m=mktime(0,0,0,date("n",$m)+1,1,date("Y",$m))) { 	
    $sum_days = date('t',$m);
	echo "<table class='monat'>";
	echo "<tr><th colspan='2'>".$arrMonth[date("F",$m)]." ".date("Y",$m)."<th></tr>";
    for( $i = 1; $i <= $sum_days; $i++ ) { 

        if( $i == 1 or $i == 16) {			
            echo "<tr><td><table class='tag'><tr><th>&nbsp;</th></tr><tr><th>oW</th></tr><tr class='grade'><th>uW</th></tr><tr><th>Puls</th></tr></table></td>";            
        }		
		$daten = dbselect2(date("Y-m-d",mktime(0,0,0,date("n",$m),$i,date("Y",$m))));
		echo "<td><table class='tag'><tr><th>".$i."</th></tr><tr><td>".$daten[0]."</td></tr><tr class='grade'><td>".$daten[1]."</td></tr><tr><td>".$daten[2]."</td></tr></table></td>";
		if($i == 15 or $i == $sum_days) echo "</tr>";
		if($i == $sum_days) echo "</table><br>";
    }
	}
	
	
}
printDrucken();
?>