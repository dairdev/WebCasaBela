<?php
// Your Supabase API URL and Anon Key
$SUPABASE_URL = 'https://your-project-id.supabase.co/rest/v1';
$SUPABASE_API_KEY = 'your-anon-key';

// Function to make GET requests
function supabase_get($table, $filters = [])
{
    global $SUPABASE_URL, $SUPABASE_API_KEY;

    // Build the query string with filters
    $query = http_build_query($filters);

    // Set the request URL for the desired table
    $url = "$SUPABASE_URL/$table?$query";

    // Initialize cURL
    $ch = curl_init();

    // Set the cURL options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "apikey: $SUPABASE_API_KEY",
        "Authorization: Bearer $SUPABASE_API_KEY",
        "Content-Type: application/json",
    ]);

    // Execute the request
    $response = curl_exec($ch);

    // Close cURL session
    curl_close($ch);

    // Return the response
    return json_decode($response, true);
}

// Fetch data from the 'districts' table where 'province_id' is 1
$response = supabase_get('districts', ['province_id' => 'eq.1']);

// Output the response
print_r($response);
?>

