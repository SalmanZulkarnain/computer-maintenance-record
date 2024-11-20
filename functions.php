<?php 
require 'db.php';

function addMaintenance() {
    global $db;
    
    $gagal = '';
    if (isset($_POST['submit'])) {
        $item = $_POST['item'];
        $deskripsi = $_POST['deskripsi'];
        $tanggal = $_POST['tanggal'];
        $biaya = $_POST['biaya'];

        $formattedDate = DateTime::createFromFormat('d/m/Y', $tanggal);

        if ($formattedDate) {
            $tanggal = $formattedDate->format('Y-m-d');
        } else {
            $gagal = "Format tanggal tidak valid.";
        }

        if (empty($judul) && empty($deskripsi) && empty($tanggal) && empty($biaya)) {
            $gagal = "Silakan isi form maintenance.";
        } else {
            $stmt = $db->prepare("INSERT INTO computer_services (item, deskripsi, tanggal, biaya) VALUES (:item, :deskripsi, :tanggal, :biaya)");
            $stmt->bindParam(':item', $item, SQLITE3_TEXT);
            $stmt->bindParam(':deskripsi', $deskripsi, SQLITE3_TEXT);
            $stmt->bindParam(':tanggal', $tanggal, SQLITE3_TEXT);
            $stmt->bindParam(':biaya', $biaya, SQLITE3_FLOAT);

            if ($stmt->execute()) {
                header('Location: index.php');
                exit;
            } else {
                $gagal = "Gagal menyimpan data ke database";
            }
            exit;
        }
    }
    return $gagal;
}

function viewMaintenance() {
    global $db;
    
    $result = $db->query("SELECT * FROM computer_services");
    $data = [];
    while($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $data[] = $row;
    }

    return $data;
}

function ambilMaintenance() {
    global $db;

    if (!isset($_GET['edit'])) {
        return null; 
    }

    $id = $_GET['edit'];    
    $stmt = $db->prepare("SELECT * FROM computer_services WHERE id = :id");
    $stmt->bindParam(':id', $id, SQLITE3_INTEGER);
    $result = $stmt->execute();
    
    return $result->fetchArray(SQLITE3_ASSOC);
}   

function updateMaintenance() {
    global $db;

    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $item = $_POST['item'];
        $deskripsi = $_POST['deskripsi'];
        $tanggal = $_POST['tanggal'];
        $biaya = $_POST['biaya'];

        $formattedDate = DateTime::createFromFormat('d/m/Y', $tanggal);

        if ($formattedDate) {
            $tanggal = $formattedDate->format('Y-m-d');
        } 
        
        if (!empty($item) && !empty($deskripsi) && !empty($tanggal) && !empty($biaya)) {
            $stmt = $db->prepare("UPDATE computer_services SET item = :item, deskripsi = :deskripsi, tanggal = :tanggal, biaya = :biaya WHERE id = :id");
            $stmt->bindParam(':item', $item, SQLITE3_TEXT);
            $stmt->bindParam(':deskripsi', $deskripsi, SQLITE3_TEXT);
            $stmt->bindParam(':tanggal', $tanggal, SQLITE3_TEXT);
            $stmt->bindParam(':biaya', $biaya, SQLITE3_FLOAT);
            $stmt->bindParam(':id', $id, SQLITE3_INTEGER);

            if ($stmt->execute()) {
                header('Location: index.php');
                exit;
            }
        }
    }
}

function deleteMaintenance() {
    global $db;

    if (isset($_GET['delete'])) {
        $id = $_GET['delete'];
        $stmt = $db->prepare("DELETE FROM computer_services WHERE id = :id");
        $stmt->bindParam(':id', $id, SQLITE3_INTEGER);
        
        if ($stmt->execute()) {
            header('Location: index.php');
            exit;
        }
    }
}