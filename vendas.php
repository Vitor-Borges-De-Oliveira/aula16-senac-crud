<?php 

$idvenda = isset($_GET["idvenda"]) ? $_GET["idvenda"]: null;
$op = isset($_GET["op"]) ? $_GET["op"]: null;
 

    try {
        $servidor = "localhost";
        $usuario = "root";
        $senha = "";
        $bd = "bdprojeto";
        $con = new PDO("mysql:host=$servidor;dbname=$bd",$usuario,$senha); 

        if($op=="del"){
            $sql = "delete  FROM  vendas where idvenda= :idvenda";
            $stmt = $con->prepare($sql);
            $stmt->bindValue(":idvenda",$idvenda);
            $stmt->execute();
            header("Location:listarvendas.php");
        }


        if($idvenda){
            //estou buscando os dados da venda no BD
            $sql = "SELECT * FROM  vendas where idvenda= :idvenda";
            $stmt = $con->prepare($sql);
            $stmt->bindValue(":idvenda",$idvenda);
            $stmt->execute();
            $venda = $stmt->fetch(PDO::FETCH_OBJ);
            //var_dump($venda);
        }
        if($_POST){
            if($_POST["idvenda"]){
                $sql = "UPDATE vendas SET venda=:venda, vendedor=:vendedor WHERE idvenda =:idvenda";
                $stmt = $con->prepare($sql);
                $stmt->bindValue(":venda", $_POST["venda"]);
                $stmt->bindValue(":vendedor", $_POST["vendedor"]);
                $stmt->bindValue(":idvenda", $_POST["idvenda"]);
                $stmt->execute(); 
            } else {
                $sql = "INSERT INTO vendas(venda,vendedor) VALUES (:venda,:vendedor)";
                $stmt = $con->prepare($sql);
                $stmt->bindValue(":venda",$_POST["venda"]);
                $stmt->bindValue(":vendedor",$_POST["vendedor"]);
                $stmt->execute(); 
            }
            header("Location:listarvendas.php");
        } 
    } catch(PDOException $e){
         echo "erro".$e->getMessage;
        }


?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h1>Cadastro de Vendas</h1>
<form method="POST">
venda  <input type="text" name="venda"     value="<?php echo isset($venda) ? $venda->venda : null ?>"><br>
vendedor <input type="text" name="vendedor"       value="<?php echo isset($venda) ? $venda->vendedor : null ?>"><br>
<input type="hidden"     name="idproduto"   value="<?php echo isset($venda) ? $venda->idvenda : null ?>">
<input type="submit">
</form>
<a href="listarvendas.php">volta</a>
</body>
</html>