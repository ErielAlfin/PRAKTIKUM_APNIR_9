<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Content-Type: application/json");
 
include "../config/koneksi.php"; 
 
$query = mysqli_query($conn, "SELECT id, username, email, foto FROM users ORDER 
BY id DESC"); 
 
$data = []; 
 
if ($query) { 
    while ($row = mysqli_fetch_assoc($query)) { 
        $data[] = $row; 
    } 
    echo json_encode([ 
        "status" => true, 
        "data" => $data 
    ]); 
} else { 
    echo json_encode([ 
        "status" => false, 
        "message" => "Gagal mengambil data: " . mysqli_error($conn) 
    ]); 
} 
?>