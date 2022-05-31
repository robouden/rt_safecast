<?php
// dev.safecast.org gateway
//
// ----------------------------------------------------------------
// The contents of this file are distributed under the CC0 license.
//  See http://creativecommons.org/publicdomain/zero/1.0/
// ----------------------------------------------------------------

/**
* Generates an UUID
*
* @param      string  an optional prefix
* @return     string  the formatted uuid
*/

function uuid($prefix = '')
{
    $chars = md5(uniqid(mt_rand(), true));
    $uuid  = substr($chars,0,8) . '-';
    $uuid .= substr($chars,8,4) . '-';
    $uuid .= substr($chars,12,4) . '-';
    $uuid .= substr($chars,16,4) . '-';
    $uuid .= substr($chars,20,12);
    return $prefix . $uuid;
}

// Set UTC time mode
date_default_timezone_set("UTC");

// Retrieve the request's body and parse it as JSON
$body = @file_get_contents('php://input');

// Decode JSON body and add the timestamp
$measurement_json = json_decode($body,true);
$measurement_json["captured_at"] = date("Y-m-d\TH:i:s\Z", time());

// Repack the data in JSON
$data_string = json_encode($measurement_json);

// POST to dev.safecast.org
$ch = curl_init('http://dev.safecast.org/measurements.json?api_key='.$_GET["api_key"]);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($data_string))
);

$result = curl_exec($ch);

echo $result;

// Log to file
$filename = "logs/" . date('Ymd') . "_" . $measurement_json["device_id"] . ".txt";
file_put_contents($filename,  $data_string. "\n", FILE_APPEND);
file_put_contents($filename,  $result. "\n", FILE_APPEND);
file_put_contents($filename,  "--------------------------------------------------------------------------------\n", FILE_APPEND);

// Log for data warehouse via FlyData
$filenameJSON = "logs/measurement_json.log";
file_put_contents($filenameJSON,  $result. "\n", FILE_APPEND);

$filenameCSV = "logs/" . date('Ymd') . "_" .$measurement_json["device_id"] . ".csv";
file_put_contents($filenameCSV,  $measurement_json["device_id"] . "," . $measurement_json["captured_at"] . "," . $measurement_json["value"] . "," . $measurement_json["longitude"] . "," . $measurement_json["latitude"] . "\n", FILE_APPEND);

# GeoRSS feed
$filenameRSS = "logs/" . date('Ymd') . "_" .$measurement_json["device_id"] . ".xml";
$xml_entry = '<entry><id>'.uuid("urn:uuid:").'</id><title>'.$measurement_json["value"].' PPM</title><updated>'.$measurement_json["captured_at"].'</updated><georss:point>'.$measurement_json["latitude"].' '.$measurement_json["longitude"].'</georss:point><summary>'.$measurement_json["value"].' PPM</summary></entry>';
$xml_footer = '</feed>';

if (!file_exists($filenameRSS)) {
    $xml_output = '<?xml version="1.0"?>'.PHP_EOL;
    $xml_output .= '<feed xmlns="http://www.w3.org/2005/Atom" xmlns:georss="http://www.georss.org/georss">'.PHP_EOL;
    $xml_output .= '  <updated>'.$measurement_json["captured_at"].'</updated>'.PHP_EOL;
    $xml_output .= '  <title>Safecast Device '.$measurement_json["device_id"].' RSS feed</title>'.PHP_EOL;
    $xml_output .= '  <subtitle>Real-time radiation measured from device</subtitle>'.PHP_EOL;
    $xml_output .= '  <link href="http://dev.safecast.org/"/>'.PHP_EOL;
    $xml_output .= '  <author><name>Safecast</name></author>'.PHP_EOL;
    $xml_output .= '  <id>'.uuid("urn:uuid:").'</id>'.PHP_EOL;
    $xml_output .= '  <icon>http://blog.safecast.org/favicon.ico</icon>'.PHP_EOL;
    file_put_contents($filenameRSS,  $xml_output.PHP_EOL, FILE_APPEND);
    file_put_contents($filenameRSS,  $xml_entry.PHP_EOL, FILE_APPEND);
    file_put_contents($filenameRSS,  $xml_footer, FILE_APPEND);
}  else {
    // Remove footer and update the time from XML
    $lines = file($filenameRSS);
    $last = sizeof($lines) - 1 ;
    unset($lines[$last]);
    $lines[2] = '  <updated>'.$measurement_json["captured_at"].'</updated>'.PHP_EOL;

    // write the new data to the file
    $fp = fopen($filenameRSS, 'w');
    fwrite($fp, implode('', $lines));
    fclose($fp);

    // Add new entry and footer
    file_put_contents($filenameRSS,  $xml_entry.PHP_EOL, FILE_APPEND);
    file_put_contents($filenameRSS,  $xml_footer, FILE_APPEND);
}


# GeoRSS feed Air last measurement
$filenameRSS1 = "logs/" .$measurement_json["device_id"] . ".xml";
$xml_entry = '<?xml version="1.0"?>'.PHP_EOL.'<feed xmlns="http://www.w3.org/2005/Atom" xmlns:georss="http://www.georss.org/georss">'.PHP_EOL.'<entry><id>'.uuid("urn:uuid:").'</id><title> '.$measurement_json["value"].' '.$measurement_json["unit"].'       '.$measurement_json["captured_at"].'</title><updated>'.$measurement_json["captured_at"].'</updated><georss:point>'.$measurement_json["latitude"].' '.$measurement_json["longitude"].'</georss:point><summary>Device ID = '.$measurement_json["device_id"] .' Height = '.$measurement_json["height"].' </summary></entry></feed>';

  file_put_contents($filenameRSS1,  $xml_entry);
?>
