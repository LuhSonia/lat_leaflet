<?php
    $mysqli = new mysqli("localhost", "root", "", "singaraja_map");

    // Memeriksa koneksi
    if ($mysqli->connect_error) {
        die("Koneksi database gagal: " . $mysqli->connect_error);
    }

    // Mendapatkan data dari $_POST
    $get_data = json_encode($_POST['data_maps']);

    // Membuat kueri SQL menggunakan prepared statement
    $sql = "INSERT INTO tb_maps (maps) VALUES (?)";
    $stmt = $mysqli->prepare($sql);

    // Memeriksa apakah prepared statement berhasil dibuat
    if ($stmt) {
        // Binding parameter dan eksekusi kueri
        $stmt->bind_param("s", $get_data);
        $stmt->execute();

        // Menutup prepared statement
        $stmt->close();
        
        echo "Data berhasil dimasukkan ke dalam database.";
    } else {
        echo "Error: " . $mysqli->error;
    }

    // Menutup koneksi database
    $mysqli->close();
?>
