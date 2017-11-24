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
	$Fl = 3;
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
	<head><link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
  table {
      border-collapse: collapse;
  }

  table, td, th {
      border: 1px solid black;
  }
  </style>
  <body onload="window.print()">
  <center><b style="font-size: 24">
    <?php if($Fl==1)
    {
      echo "ใบรรายการบันทึกรับ (บจก.)";
    }elseif ($Fl==2) {
      echo "ใบรรายการบันทึกรับ (หจก.)";
    }else {
      echo "ใบรรายการบันทึกรับ (สต๊อกน้ำ)";
    }?>
  </b>
  <br>389/2 หมู 5 ต.ยางเนิ้ง อ.สารภี เชียงใหม 50140
  <br>โทร. 0-5322-2828
  <br>Email : faibakerylanna@hotmail.com
  <br><br>
  <!--<div style="font-size: 20">ชื่อลูกค้า : <b><?=$FName?></b> วันส่ง : <b><?=date(('d/m/'.(date('Y')+543)),strtotime($DueDate))?></b></div><br>-->




		<br><div style="font-size: 20"><b>วัน<?=$dateobj->getTHday(date('l', strtotime($eDate)));?>
			 ที่ <?=date('d',strtotime($eDate));?> เดือน <?=$dateobj->getTHmonth(date('F',strtotime($eDate)));?> พ.ศ. <?=$dateobj->getTHyear(date('Y',strtotime($eDate)));?> </b></div>
       <br>


    <table data-role="table" class="table table-sm" style="font-size: 11" border="1" >
			<thead>
				<tr>
          <th  style="vertical-align: middle;" width="50px" data-priority="2">ลำดับ</th>
					<th  style="vertical-align: middle;" width="100px" data-priority="2">วันที่รับ</th>
          <th  style="vertical-align: middle;" width="150px" data-priority="2">Barcode</th>
          <th  style="vertical-align: middle;" width="600px" data-priority="2">รายการสินค้า</th>
          <th  style="vertical-align: middle;" width="100px" data-priority="2">หน่วยนับ</th>
          <th  style="vertical-align: middle;" width="100px" data-priority="2">ราคา</th>
          <th  style="vertical-align: middle;" width="150px" data-priority="2">จำนวน</th>
          <th  style="vertical-align: middle;" width="100px" data-priority="2">Lot</th>
          <th  style="vertical-align: middle;" width="100px" data-priority="2">วันที่ผลิต</th>
          <th  style="vertical-align: middle;" width="100px" data-priority="2">วันที่หมดอายุ</th>
				</tr>
			</thead>
			<tbody>

			<?
      $Sql = "SELECT wh_stock_receive.DocDate,item.Barcode,
      item.Item_Code,
      item.NameTH,
      wh_stock_receive_sub.Qty,
      item_unit.Unit_Name,
      item.SalePrice,
      wh_stock_receive_sub.LotNo,
      wh_stock_receive_sub.MFGDate,
      wh_stock_receive_sub.EXPDate
      FROM wh_stock_receive
      INNER JOIN wh_stock_receive_sub ON wh_stock_receive_sub.DocNo = wh_stock_receive.DocNo
      INNER JOIN item ON wh_stock_receive_sub.Item_Code = item.Item_Code
      INNER JOIN item_unit ON item_unit.Unit_Code = item.Unit_Code
      WHERE wh_stock_receive_sub.Item_Code = item.Item_Code
      AND wh_stock_receive_sub.Qty > 0 ";

              if($Fl==1){
                $Sql .= " AND wh_stock_receive.Branch_Code = 5 ";
              }elseif ($Fl==2) {
                $Sql .= " AND wh_stock_receive.Branch_Code = 6 ";
              }else {
                $Sql .= " AND wh_stock_receive.Branch_Code = 3 ";
              }

              $Sql .= " ORDER BY wh_stock_receive.DocDate DESC LIMIT 100";
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
        <td style="vertical-align: middle;" width="100px"><?=$Result["LotNo"]?></td>
        <td style="vertical-align: middle;" width="100px"><?=$Result["MFGDate"]?></td>
        <td style="vertical-align: middle;" width="100px"><?=$Result["EXPDate"]?></td>
      </tr>
    <?
      $row++;

      }
    ?>

    </tbody>
		</table>
  </center>
</body>
