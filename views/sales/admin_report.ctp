<?php
App::import('Vendor','sales_report');
//pr($data);exit;
$report= new SalesReport();
$report->hdr();
$report->dtls();
$report->output();


?>