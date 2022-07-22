<?php 
try
{
$pdo = new PDO(
    //  on donne le nom de l'hôte, de la base
    'mysql:host=localhost;dbname=pays;charset=utf8',
    'root',
    ''
);
}
catch(Exception $e)
{
        die('Erreur : '.$e->getMessage());
}


?>
