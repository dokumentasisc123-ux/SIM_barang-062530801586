<?php

class Barang {

    public $kode;
    public $nama;
    public $jumlah;

    public function __construct(
        $kode,
        $nama,
        $jumlah
    ) {
        $this->kode = $kode;
        $this->nama = $nama;
        $this->jumlah = $jumlah;
    }

    public function hitungNilaiAset($harga) {
        return $this->jumlah * $harga;
    }

    public function tampilkanInformasi() {
        return $this->kode . " - " .
               $this->nama . " (" .
               $this->jumlah . " unit)";
    }
}
?>