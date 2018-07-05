<?php
App::import('Vendor','double_entry_list');
//pr($data);exit;
$report= new DoubleEntryList();
$report->hdr();
$report->dtls($data);
$report->output();


?>