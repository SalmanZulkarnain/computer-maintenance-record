<?php

require 'db.php';
require 'functions.php';

$gagal = '';

$maintenances = viewMaintenance();

deleteMaintenance();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'tambah':
                $gagal = addMaintenance(); 
                break;
            case 'update':
                updateMaintenance(); 
                break;
        }
    }
}

$maintenance_edit = null;
if (isset($_GET['edit'])) {
    $maintenance_edit = ambilMaintenance();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Computer Maintenance Record</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="modal-container">
            <!-- TAMBAH -->
            <input type="checkbox" id="modal-tambah" class="modal-tambah">
            <label class="modal-btn" for="modal-tambah">TAMBAH</label>
            <div class="modal">
                <div class="modal-content">
                    <h2>Isi Maintenance</h2>
                    <?php if (!empty($gagal)): ?>
                        <p style="color: red;"><?php echo $gagal; ?></p>
                    <?php endif; ?>
                    <form action="index.php" method="post">
                        <input type="hidden" name="action" value="tambah">
                        <div class="input-group">
                            <input type="text" name="item" placeholder="Masukkan item yang dimaintenance">
                        </div>
                        <div class="input-group">
                            <input type="text" name="deskripsi" placeholder="Masukkan deskripsi maintenance">
                        </div>
                        <div class="input-group">
                            <input type="number" name="biaya" placeholder="Masukkan biaya maintenance">
                        </div>
                        <div class="input-group">
                            <input type="date" name="tanggal" placeholder="Masukkan tanggal maintenance">
                        </div>
                        <div class="input-group">
                            <input type="submit" name="submit" value="Tambah">
                        </div>
                    </form>
                    <label class="modal-close" for="modal-tambah">Tutup</label>
                </div>
            </div>

            <!-- EDIT  -->
            <input type="checkbox" id="modal-update" class="modal-update" <?php if (isset($_GET['edit'])) echo 'checked'; ?>>
            <div class="modal">
                <div class="modal-content">
                    <h2>Edit Maintenance</h2>
                    <?php if (!empty($gagal)): ?>
                        <p style="color: red;"><?php echo $gagal; ?></p>
                    <?php endif; ?>
                    <form method="post" action="index.php">
                        <input type="hidden" name="action" value="update">
                        <?php if ($maintenance_edit): ?>
                            <input type="hidden" name="id" value="<?php echo $maintenance_edit['id']; ?>">
                        <?php endif; ?>

                        <div class="input-group">
                            <input type="text" name="item" value="<?php echo $maintenance_edit['item'] ?>" placeholder="Masukkan item yang dimaintenance">
                        </div>
                        <div class="input-group">
                            <input type="text" name="deskripsi" value="<?php echo $maintenance_edit['deskripsi'] ?>" placeholder="Masukkan deskripsi maintenance">
                        </div>
                        <div class="input-group">
                            <input type="number" name="biaya" value="<?php echo $maintenance_edit['biaya'] ?>" placeholder="Masukkan biaya maintenance">
                        </div>
                        <div class="input-group">
                            <input type="date" name="tanggal" value="<?php echo $maintenance_edit['tanggal'] ?>" placeholder="Masukkan tanggal maintenance">
                        </div>
                        <div class="input-group">
                            <input type="submit" name="submit" value="Update">
                        </div>
                    </form>
                    <label class="modal-close" for="modal-update">Tutup</label>
                </div>
            </div>
        </div>

        <!-- TABLE CONTAINER -->
        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <td>No</td>
                        <td>Item</td>
                        <td>Deskripsi</td>
                        <td>Biaya</td>
                        <td>Tanggal</td>
                        <td colspan="2">Aksi</td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($maintenances as $key => $maintenance) {
                        $formattedDate = date('d/m/Y', strtotime($maintenance['tanggal']));
                    ?>
                        <tr>
                            <td><?php echo $key + 1; ?></td>
                            <td><?php echo $maintenance['item']; ?></td>
                            <td><?php echo $maintenance['deskripsi']; ?></td>
                            <td>Rp<?php echo number_format($maintenance['biaya']); ?></td>
                            <td><?php echo $formattedDate; ?></td>

                            <!-- EDIT -->
                            <td class="edit_btn"><a href="index.php?edit=<?php echo $maintenance['id']; ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                            </td>

                            <!-- DELETE -->
                            <td class="delete_btn"><a href="index.php?delete=<?php echo $maintenance['id']; ?>" onclick="return confirm('Apakah anda yakin ingin menghapus?')"><i class="fa-solid fa-trash"></i></a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>