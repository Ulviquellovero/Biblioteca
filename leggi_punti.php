<?php
    require_once('declares.php');
    
    $sql = "SELECT * FROM tInserzioni";
    $rec = mysqli_query($db_remoto,$sql);
    $num = mysqli_num_rows($rec);
    if($num==0) {
        $updates = array(
                         "id"       => -1,
                         "lat"      => 0,
                         "lon"      => 0,
                         );
        $con[0] = $updates;
        $risultato = array(
                           "UpdateList" => $con
                           );
        echo json_encode($risultato);
    }
    else {
        $i = 0;
        while($array=mysqli_fetch_array($rec)) {
                $updates = array(
                            "id"       => $array['id'],
                            "lat"      => $array['lat'],
                            "lon"      => $array['lon'],
            );
            $con[$i] = array_map('utf8_encode',$updates);
            $i++;
        }
    }
        $risultato = array(
                           "ElencoPunti" => $con
                           );
        echo json_encode($risultato);
?>


