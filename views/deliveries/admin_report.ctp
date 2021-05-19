<?php
if($new){
	App::import('Vendor','delivery_receipt_new');
}else{
	App::import('Vendor','delivery_receipt');
}

$report= new DeliveryReceipt();
$report->blue_print();
$report->data($data);
$report->output();


?>