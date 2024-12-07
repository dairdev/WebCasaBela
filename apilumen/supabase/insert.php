<?php
// Function to make POST requests (Insert data)
function supabase_insert($table, $data)
{
    global $SUPABASE_URL, $SUPABASE_API_KEY;

    // Set the request URL for the desired table
    $url = "$SUPABASE_URL/$table";

    // Initialize cURL
    $ch = curl_init();

    // Set the cURL options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
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

// Insert data into 'districts' table
$data = [
    'name' => 'New District',
    'province_id' => 1,
    'created_by' => 1,
];

$response = supabase_insert('districts', $data);

// Output the response
print_r($response);
?>

