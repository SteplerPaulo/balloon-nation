<?php
App::import('Vendor','delivery_receipt');
//pr($data);exit;
$report= new DeliveryReceipt();
$report->blue_print();
$report->data($data);
$report->output();


?>