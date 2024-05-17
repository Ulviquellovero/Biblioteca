<?php
    require_once("var_conn.php");
    $sql = "SELECT tp.codiceScaffale
            FROM tposizione tp
            WHERE tp.codiceScaffale NOT IN (SELECT tl.codiceScaffale FROM tlibro tl) AND tp.identificativoStanza = 'Stanza Libri'
            ORDER BY tp.codiceScaffale ASC";
    $res = mysqli_query($con, $sql);
    $i = 0;
    $resArr = null;
    while($array = mysqli_fetch_array($res)) 
    {
        $row = array(
            "codiceScaffale" => $array['codiceScaffale']
        );
        $resArr[$i] = $row;
        $i++;
    }
    $risFin = array(
                "Result" => $resArr,
                );
    echo json_encode($risFin);
    require_once("var_connclose.php");
?>