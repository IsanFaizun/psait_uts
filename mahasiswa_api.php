<?php
    require_once "config.php";
    $request_method = $_SERVER["REQUEST_METHOD"];
    switch ($request_method) {
        case 'GET':
            if (!empty($_GET["nim"])) {
                $nim = $_GET["nim"];
                get_nilai_mahasiswa($nim);
            } else {
                get_all_nilai();
            }
            break;
        case 'POST':
            if(!empty($_GET["nim"]) && !empty($_GET["kode_mk"]))
            {
                $nim=$_GET["nim"];
                $kode_mk=$_GET["kode_mk"];
                update_nilai($nim, $kode_mk);
            } else {
                insert_nilai();
            }
            break;
        case 'DELETE':
            $nim = $_GET["nim"];
            $kode_mk = $_GET["kode_mk"];
            delete_nilai($nim, $kode_mk);
            break;
        default:
            // Invalid Request Method
            header("HTTP/1.0 405 Method Not Allowed");
            break;
    }

    function get_all_nilai()
    {
        global $mysqli;
        $query = "SELECT * FROM data_kuliahan";
        $result = $mysqli->query($query);
        $data = array();
        while ($row = mysqli_fetch_object($result)) {
            $data[] = $row;
        }
        $response = array(
            'status' => 1,
            'message' => 'Get All Nilai Successfully.',
            'data' => $data
        );
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    function get_nilai_mahasiswa($nim)
    {
        global $mysqli;
        $query = "SELECT * FROM data_kuliahan WHERE nim = '$nim'";
        $result = $mysqli->query($query);
        $data = array();
        while ($row = mysqli_fetch_object($result)) {
            $data[] = $row;
        }
        $response = array(
            'status' => 1,
            'message' => 'Get Nilai Mahasiswa Successfully.',
            'data' => $data
        );
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    function insert_nilai()
    {
        global $mysqli;

        if(!empty($_POST["nim"]) || !empty($_POST["kode_mk"])){
            $data=$_POST;
         }else{
            $data = json_decode(file_get_contents('php://input'), true);
         }

        if (!empty($data)){
            $nim = $data['nim'];
            $kode_mk = $data['kode_mk'];
            $nilai = $data['nilai'];

            $result = mysqli_query($mysqli, "INSERT INTO perkuliahan SET 
            nim = '$nim',
            kode_mk = '$kode_mk',
            nilai = '$nilai'");

            if ($result) {
                $response = array(
                    'status' => 1,
                    'message' => 'Nilai Added Successfully.'
                );
            } else {
                $response = array(
                    'status' => 0,
                    'message' => 'Nilai Addition Failed.'
                );
            }
            header('Content-Type: application/json');
            echo json_encode($response);   
        }
        else {
            $response = array(
                'status' => 0,
                'message' => 'Invalid JSON Data.'
            );
        }
        // Mengembalikan respons dalam format JSON
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    function update_nilai($nim, $kode_mk)
    {
        global $mysqli;
        $nilai = ""; // Inisialisasi nilai

        if(!empty($_POST["nilai"])){
            $nilai = $_POST["nilai"]; // Jika data dikirim melalui form-data, ambil nilai dari $_POST
        } else {
            $data = json_decode(file_get_contents('php://input'), true);
            if (!empty($data['nilai'])) {
                $nilai = $data['nilai']; // Jika data dikirim sebagai JSON, ambil nilai dari JSON
            }
        }

        $result = mysqli_query($mysqli, "UPDATE perkuliahan SET 
        nilai = '$nilai'
        WHERE nim = '$nim' AND kode_mk = '$kode_mk'
        ");

        if ($result) {
            $response = array(
                'status' => 1,
                'message' => 'Nilai Added Successfully.'
            );
        } else {
            $response = array(
                'status' => 0,
                'message' => 'Nilai Addition Failed.'
            );
        }
        header('Content-Type: application/json');
        echo json_encode($response);   
    }

    function delete_nilai($nim, $kode_mk)
    {
        global $mysqli;
        $query="DELETE FROM perkuliahan WHERE nim = '$nim' and kode_mk = '$kode_mk'";
        if (mysqli_query($mysqli, $query)) {
            $response = array(
                'status' => 1,
                'message' => 'Nilai Deleted Successfully.'
            );
        } else {
            $response = array(
                'status' => 0,
                'message' => 'Nilai Deletion Failed.'
            );
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
?>
