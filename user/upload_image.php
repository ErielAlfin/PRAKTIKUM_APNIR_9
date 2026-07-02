<?php 
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Content-Type: application/json");
 
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') { 
    http_response_code(200); 
    exit(); 
} 
 
include "../config/koneksi.php"; 
 
if (isset($_POST['id']) && isset($_FILES['image'])) { 
    $id_user = $_POST['id']; 
     
    $target_dir = "../uploads/"; 
    $file_name = time() . "_" . basename($_FILES["image"]["name"]); 
    $target_file = $target_dir . $file_name; 
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); 
 
    $valid_extensions = array("jpg", "jpeg", "png"); 
    if (in_array($imageFileType, $valid_extensions)) { 
         
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) { 
             
            $sql = "UPDATE users SET foto = '$file_name' WHERE id = '$id_user'"; 
            $query = $conn->query($sql); 
 
            if ($query) { 
                echo json_encode([ 
                    "status" => "success", 
                    "message" => "Gambar berhasil diupload", 
                    "file_name" => $file_name 
                ]); 
            } else { 
                echo json_encode([ 
                    "status" => "error", 
                    "message" => "Gagal memperbarui database: " . $conn->error 
                ]); 
            } 
        } else { 
            echo json_encode([ 
                "status" => "error", 
                "message" => "Gagal memindahkan file ke direktori server. Periksa apakah folder 
'uploads' sudah dibuat." 
            ]); 
        } 
    } else { 
        echo json_encode([ 
            "status" => "error", 
            "message" => "Format file tidak didukung (Hanya JPG, JPEG, & PNG)" 
        ]); 
    } 
} else { 
    echo json_encode([ 
        "status" => "error", 
        "message" => "Parameter tidak lengkap" 
    ]); 
} 
?>