<?php
// Function to make PATCH requests (Update data)
function supabase_update($table, $data, $filters)
{
    global $SUPABASE_URL, $SUPABASE_API_KEY;

    // Build the query string with filters
    $query = http_build_query($filters);

    // Set the request URL for the desired table and filters
    $url = "$SUPABASE_URL/$table?$query";

    // Initialize cURL
    $ch = curl_init();

    // Set the cURL options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PATCH");
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
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

// Update data in 'districts' table where 'id' is 1
$data = [
    'name' => 'Updated District Name'
];

$response = supabase_update('districts', $data, ['id' => 'eq.1']);

// Output the response
print_r($response);
?>

