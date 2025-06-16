<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penilaian Mahasiswa</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO"
        crossorigin="anonymous"></script>

    <style>
        body {
            background-color: #f8f9fa;
        }

        .card-header {
            background-color: #007bff;
            color: white;
        }

        .form-label {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="container mt-4 mb-5 px-5">
        <div class="card shadow-sm">
            <div class="card-header text-center">
                <h1 class="h4 mb-0">Form Penilaian Mahasiswa</h1>
            </div>
            <div class="card-body">
                <form id="penilaianForm" novalidate>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Masukkan Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Naayoo" required>
                    </div>
                    <div class="mb-3">
                        <label for="nim" class="form-label">Masukkan NIM</label>
                        <input type="text" class="form-control" id="nim" name="nim" placeholder="202332xxx" required>
                    </div>
                    <div class="mb-3">
                        <label for="kehadiran" class="form-label">Nilai Kehadiran (10%)</label>
                        <input type="number" class="form-control" id="kehadiran" name="kehadiran" placeholder="0 - 100" required>
                    </div>
                    <div class="mb-3">
                        <label for="tugas" class="form-label">Nilai Tugas (20%)</label>
                        <input type="number" class="form-control" id="tugas" name="tugas" placeholder="0 - 100" required>
                    </div>
                    <div class="mb-3">
                        <label for="uts" class="form-label">Nilai UTS (30%)</label>
                        <input type="number" class="form-control" id="uts" name="uts" placeholder="0 - 100" required>
                    </div>
                    <div class="mb-3">
                        <label for="uas" class="form-label">Nilai UAS (40%)</label>
                        <input type="number" class="form-control" id="uas" name="uas" placeholder="0 - 100" required>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" name="proses" class="btn btn-primary">Proses</button>
                    </div>
                </form>

                <div id="alertBox" class="alert alert-danger d-none mt-3" role="alert"></div>

                <!-- Tampilan Hasil Evaluasi -->
                <div id="hasilEvaluasi" class="mt-4 d-none">
                    <div class="card border-0">
                        <div id="hasilHeader" class="card-header text-white text-center fs-5 fw-semibold">
                            Hasil Evaluasi
                        </div>
                        <div class='card-body'>
                            <div class='row px-5 fs-4 mb-3'>
                                <div class='col text-start'><strong>Nama:</strong> <span id="hasilNama"></span></div>
                                <div class='col text-end'><strong>NIM:</strong> <span id="hasilNim"></span></div>
                            </div>
                            <p>Kehadiran: <span id="hasilKehadiran"></span>%</p>
                            <p>Tugas: <span id="hasilTugas"></span></p>
                            <p>UTS: <span id="hasilUts"></span></p>
                            <p>UAS: <span id="hasilUas"></span></p>
                            <p>Nilai Akhir: <span id="hasilAkhir"></span></p>
                            <p>Grade: <span id="hasilGrade"></span></p>
                            <p>Status: <strong id="hasilStatus" class="text-uppercase"></strong></p>
                        </div>
                        <div id="hasilFooter" class="card-footer text-center p-2">
                            <button class="btn w-100 text-white" id="btnSelesai" onclick="window.location.reload()">Selesai</button>
                        </div>
                    </div>
                </div>

                <script>
                    document.getElementById("penilaianForm").addEventListener("submit", function (e) {
                        e.preventDefault(); // Mencegah reload halaman
                        const alertBox = document.getElementById("alertBox");
                        alertBox.classList.add("d-none"); // Sembunyikan alert

                        // Daftar input yang harus diisi
                        const fields = [
                            { id: "nama", label: "Nama" },
                            { id: "nim", label: "NIM" },
                            { id: "kehadiran", label: "Kehadiran" },
                            { id: "tugas", label: "Tugas" },
                            { id: "uts", label: "UTS" },
                            { id: "uas", label: "UAS" }
                        ];

                        let emptyFields = [];

                        // Cek apakah ada yang kosong
                        fields.forEach(field => {
                            const input = document.getElementById(field.id);
                            if (!input.value.trim()) {
                                emptyFields.push(field.label);
                            }
                        });

                        // Jika ada input kosong, tampilkan alert
                        if (emptyFields.length > 0) {
                            alertBox.innerHTML = "Semua kolom harus diisi.";
                            alertBox.classList.remove("d-none");
                        } else {
                            // Jika lengkap, tampilkan hasil evaluasi
                            tampilkanHasilAkhir();
                        }
                    });

                    // Fungsi untuk menampilkan hasil akhir evaluasi
                    function tampilkanHasilAkhir() {
                        const nama = document.getElementById("nama").value;
                        const nim = document.getElementById("nim").value;
                        const kehadiran = parseFloat(document.getElementById("kehadiran").value) || 0;
                        const tugas = parseFloat(document.getElementById("tugas").value) || 0;
                        const uts = parseFloat(document.getElementById("uts").value) || 0;
                        const uas = parseFloat(document.getElementById("uas").value) || 0;

                        // Hitung nilai akhir dengan bobot
                        const nilaiAkhir = (kehadiran * 0.1) + (tugas * 0.2) + (uts * 0.3) + (uas * 0.4);
                        let grade, status;

                        // Menentukan grade dan status
                        if (nilaiAkhir >= 85) {
                            grade = "A";
                            status = "LULUS";
                        } else if (nilaiAkhir >= 70) {
                            grade = "B";
                            status = "LULUS";
                        } else if (nilaiAkhir >= 60) {
                            grade = "C";
                            status = "TIDAK LULUS";
                        } else {
                            grade = "D";
                            status = "TIDAK LULUS";
                        }

                        // Tampilkan hasil ke halaman
                        document.getElementById("hasilNama").textContent = nama;
                        document.getElementById("hasilNim").textContent = nim;
                        document.getElementById("hasilKehadiran").textContent = kehadiran;
                        document.getElementById("hasilTugas").textContent = tugas;
                        document.getElementById("hasilUts").textContent = uts;
                        document.getElementById("hasilUas").textContent = uas;
                        document.getElementById("hasilAkhir").textContent = nilaiAkhir.toFixed(2);
                        document.getElementById("hasilGrade").textContent = grade;

                        // Atur warna status dan background
                        const statusEl = document.getElementById("hasilStatus");
                        statusEl.textContent = status;
                        statusEl.classList.remove("text-success", "text-danger");
                        statusEl.classList.add(status === "LULUS" ? "text-success" : "text-danger");

                        const header = document.getElementById("hasilHeader");
                        header.classList.remove("bg-success", "bg-danger");
                        header.classList.add(status === "LULUS" ? "bg-success" : "bg-danger");

                        const footer = document.getElementById("hasilFooter");
                        const btn = document.getElementById("btnSelesai");
                        if (status === "LULUS") {
                            footer.classList.add("bg-success");
                            btn.classList.add("bg-success");
                        } else {
                            footer.classList.add("bg-danger");
                            btn.classList.add("bg-danger");
                        }

                        // Tampilkan kotak hasil
                        document.getElementById("hasilEvaluasi").classList.remove("d-none");
                    }
                </script>

            </div>
        </div>
    </div>
</body>
</html>
