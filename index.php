<?php 
/* Functions */
function readCSV($csvFile){
	$file_handle = fopen($csvFile, 'r');
	 while (!feof($file_handle) ) {
		$line_of_text[] = fgetcsv($file_handle, 1024);
	}
	fclose($file_handle);
	return $line_of_text;	
}


$first_csv_file = "data-a.csv";
$second_csv_file = "data-b.csv";
/* Functions End */

/* include Dropbox Library file */
require_once "Dropbox/autoload.php";
use \Dropbox as dbx;

//configuration of dropbox
$appInfo = dbx\AppInfo::loadFromJsonFile("app-info.json");
$webAuth = new dbx\WebAuthNoRedirect($appInfo, "PHP-Example/1.0");

//access file from dropbox
$accessToken = "4DK3_Q9x-YAAAAAAAAAAS-tnAaiFa42LXEBW2PIWTO4QpfVfMSVtf1kxAhf_WFU3";
$dbxClient = new dbx\Client($accessToken, "PHP-Example/1.0");

//list directory of dropbox
$folderMetadata = $dbxClient->getMetadataWithChildren("/");

// Set path to CSV file

$f = fopen($first_csv_file, "w+b");
$csv1_meta = $dbxClient->getFile("/".$first_csv_file, $f);
fclose($f);

//Set path to CSV file

$f = fopen($second_csv_file, "w+b");
$csv2_meta = $dbxClient->getFile("/".$second_csv_file, $f);
fclose($f);
 
$csv1 = readCSV($first_csv_file);

//Set path to CSV file

$csvFile = $second_csv_file;
 
$csv2 = readCSV($csvFile);

foreach($csv1 as $s)
{
	$array = array();
	$array[] = $s[0];
	$array[] = $s[2];
	$array[] = $s[4];
	$array[] = $s[5];
	$abc[] 	 = $array;
}

  $i=0;
foreach($csv2 as $s1)
{
	$array = array();
	$abc[$i][] = $s1[0];
	$abc[$i][] = $s1[2];
	$abc[$i][] = $s1[3];
	$i++;
}

//create new csv file on dropbox 
$file = fopen('final-raxis.csv', 'w');                              
fputcsv($file);      
foreach($abc as $row) {
fputcsv($file, $row);              
}

//upload a file to dropbox
$f = fopen("final-raxis.csv", "rb");
$result = $dbxClient->uploadFile("/final-raxis.csv", dbx\WriteMode::add(), $f);
fclose($f);

?>