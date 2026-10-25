<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit;
}

require_once "koneksi.php";
require_once "Barang.php";

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    header("Location: index.php");
    exit;
}

$kode = strtoupper(trim($_POST["kode"] ?? ""));
$nama = trim($_POST["nama"] ?? "");
$kategori_id = filter_input(
    INPUT_POST,
    "kategori_id",
    FILTER_VALIDATE_INT
);
$jumlah = filter_input(
    INPUT_POST,
    "jumlah",
    FILTER_VALIDATE_INT
);
$kondisi = $_POST["kondisi"] ?? "";
$harga = filter_input(
    INPUT_POST,
    "harga_satuan",
    FILTER_VALIDATE_FLOAT
);

if (
    !preg_match('/^BRG-[0-9]+$/', $kode) ||
    $nama == "" ||
    !$kategori_id ||
    !$jumlah ||
    $jumlah < 1 ||
    !in_array($kondisi, ["Baik", "Rusak Ringan", "Rusak Berat"], true) ||
    $harga === false ||
    $harga === null ||
    $harga < 0
) {
    die("Data tidak valid. Silakan kembali dan periksa formulir.");
}

$barang = new Barang($kode, $nama, $jumlah);

try {
    $stmt = $pdo->prepare("
        INSERT INTO barang
        (kode, nama, kategori_id, jumlah, kondisi, harga_satuan)
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $barang->kode,
        $barang->nama,
        $kategori_id,
        $barang->jumlah,
        $kondisi,
        $harga
    ]);

    $nilaiAset = $barang->hitungNilaiAset($harga);

    echo "<h2>Barang berhasil disimpan!</h2>";

    echo "<p>Kode: " .
         htmlspecialchars($barang->kode) . "</p>";

    echo "<p>Nama: " .
         htmlspecialchars($barang->nama) . "</p>";

    echo "<p>Jumlah: " .
         $barang->jumlah . "</p>";

    echo "<p>Estimasi nilai aset: Rp " .
         number_format($nilaiAset, 0, ',', '.') . "</p>";

    echo '<a href="index.php">Kembali ke Dashboard</a>';

} catch (PDOException $e) {
    if ($e->getCode() == "23000") {
        die("Kode barang sudah digunakan. Gunakan kode lain.");
    }

    die("Gagal menyimpan data barang.");
}
?>