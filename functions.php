<?php 

require 'db.php';

function addMaintenance() {
    global $db;
    
    $gagal = '';
    if(isset($_POST['submit'])) {
        $item = $_POST['item'];
        $deskripsi = $_POST['deskripsi'];
        $biaya = $_POST['biaya'];
        $tanggal = $_POST['tanggal'];

        $formattedDate = DateTime::createFromFormat('d/m/Y', $tanggal);

        if ($formattedDate) {
            $tanggal = $formattedDate->format('Y-m-d');
        } else {
            $gagal = "Format tanggal tidak valid.";
        }

        if (empty($judul) && empty($deskripsi) && empty($tanggal) && empty($biaya)) {
            $gagal = "Silakan isi form maintenance.";
        } else {
            $db->query("INSERT INTO computer_services (item, deskripsi, tanggal, biaya) VALUES ('$item', '$deskripsi', '$tanggal', '$biaya')");
            header('Location: index.php');
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
    $ambil = $db->query("SELECT * FROM computer_services WHERE id = '$id'");
    
    return $ambil->fetchArray(SQLITE3_ASSOC);
}   

function updateMaintenance() {
    global $db;

    if(isset($_POST['id'])) {
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
            $db->query("UPDATE computer_services SET item = '$item', deskripsi = '$deskripsi', tanggal = '$tanggal', biaya = '$biaya' WHERE id = '$id'");
            header('Location: index.php');
        }
    }
}

function deleteMaintenance() {
    global $db;

    if(isset($_GET['delete'])) {
        $id = $_GET['delete'];
        $db->query("DELETE FROM computer_services WHERE id = '$id'");
        header('Location: index.php');
        exit;
    }
}