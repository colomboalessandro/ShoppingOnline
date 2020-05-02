<?php
	include_once(__DIR__ . '/connector.php');
		
	
	try {
		
	if (!isset($_GET["id"]))
				return false;
			$idNegozio = $_GET["id"];
			$sql = "SELECT * 
			FROM Prodotto inner join negozio on prodotto.CodNegozio = negozio.ID
			WHERE ID='$idNegozio'";
			
		if (isset($_GET["Categoria"])){
			
			$Categoria = $_GET["Categoria"];
			$sql = "SELECT Prodotto.nome 
					FROM Prodotto inner join Appartiene on Prodotto.ID = Appartiene.CodProdotto
						 inner join Categoria on Appartiene.CodCategoria = Categoria.ID
						 inner join negozio on prodotto.CodNegozio = negozio.ID
					where negozio.ID='$idNegozio' AND Categoria.nome = '$Categoria'";
		}
			
		if (isset($_GET["CostoMin"])){
			
			$CostoMin = $_GET["CostoMin"];
			$sql .= " AND prezzo > '$CostoMin'";
		}
		if (isset($_GET["CostoMax"])){
			
			$CostoMax = $_GET["CostoMax"];
			$sql .= " AND prezzo < '$CostoMax'";
		}
		
		//var_dump($sql);
        $result = $conn->query($sql);

		$ris = $result->fetch_assoc()["nome"];		
		while ($row = $result->fetch_assoc()) {
			$ris .= ", ".$row["nome"];
		}	
		$conn->close();
		$response[] = array("Prodotto" => $ris);
		
		http_response_code(200);
		
		echo json_encode($response);		
	
	} catch (Exception $ex) {
        http_response_code($ex->getCode());
    }  
	
	
?>
