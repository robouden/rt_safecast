<?php
/* Default verbose value */
defined('VERBOSE') || define('VERBOSE', false);
/* Default reset value  */
defined('RESET') || define('RESET', false);
/* Default mutex value  */
defined('CLEAN_MUTEX') || define('CLEAN_MUTEX', false);

/* Defining environmental variables necessary to load WP */
define('DOING_AJAX', 	true);
define('WP_USE_THEMES',	false);

$_SERVER          = array(
	'HTTP_HOST'      => 'realtime.safecast.com',
	'SERVER_NAME'    => 'realtime.safecast.com',
	'REQUEST_URI'    => '/',
	'REQUEST_METHOD' => 'GET',
	'REMOTE_ADDR'    =>	'127.0.0.1',
	'DOCUMENT_ROOT'  => dirname(dirname(__FILE__)).'/site',
	'PHP_SELF'       => 'index.php',
	'SCRIPT_NAME'    => 'index.php',
);

/* Loading WP to enable post update */
require_once(dirname(dirname(__FILE__)).'/site/wordpress/wp-load.php');

/* Loading composer requirements */
require_once(dirname(__FILE__).'/vendor/autoload.php');

/* Safecast API URL format */
define('API_URI_INFO_FORMAT', 'https://api.safecast.org/devices/%s.json');
define('API_URI_CREATE_FORMAT', 'https://api.safecast.org/en-US/measurements.json?device_id=%s&per_page=1000&order=captured_at+asc');
define('API_URI_UPDATE_FORMAT', 'https://api.safecast.org/en-US/measurements.json?device_id=%s&per_page=1000&captured_after="%s"&order=captured_at+asc');

function getSensorType($postId, $sensorId, $reset) {
	$type = get_post_meta($postId, 'sensor_type', TRUE);
	
	if (!$type || $reset) {
		if (VERBOSE) {
			printf("Retrieving information for device %s\n", $sensorId);
		}
		$uri	= sprintf(API_URI_INFO_FORMAT, $sensorId);
		
		/* Querying the API */
		$response    = \Httpful\Request::get($uri)->send();
		$information = $response->body;
		
		updateSensorInformation($postId, $information);
		$type = get_post_meta($postId, 'sensor_type', TRUE);
	}
	
	return $type;
}

function updateSensorsMeasurements() {
	$args                = array(
	  'post_type'        => 'sensors',
	  'posts_per_page'   => -1);
	$query               = new WP_Query($args);

	if ($query->have_posts()) {
		if (CLEAN_MUTEX) {
			/* Update each sensor if we find them in the measurements */
			while ($query->have_posts()) {
				$query->the_post();
				
				if (VERBOSE) {
					printf("Cleaned mutex for post %s\n", get_the_ID());
				}
				update_post_meta(get_the_ID(), 'sensor_mutex', FALSE);
			}
		}
		
		/* Update each sensor if we find them in the measurements */
		while ($query->have_posts()) {
			$query->the_post();
			
			$sensorId = get_post_meta(get_the_ID(), 'sensor_id', TRUE);
			$reset    = RESET;
			
			if ($sensorId) {
				$mutex = get_post_meta(get_the_ID(), 'sensor_mutex', TRUE);
				
				if (!$mutex) {
					/* Blocking the sensor */
					update_post_meta(get_the_ID(), 'sensor_mutex', TRUE);
					
					try {
						if (getSensorType(get_the_ID(), $sensorId, $reset)) {
							if (VERBOSE) {
								printf("Retrieving measurements for device %s\n", $sensorId);
							}
							
							/* Iterate while there is measurements */
							while (42) {
								$sinceTimestamp = strtotime(get_post_meta(get_the_ID(), 'sensor_measurement_last_gmt', TRUE));
								
								/* Preparing the query for the API */
								if ($reset || !$sinceTimestamp) {
									$since = 'inception';
									$uri   = sprintf(API_URI_CREATE_FORMAT, $sensorId);
								} else {
									$since = gmdate("Y-m-d\TH:i:s\Z", $sinceTimestamp);
									$uri   = sprintf(API_URI_UPDATE_FORMAT, $sensorId, $since);
								}
								if (VERBOSE) {
									printf("> Quering the API for new measurements since %s\n", $since);
								}
								
								/* Querying the API */
								$response     = \Httpful\Request::get($uri)->send();
								$measurements = $response->body;
								
								if (is_array($measurements) && count($measurements)) {
									if (VERBOSE) {
										printf("> %d new measurement(s)\n", count($measurements));
									}
									
									$filehandle	= getLogFilehandle($sensorId, $reset);
									
									foreach ($measurements as $measurement) {
										updateSensorMeasurement(get_the_ID(), $measurement);
										logMeasurement($filehandle, get_the_ID());
										
										$reset	= false;
									}
									
									fclose($filehandle);
								} else {
									if (VERBOSE) {
										printf("> No new measurement\n");
									}
									
									break;
								}
							}
						}
					} catch (\Exception $e) {
						printf("Error while updating device %s\n", $sensorId);
					}
					
					/* Freeing the sensor */
					update_post_meta(get_the_ID(), 'sensor_mutex', FALSE);
				} else {
					if (VERBOSE) {
						printf("Device %s is already beeing processed\n", $sensorId);
					}
				}
			}
		}
	}

	wp_reset_query();
}
