<?php
require 'db_connect.php';
require 'class.php';
date_default_timezone_set("Asia/Bangkok");
$eDate = $_REQUEST["xDate"];
$date = strtotime($eDate);
$date = strtotime("+1 day", $date);
$sDate =  date('Y-m-d', $date);

$date = strtotime($eDate);
$date = strtotime("+5 day", $date);
$lDate =  date('Y-m-d', $date);

$dateobj = new DatetimeTH;
$xUrl = $_REQUEST["xUrl"];

if(isset($_REQUEST["Fl"]))
{
	$Fl = $_REQUEST["Fl"];
}else {
	$Fl = 1;
}

?>
<!--
 *  -- ************************************************************
 -- Author		:	Tanadech
 -- Create date	:	03-09-2017
 -- Update By	:	Tanadech
 -- Update date	:   03-09-2017
 -- Description	:
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
		<script src="js/jquery.mobile-1.4.5.min.js"></script>
        <script type="application/javascript">
		function gotoNewUrl(xLink,eDate,Fl) {
			window.open( xLink+"?xDate="+eDate+"&Fl="+Fl );
		}
			function gotoUrl(xLink,sDate,lDate) {
				//alert("mCustomer.php?xItc="+xItc+"&DueDate="+DueDate)
				location.href = xLink+"?sDate="+sDate+"&lDate="+lDate;
			}

			function gotoUrlDetail(DueDate,NameTH,eDate,Item_Code) {
				location.href = "prebread_detail.php"+"?xDate="+eDate+"&DueDate="+DueDate+"&xUrl=prebread.php"+"&NameTH="+NameTH+"&Item_Code="+Item_Code;
			}

			function gotoMenu(xLink,DueDate) {
				location.href = xLink+"?xDate="+DueDate;
			}

      function gotoFilter(xLink,DueDate,Fl,xUrl) {
				location.href = xLink+"?xDate="+DueDate+"&Fl="+Fl+"&xUrl="+xUrl;
			}

		</script>
	</head>

	<body>
 	<div data-demo-html="true">
		<div data-role="header">
			<a href="#" onClick='gotoMenu("<?=$xUrl?>","<?=$eDate?>");' class="ui-btn-left ui-btn ui-btn-b ui-btn-inline ui-mini ui-corner-all ui-btn-icon-left ui-icon-circle-triangle-w ui-icon-carat-l">Back</a>
            		<h1>รายการสั่งซื้อ (บจก./หจก.)</h1>
			<a href="#" onClick='gotoNewUrl("purchase_order_print.php","<?=$eDate?>","<?=$Fl?>");' class="ui-btn-right ui-btn ui-btn-b ui-btn-inline ui-mini  ui-btn-icon-right ui-icon-grid">Print ล่วงหน้า 1 วัน</a>

		</div>
	</div>

	<div data-role="content">
		<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<div style="font-size: 20"><b>วัน<?=$dateobj->getTHday(date('l', strtotime($eDate)));?>
			 ที่ <?=date('d',strtotime($eDate));?> เดือน <?=$dateobj->getTHmonth(date('F',strtotime($eDate)));?> พ.ศ. <?=$dateobj->getTHyear(date('Y',strtotime($eDate)));?> </b></div>
       <br>
       <fieldset data-role="controlgroup" data-type="horizontal">
				 <?php if($Fl==1){
					?> <legend>เลือกประเภท : บจก.</legend> <?php
				 }elseif ($Fl==2) {
					?> <legend>เลือกประเภท : หจก.</legend> <?php
				 }else {
					?> <legend>เลือกประเภท : สต๊อกน้ำ</legend> <?php
				 } ?>
             <input type="radio" name="radio-choice-h-2" id="radio-choice-h-2a" value="on"
     onClick='gotoFilter("purchase_order.php","<?=$eDate?>",1,"<?=$xUrl?>");'>
             <label for="radio-choice-h-2a">บจก.</label>
             <input type="radio" name="radio-choice-h-2" id="radio-choice-h-2b" value="off"
     onClick='gotoFilter("purchase_order.php","<?=$eDate?>",2,"<?=$xUrl?>");'>
             <label for="radio-choice-h-2b">หจก.</label>
             <input type="radio" name="radio-choice-h-2" id="radio-choice-h-2c" value="off"
     onClick='gotoFilter("purchase_order.php","<?=$eDate?>",3,"<?=$xUrl?>");'>
             <label for="radio-choice-h-2c">สต๊อกน้ำ</label>
         </fieldset>

    <table data-role="table" id="table-custom-2" data-mode="columntoggle" class="ui-body-d ui-shadow table-stripe ui-responsive" data-column-btn-theme="b" data-column-btn-text="Columns to display..." data-column-popup-theme="a">
			<thead style='display:block;'>
				<tr class="ui-bar-d">
           <th  style="vertical-align: middle;" width="50px" data-priority="2">ลำดับ</th>
					 <th  style="vertical-align: middle;" width="100px" data-priority="2">วันที่</th>
           <th  style="vertical-align: middle;" width="150px" data-priority="2">Barcode</th>
					 <th  style="vertical-align: middle;" width="600px" data-priority="2">รายการสินค้า</th>
           <th  style="vertical-align: middle;" width="100px" data-priority="2">หน่วยนับ</th>
					 <th  style="vertical-align: middle;" width="100px" data-priority="2">ราคา</th>
           <th  style="vertical-align: middle;" width="150px" data-priority="2">จำนวน</th>
				</tr>
			</thead>
			<tbody style='height:400px;display:block;overflow:scroll'>

			<?
				$Sql = "SELECT purchaseorder.DocNo,item.Barcode,
								purchaseorder.DocDate,
                item.Item_Code,
                item.NameTH,
                purchaseorder_detail.Qty,
                item_unit.Unit_Name,
                item.SalePrice,
                branch.Branch_Name
                FROM item
                INNER JOIN purchaseorder_detail ON purchaseorder_detail.Item_Code = item.Item_Code
                INNER JOIN purchaseorder ON purchaseorder.DocNo = purchaseorder_detail.DocNo
                INNER JOIN item_unit ON item_unit.Unit_Code = item.Unit_Code
                INNER JOIN branch ON branch.Branch_Code = purchaseorder_detail.Branch_Code
                WHERE purchaseorder_detail.Qty > 0 ";

                if($Fl==1){
                  $Sql .= " AND purchaseorder_detail.Branch_Code = 5 ";
                }elseif ($Fl==2) {
                  $Sql .= " AND purchaseorder_detail.Branch_Code = 6 ";
                }else {
                  $Sql .= "AND purchaseorder_detail.Branch_Code = 3 ";
                }

                $Sql .= " ORDER BY purchaseorder.DocDate DESC LIMIT 100";
						    //var_dump($Sql);
				$row = 1;
				$meQuery = mysql_query( $Sql );
    			while ($Result = mysql_fetch_assoc($meQuery)){
			?>
				<tr>
					<td style="vertical-align: middle;" width="50px"><?=$row?></td>
					<td style="vertical-align: middle;" width="100px"><?=$Result["DocDate"]?></td>
          <td style="vertical-align: middle;" width="150px"><?=$Result["Barcode"]?></td>
					<td style="vertical-align: middle;" width="600px"><b><?=$Result["NameTH"]?></b></td>
          <td style="vertical-align: middle;" width="100px"><?=$Result["Unit_Name"]?></td>
          <td style="vertical-align: middle;" width="100px"><?=$Result["SalePrice"]?></td>
					<td style="vertical-align: middle;" width="150px"><?=(int)$Result["Qty"]?></td>
				</tr>
			<?
				$row++;

				}
			?>

			</tbody>
		</table>

</div>
</form>
<div data-role="footer">
  <h1>FAI BAKERY CHIANGMAI</h1>
		</div>
</div>

	</body>
</html>
