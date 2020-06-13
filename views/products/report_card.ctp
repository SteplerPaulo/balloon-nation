<?php
App::import('Vendor','report_card');
$pr= new ReportCard();

$pr->box();
$pr->hdr();
$pr->learning_areas();
$pr->observed_values();
$pr->attendance();
$pr->legend();

$pr->output();


?>