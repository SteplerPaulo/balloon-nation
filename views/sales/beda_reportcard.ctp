<?php
App::import('Vendor','beda_reportcard');

$report= new ReportCard();
$report->box();
$report->hdr();
$report->learning_areas();
$report->learning_areas(3.2,'2nd Semester');

$report->createSheet();
$report->box();
$report->attendance();
$report->observed_values();
$report->legend();
$report->certificate_of_transfer();

$report->output();



?>