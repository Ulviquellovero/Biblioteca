<?php
	require_once("var_conn.php");
	if(isset($_GET["tipo"]))
	{
		$tipo = $_GET["tipo"];
		if($tipo == "libro")
			$tabella = "tlibro";
		if($tipo == "enciclopedia")
			$tabella = "tenciclopedia";
		if($tipo == "carta")
			$tabella = "tcarta";
		$sql = "SELECT DISTINCT annoPubblicazione FROM $tabella ORDER BY annoPubblicazione ASC";
		$res = mysqli_query($con, $sql);
		$i = 0;
		$resArr = null;
		while($array = mysqli_fetch_array($res)) 
		{
			$row = array(
						"annoPub" => $array['annoPubblicazione']
			);
			$resArr[$i] = $row;
			$i++;
		}
		$risFin = array(
					"Result" => $resArr,
					);
		echo json_encode($risFin);
	}
	require_once("var_connclose.php");
?>