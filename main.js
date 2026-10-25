document.addEventListener("DOMContentLoaded", function () {

    // Pencarian barang secara real-time
    const search = document.getElementById("searchBarang");
    const tabel = document.getElementById("tabelBarang");

    if (search && tabel) {
        search.addEventListener("input", function () {

            const keyword = search.value.toLowerCase();
            const rows = tabel.querySelectorAll("tbody tr");

            rows.forEach(function (row) {

                const isi = row.textContent.toLowerCase();

                row.style.display =
                    isi.includes(keyword) ? "" : "none";

            });

        });
    }

    // Validasi formulir
    const form = document.getElementById("formBarang");

    if (form) {
        form.addEventListener("submit", function (event) {

            const kode = document.getElementById("kode").value.trim();
            const jumlah = Number(
                document.getElementById("jumlah").value
            );

            if (!/^BRG-[0-9]+$/i.test(kode)) {

                event.preventDefault();

                alert(
                    "Kode barang harus diawali BRG- dan diikuti angka!"
                );

                return;
            }

            if (!Number.isInteger(jumlah) || jumlah <= 0) {

                event.preventDefault();

                alert(
                    "Jumlah barang harus berupa bilangan bulat positif!"
                );

                return;
            }

            alert("Validasi berhasil! Data akan diproses.");

        });
    }

});