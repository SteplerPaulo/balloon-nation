<?php
App::import('Vendor','complete_list_of_double_entry');

//pr(count($data));exit;



$array_chunk =array_chunk($data, 46);


$report= new CompleteListOfDoubleEntry();
foreach($array_chunk as $key => $products){
	$report->hdr();
	$report->dtls($products);	
	if(count($array_chunk) != $key+1){$report->createSheet();}
}
$report->output();



?>