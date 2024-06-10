<?php

    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.rajaongkir.com/starter/province",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => array(
        "key: 6fdc21a491490229a19de4ff9136128a"
    ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
    echo "cURL Error #:" . $err;
    } else {
    //cek perubahan json to array
    // echo $response;
    $data = json_decode($response);
    // echo "<pre>"; print_r($data); echo "</pre>";
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
    <title>Web Ongkos Kirim</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
		.jumbotron {
			background-image: url('https://picsum.photos/id/1002/1200/800');
			background-size: cover;
			background-position: center center;
			color: #fff;
			text-shadow: 2px 2px 4px #000000;
		}
		input[type="text"] {
			background-color: #F8F8F8;
			border: none;
			padding: 12px 20px;
			border-radius: 25px;
			margin-bottom: 20px;
			box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
		}
		select {
			background-color: #F8F8F8;
			border: none;
			padding: 12px 20px;
			border-radius: 25px;
			margin-bottom: 20px;
			box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
		}
		select:focus, input[type="text"]:focus {
			outline: none;
			box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3), 0 0 8px rgba(0, 0, 0, 0.3);
		}
		input[type="submit"] {
			background-color: #006699;
			color: #fff;
			border: none;
			padding: 12px 20px;
			border-radius: 25px;
			margin-bottom: 20px;
			box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
			cursor: pointer;
			transition: background-color 0.2s ease-in-out;
		}
		input[type="submit"]:hover {
			background-color: #005588;
		}
	</style>
    </head>
    <body>

    <div class="jumbotron text-center">
    <h1>Ongkos Kirim App</h1>
    <p>Menghitung biaya ongkos kirim!</p> 
    </div>
    
    <div class="container">
    <div class="row">

        <div class="col-sm-4">
            <h3>Kota Asal</h3>
            <p>Pilih Provinsi
            <select name="Provinsi_asal" onchange="cariKotaAsal(this.value)">
                <option>--Pilih Provinsi--</option>

                <?php
                    foreach($data->rajaongkir->results as $provinsi){
                        echo '<option value="'.$provinsi->province_id.'">'.$provinsi->province.'</option>';
                    }
                ?>
            </select>
            </p>

            <p>Pilih Kota </br>
            <select id="kota_asal"name="kota_asal">
                <option>--Pilih Kota--</option>
            </select>
            </p>
        </div>
        

        <div class="col-sm-4">
            <h3>Kota Tujuan</h3>
            <p>Pilih Provinsi
            <select name="Provinsi_tujuan" onchange="cariKotaTujuan(this.value)">
                <option>--Pilih Provinsi--</option>

                <?php
                    foreach($data->rajaongkir->results as $provinsi){
                        echo '<option value="'.$provinsi->province_id.'">'.$provinsi->province.'</option>';
                    }
                ?>
            </select>
            </p>
            <p>Pilih Kota </br>
            <select id="kota_tujuan"name="kota_tujuan">
                <option>--Pilih Kota--</option>
            </select>
            </p>
        </div>

        <div class="col-sm-4">
            <h3>Berat dan kurir</h3>        
            <p>
                Berat Paket:<br/>
                <input id="berat_paket" type="text" name="berat_paket">
            </p>
            <p>
                Pilih Kurir:<br/>
                <select id="kurir" name="kurir">
                    <option value="jne">JNE</option>
                    <option value="tiki">TIKI</option>
                    <option value="pos">Pos Indonesia</option>
                </select>
            </p>
        </div>

        <div class="col-sm-12" style="text-align: center;">
        <p>
            <img src="https://tiki.id/images/1-Beranda/Ikon-Cek-Ongkir.png" alt="icon cek ongkir" style="float: center; margin-right: 20px; width: 50px; height: 50px;">
            <input type="submit" name="cari" value="Cek Ongkir" onclick="cekOngkir();" class="btn btn-primary btn-sm">
        </p>
        <div id="hasil_cek_ongkir" style="text-align: center;"></div>
        </div>
    </div>
    </div>
    <script>
        function cariKotaAsal(id_provinsi){
            var xmlhttp = new XMLHttpRequest();

            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("kota_asal").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "http://localhost/api/apirajaongkir/reqcarikota.php?id_provinsi="+id_provinsi, true);
            xmlhttp.send();
        }

        function cariKotaTujuan(id_provinsi){
            var xmlhttp = new XMLHttpRequest();

            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("kota_tujuan").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "http://localhost/api/apirajaongkir/reqcarikota.php?id_provinsi="+id_provinsi, true);
            xmlhttp.send();
        }

        function cekOngkir(){
            var id_kota_asal =document.getElementById("kota_asal").value;
            var id_kota_tujuan =document.getElementById("kota_tujuan").value;
            var berat_paket =document.getElementById("berat_paket").value;
            var kurir =document.getElementById("kurir").value;
        
            var xmlhttp = new XMLHttpRequest();

            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    document.getElementById("hasil_cek_ongkir").innerHTML = this.responseText;
                }
            };
            xmlhttp.open("GET", "http://localhost/api/apirajaongkir/reqongkoskirim.php?id_kota_asal="+id_kota_asal+"&id_kota_tujuan="+id_kota_tujuan+"&berat_paket="+berat_paket+"&kurir="+kurir, true);
            xmlhttp.send();
        }
    </script>
    </body>
</html>
