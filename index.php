<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Mahasiswa</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>CRUD Mahasiswa</h2>
        <div class="row mt-3">
            <div class="col-md-4">
                <form id="nilaiForm">
                    <div class="form-group">
                        <label for="nim">NIM:</label>
                        <input type="text" class="form-control" id="nim" name="nim">
                    </div>
                    <div class="form-group">
                        <label for="kode_mk">Kode MK:</label>
                        <input type="text" class="form-control" id="kode_mk" name="kode_mk">
                    </div>
                    <div class="form-group">
                        <label for="nilai">Nilai:</label>
                        <input type="text" class="form-control" id="nilai" name="nilai">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-md-8">
                <h3>Data Nilai Mahasiswa</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>NIM</th>
                            <th>Kode MK</th>
                            <th>Nilai</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="nilaiList">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        // Function untuk get all_nilai
        function getAllNilai() {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var response = JSON.parse(this.responseText);
                    var rows = '';
                    response.data.forEach(function(nilai) {
                        rows += '<tr>';
                        rows += '<td>' + nilai.nim + '</td>';
                        rows += '<td>' + nilai.kode_mk + '</td>';
                        rows += '<td>' + nilai.nilai + '</td>';
                        rows += '<td><button class="btn btn-danger" onclick="deleteNilai(\'' + nilai.nim + '\', \'' + nilai.kode_mk + '\')">Delete</button> <button class="btn btn-primary" onclick="updateNilai(\'' + nilai.nim + '\', \'' + nilai.kode_mk + '\')">Update</button></td>';
                        rows += '</tr>';
                    });
                    document.getElementById("nilaiList").innerHTML = rows;
                }
            };
            xhr.open("GET", "http://localhost/.kuliah/.UTS/Semester%204/PSAIT/mahasiswa_api.php", true);
            xhr.send();
        }

        // Function untuk delete_nilai
        function deleteNilai(nim, kode_mk) {
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var response = JSON.parse(this.responseText);
                    alert(response.message);
                    getAllNilai();
                }
            };
            xhr.open("DELETE", "http://localhost/.kuliah/.UTS/Semester%204/PSAIT/mahasiswa_api.php?nim=" + nim + "&kode_mk=" + kode_mk, true);
            xhr.send();
        }

        // Function to update nilai
        function updateNilai(nim, kode_mk) {
            var newNilai = prompt("Please Update For Nilai:");
            if (newNilai != null) {
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        var response = JSON.parse(this.responseText);
                        alert(response.message);
                        getAllNilai();
                    }
                };
                xhr.open("POST", "http://localhost/.kuliah/.UTS/Semester%204/PSAIT/mahasiswa_api.php?nim=" + nim + "&kode_mk=" + kode_mk, true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.send("nilai=" + newNilai);
            }
        }

        // Form submit event untuk insert data
        document.getElementById("nilaiForm").addEventListener("submit", function(event) {
            event.preventDefault();
            var formData = new FormData(this);
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    var response = JSON.parse(this.responseText);
                    alert(response.message);
                    getAllNilai();
                    document.getElementById("nilaiForm").reset();
                }
            };
            xhr.open("POST", "http://localhost/.kuliah/.UTS/Semester%204/PSAIT/mahasiswa_api.php", true);
            xhr.send(formData);
        });

        // Load data on page load
        getAllNilai();
    </script>
</body>
</html>
