<?php
	require 'db_connect.php';
	date_default_timezone_set("Asia/Bangkok");
	$fn = $_REQUEST["FN"];

if($fn==""){
	$xDate = date('Y-m-d');
}else if($fn==1){
	$xDate = $_REQUEST["xDate"];
	$date = strtotime($xDate);
	$date = strtotime("-1 day", $date);
	$xDate =  date('Y-m-d', $date);
}else if($fn==2){
	$xDate = $_REQUEST["xDate"];
	$date = strtotime($xDate);
	$date = strtotime("+1 day", $date);
	$xDate =  date('Y-m-d', $date);
}
/*
	$Sql = "SELECT buffer_fac_order.xDt
FROM buffer_fac_order
ORDER BY buffer_fac_order.xDt DESC LIMIT 1";
	$meQuery = mysql_query( $Sql );
    while ($Result = mysql_fetch_assoc($meQuery)){
		$xDate = $Result["xDt"];
	}
	*/
?>
<!--
 *  -- *********************************************************
 -- Author		:	PARADOX
 -- Create date	:	25-07-2017
 -- Update date	:	PARADOX
 -- Update By	:   25-07-2017
 -- Description	:	menu [Version 1.0]
 -- ************************************************************
-->

<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/themes/default/jquery.mobile-1.4.5.min.css">
		<script src="js/jquery-1.11.3.min.js"></script>
		<script src="js/jquery.js"></script>
		<script src="_assets/js/index.js"></script>
		<script src="js/jquery.mobile-1.4.5.min.js"></script>
        <script type="application/javascript">
			function gotoUrl(xLink,DueDate,FN) {
				location.href = xLink+"?xDate="+DueDate+"&FN="+FN;
			}
			function getDateNow(xLink,xUrl,DueDate,Fl) {
				location.href = xLink + "?xDate="+DueDate.substring(0, 10)+"&xUrl="+xUrl+"&Fl="+Fl;
			}
		</script>
	</head>
	<body>

<div data-role="header">
			<a href="#" onClick='gotoUrl("monitor_stock_menu.php","<?=$xDate?>",1);' class="ui-btn-left ui-btn ui-btn-b ui-btn-inline ui-mini ui-corner-all ui-btn-icon-left ui-icon-circle-triangle-w ui-icon-arrow-l">Previous</a>
            		<h1><?=$xDate?></h1>
			<a href="#" onClick='gotoUrl("monitor_stock_menu.php","<?=$xDate?>",2);' class="ui-btn-right ui-btn ui-btn-b ui-btn-inline ui-mini ui-corner-all ui-btn-icon-right ui-icon-arrow-r">Next</a>
		</div>
</div>

<div data-role="content">
		<ul data-role="listview" data-inset="true">
        	  <li><a style="color:#FE9A2E" href="#" onClick='getDateNow("inventory.php","monitor_stock_menu.php","<?=$xDate?>","1");'><img src="images/warehouse-inventory.png" class="ui-li-icon">รายการคงเหลือสินค้าคลัง (บจก./หจก.)</a></li>
            <li><a style="color:#009900" href="#" onClick='getDateNow("purchase_order.php","monitor_stock_menu.php","<?=$xDate?>","1");'><img src="images/warehouse-inventory.png" class="ui-li-icon">รายการสั่งซื้อ (บจก./หจก.)</a></li>
            <li><a style="color:#FE2E2E" href="#" onClick='getDateNow("receive.php","monitor_stock_menu.php","<?=$xDate?>","1");'><img src="images/warehouse-inventory.png" class="ui-li-icon">รายการบันทึกรับ (บจก./หจก.)</a></li>
            <li><a style="color:#0195c8" href="#" onclick="getDateNow('transmit.php','monitor_stock_menu.php','<?=$xDate?>','1')"><img src="images/warehouse-inventory.png" class="ui-li-icon">รายการบันทึกเบิก (บจก./หจก.)</a></li>

		</ul>

	</div>
<div data-role="footer">
			<h1>FAI BAKERY CHIANGMAI</h1>
</div>
	</body>
</html>
