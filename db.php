<?php 
$db = new SQLite3('computer_services_db.sqlite');

if(!$db) {
    echo $db->lastErrorMsg();
}

$db->query("CREATE TABLE IF NOT EXISTS computer_services (
    id INTEGER PRIMARY KEY,
    item TEXT NOT NULL,
    deskripsi TEXT NOT NULL,
    biaya REAL NOT NULL,
    tanggal DATETIME
)");
