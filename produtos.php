<?php 

$idproduto = isset($_GET["idproduto"]) ? $_GET["idproduto"]: null;
$op = isset($_GET["op"]) ? $_GET["op"]: null;
 

    try {
        $servidor = "localhost";
        $usuario = "root";
        $senha = "";
        $bd = "bdprojeto";
        $con = new PDO("mysql:host=$servidor;dbname=$bd",$usuario,$senha); 

        if($op=="del"){
            $sql = "delete  FROM  produtos where idproduto= :idproduto";
            $stmt = $con->prepare($sql);
            $stmt->bindValue(":idproduto",$idproduto);
            $stmt->execute();
            header("Location:listarprodutos.php");
        }


        if($idproduto){
            //estou buscando os dados do produto no BD
            $sql = "SELECT * FROM  produtos where idproduto= :idproduto";
            $stmt = $con->prepare($sql);
            $stmt->bindValue(":idproduto",$idproduto);
            $stmt->execute();
            $produto = $stmt->fetch(PDO::FETCH_OBJ);
            //var_dump($produto);
        }
        if($_POST){
            if($_POST["idproduto"]){
                $sql = "UPDATE produtos SET produto=:produto, preco=:preco, estoque=:estoque WHERE idproduto =:idproduto";
                $stmt = $con->prepare($sql);
                $stmt->bindValue(":produto", $_POST["produto"]);
                $stmt->bindValue(":preco", $_POST["preco"]);
                $stmt->bindValue(":estoque", $_POST["estoque"]);
                $stmt->bindValue(":idproduto", $_POST["idproduto"]);
                $stmt->execute(); 
            } else {
                $sql = "INSERT INTO produtos(produto,preco,estoque) VALUES (:produto,:preco,:estoque)";
                $stmt = $con->prepare($sql);
                $stmt->bindValue(":produto",$_POST["produto"]);
                $stmt->bindValue(":preco",$_POST["preco"]);
                $stmt->bindValue(":estoque", $_POST["estoque"]);
                $stmt->execute(); 
            }
            header("Location:listarprodutos.php");
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
<h1>Cadastro de Clientes</h1>
<form method="POST">
produto  <input type="text" name="produto"      value="<?php echo isset($produto) ? $produto->produto : null ?>"><br>
pre??o <input type="text"    name="preco"        value="<?php echo isset($produto) ? $produto->preco : null ?>"><br>
estoque <input type="text"    name="estoque"        value="<?php echo isset($produto) ? $produto->estoque : null ?>"><br>
<input type="hidden"        name="idproduto"    value="<?php echo isset($produto) ? $produto->idproduto : null ?>">
<input type="submit">
</form>
<a href="listarprodutos.php">volta</a>
</body>
</html>