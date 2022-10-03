<?php
date_default_timezone_set('America/Sao_Paulo');
session_start();

$signo = $_SESSION['signo'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculdade - Cassiel Rattes Cortez</title>
</head>

<style>
    h1,
    p,
    label,
    input {
        font-size: 36px;
    }
</style>

<form name="form" action="buscaSigno.php" method="POST">
    <label>Data de nascimento:</label>
    <input type="date" id="bornDate" name="bornDate" />
    <input type="submit" name="submit" id="submit" value="submit" />
</form>

<?php if (!is_null($_SESSION['signo']) && !is_string($_SESSION['signo'])) { ?>

    <body>
        <div>
            <h1><?= $signo['signoNome'] ?></h1>
            <p><?= $signo['descricao'] ?></p>
        </div>
    </body>

<?php } ?>

</html>