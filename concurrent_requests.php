<?php
// Get the query string variable to $countVar if doesn't exits default value is 1.
$countVar = $_GET["count"] ?? 1;

// API url to query.
$url = 'https://postman-echo.com/delay/3';

// Create array for cURL handles.
$curl_arr = array();
//Create variable for cURL multi handle.
$master = curl_multi_init();

/*
For loop that populates the $curl_arr with cURL handles
and setup them and adds them to the cURL multi handle variable ($master).
*/
for ($i = 0; $i < $countVar; $i++) {
    $curl_arr[$i] = curl_init($url);
    // Set option on the given cURL session handle to return the transfer as a string.
    curl_setopt($curl_arr[$i], CURLOPT_RETURNTRANSFER, true);
    // Add a normal cURL handle ($curl_arr[$i]) to a cURL multi handle ($master).
    curl_multi_add_handle($master, $curl_arr[$i]);
}

// Execute each of the handles in the stack while $running is flag is true. 
do {
    curl_multi_exec($master, $running);
    if ($running) {
        curl_multi_select($master);
    }
} while ($running > 0);

// Add the returned value of a cURL handle ()
for ($i = 0; $i < $countVar; $i++) {
    $results[] = json_decode(curl_multi_getcontent($curl_arr[$i]));
}

// Encode the results to json and echo them.
echo json_encode($results);
?>
