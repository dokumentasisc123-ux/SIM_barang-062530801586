<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

require_once "koneksi.php";

$stmt = $pdo->query("
    SELECT barang.*, kategori.nama_kategori
    FROM barang
    JOIN kategori
    ON barang.kategori_id = kategori.id
    ORDER BY barang.id DESC
");

$dataBarang = $stmt->fetchAll(PDO::FETCH_ASSOC);

$kategori = $pdo->query("
    SELECT * FROM kategori
")->fetchAll(PDO::FETCH_ASSOC);

$totalBarang = count($dataBarang);
$totalUnit = 0;
$totalAset = 0;

foreach ($dataBarang as $b) {
    $totalUnit += $b["jumlah"];
    $totalAset += $b["jumlah"] * $b["harga_satuan"];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Dashboard SIM-Barang</title>

    <link rel="stylesheet" href="style.css">

    <script src="main.js" defer></script>
</head>

<body>

<header>
    <h1>SIM-Barang</h1>

    <nav>
        <a href="index.php">Dashboard</a>
        <a href="#inventaris">Inventaris</a>
        <a href="#form-barang">Tambah Barang</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>

<main class="container">

    <section class="welcome">
        <h2>Dashboard Inventaris Barang</h2>
        <p>Selamat datang, <?= htmlspecialchars($_SESSION["user"]) ?>!</p>
    </section>

    <section class="stats">

        <div class="card">
            <h3>Total Jenis Barang</h3>
            <p><?= $totalBarang ?></p>
        </div>

        <div class="card">
            <h3>Total Unit Barang</h3>
            <p><?= $totalUnit ?></p>
        </div>

        <div class="card">
            <h3>Total Nilai Aset</h3>
            <p>
                Rp <?= number_format($totalAset, 0, ',', '.') ?>
            </p>
        </div>

    </section>

    <section id="inventaris" class="panel">

        <h2>Daftar Inventaris Barang</h2>

        <input type="text"
               id="searchBarang"
               placeholder="Cari barang...">

        <div class="table-container">

            <table id="tabelBarang">

                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Nama Barang</th>
                        <th>Kategori</th>
                        <th>Jumlah</th>
                        <th>Kondisi</th>
                        <th>Harga Satuan</th>
                        <th>Nilai Aset</th>
                    </tr>
                </thead>

                <tbody>

                <?php foreach ($dataBarang as $b): ?>

                    <tr>
                        <td>
                            <?= htmlspecialchars($b["kode"]) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($b["nama"]) ?>
                        </td>

                        <td>
                            <?= htmlspecialchars($b["nama_kategori"]) ?>
                        </td>

                        <td><?= $b["jumlah"] ?></td>

                        <td>
                            <?= htmlspecialchars($b["kondisi"]) ?>
                        </td>

                        <td>
                            Rp <?= number_format(
                                $b["harga_satuan"],
                                0,
                                ',',
                                '.'
                            ) ?>
                        </td>

                        <td>
                            Rp <?= number_format(
                                $b["jumlah"] * $b["harga_satuan"],
                                0,
                                ',',
                                '.'
                            ) ?>
                        </td>
                    </tr>

                <?php endforeach; ?>

                </tbody>

            </table>

        </div>

    </section>

    <section id="form-barang" class="panel">

        <h2>Formulir Input Barang</h2>

        <form action="simpan.php"
              method="POST"
              id="formBarang">

            <label>Kode Barang</label>

            <input type="text"
                   name="kode"
                   id="kode"
                   placeholder="BRG-004"
                   pattern="BRG-[0-9]+"
                   required>

            <label>Nama Barang</label>

            <input type="text"
                   name="nama"
                   placeholder="Nama barang"
                   required>

            <label>Kategori</label>

            <select name="kategori_id" required>
                <option value="">Pilih kategori</option>

                <?php foreach ($kategori as $k): ?>

                    <option value="<?= $k["id"] ?>">
                        <?= htmlspecialchars($k["nama_kategori"]) ?>
                    </option>

                <?php endforeach; ?>

            </select>

            <label>Jumlah</label>

            <input type="number"
                   name="jumlah"
                   id="jumlah"
                   min="1"
                   step="1"
                   placeholder="Jumlah barang"
                   required>

            <label>Kondisi</label>

            <select name="kondisi" required>
                <option value="">Pilih kondisi</option>
                <option value="Baik">Baik</option>
                <option value="Rusak Ringan">Rusak Ringan</option>
                <option value="Rusak Berat">Rusak Berat</option>
            </select>

            <label>Harga Satuan</label>

            <input type="number"
                   name="harga_satuan"
                   min="0"
                   step="1"
                   placeholder="Harga satuan"
                   required>

            <button type="submit">Simpan Barang</button>

        </form>

        <p id="pesan"></p>

    </section>

</main>

<footer>
    <p>SIM-Barang - Praktikum Pemrograman Web</p>
</footer>

</body>
</html>