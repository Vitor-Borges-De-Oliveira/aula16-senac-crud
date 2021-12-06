<?php 

$idvendedor = isset($_GET["idvendedor"]) ? $_GET["idvendedor"]: null;
$op = isset($_GET["op"]) ? $_GET["op"]: null;
 

    try {
        $servidor = "localhost";
        $usuario = "root";
        $senha = "";
        $bd = "bdprojeto";
        $con = new PDO("mysql:host=$servidor;dbname=$bd",$usuario,$senha); 

        if($op=="del"){
            $sql = "delete  FROM  vendedores where idvendedor= :idvendedor";
            $stmt = $con->prepare($sql);
            $stmt->bindValue(":idvendedor",$idvendedor);
            $stmt->execute();
            header("Location:listarvendedores.php");
        }


        if($idvendedor){
            //estou buscando os dados do vendedor no BD
            $sql = "SELECT * FROM  vendedores where idvendedor= :idvendedor";
            $stmt = $con->prepare($sql);
            $stmt->bindValue(":idvendedor",$idvendedor);
            $stmt->execute();
            $vendedor = $stmt->fetch(PDO::FETCH_OBJ);
            //var_dump($vendedor);
        }
        if($_POST){
            if($_POST["idvendedor"]){
                $sql = "UPDATE vendedores SET vendedor=:vendedor, email=:email, ch=:ch WHERE idvendedor =:idvendedor";
                $stmt = $con->prepare($sql);
                $stmt->bindValue(":vendedor", $_POST["vendedor"]);
                $stmt->bindValue(":email", $_POST["email"]);
                $stmt->bindValue(":ch", $_POST["ch"]);
                $stmt->bindValue(":idvendedor", $_POST["idvendedor"]);
                $stmt->execute(); 
            } else {
                $sql = "INSERT INTO vendedores(vendedor,email,ch) VALUES (:vendedor,:email,:ch)";
                $stmt = $con->prepare($sql);
                $stmt->bindValue(":vendedor",$_POST["vendedor"]);
                $stmt->bindValue(":email",$_POST["email"]);
                $stmt->bindValue(":ch",$_POST["ch"]);
                $stmt->execute(); 
            }
            header("Location:listarvendedores.php");
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
<h1>Cadastro de Vendedores</h1>
<form method="POST">
vendedor  <input type="text" name="vendedor"     value="<?php echo isset($vendedor) ? $vendedor->vendedor : null ?>"><br>
email <input type="email" name="email"       value="<?php echo isset($vendedor) ? $email->email : null ?>"><br>
carga horaria <input type="text" name="ch"       value="<?php echo isset($vendedor) ? $ch->ch : null ?>"><br>
<input type="hidden"     name="idvendedor"   value="<?php echo isset($vendedor) ? $vendedor->idvendedor : null ?>">
<input type="submit">
</form>
<a href="listarvendedores.php">volta</a>
</body>
</html>