<?php
    $id_kota_asal = $_GET['id_kota_asal'];
    $id_kota_tujuan = $_GET['id_kota_tujuan'];
    $berat_paket = $_GET['berat_paket'];
    $kurir = $_GET['kurir'];

    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "origin=".$id_kota_asal."&destination=". $id_kota_tujuan."&weight=".$berat_paket."&courier=".$kurir."",
    CURLOPT_HTTPHEADER => array(
        "content-type: application/x-www-form-urlencoded",
        "key: 6fdc21a491490229a19de4ff9136128a"
    ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo "cURL Error #:" . $err;
    } else {
    // echo $response;
    //cek perubahan json to array
    // echo $response;
        $data = json_decode($response);
    // echo "<pre>"; print_r($data); echo "</pre>";

        foreach ($data->rajaongkir->results[0]->costs as $ongkoskirim) {
            echo 'Paket: '.$ongkoskirim->service;
            echo '<br/>';
            echo 'Ongkos: '.$ongkoskirim->cost[0]->value;
            echo '<br/>';
            echo 'Estimasi hari: '.$ongkoskirim->cost[0]->etd;
            echo '<hr>';
        }
    }
?>