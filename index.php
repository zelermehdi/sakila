<?php
require_once('pdo.php');
require_once('cdn.php');

$ContinentRequest = "SELECT * FROM t_continents";

$ContinentPrep = $pdo->query($ContinentRequest);
$continents = $ContinentPrep->fetchAll();


$regionRequest = "SELECT * FROM t_regions";
$regionPrep = $pdo->query($regionRequest);
$regions = $regionPrep->fetchAll();

if (isset($_GET["continent"], $_GET["region"])) {
    if ($_GET["region"] == "") {
        $SqlREquest = "SELECT * 
            FROM t_pays p
            WHERE p.continent_id = " . (int)$_GET["continent"];
    } else {
        $SqlREquest = "SELECT * 
        FROM t_pays p
        WHERE p.continent_id = " . (int)$_GET["continent"] . " AND p.region_id = " . (int)$_GET["region"];
    }
    $statsPrep = $pdo->query($SqlREquest);
    $stats = $statsPrep->fetchAll();

    $continentID = $_GET["continent"];
}
if (isset($_GET["region"], $_GET["continent"]) && $_GET["continent"] != "") {
    $regionRequest = "SELECT * FROM t_regions r WHERE r.continent_id =" . $_GET["continent"];
    $regionPrep = $pdo->query($regionRequest);
    $regions = $regionPrep->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>pays du globe</title>
</head>

<body>
<h1> pays du monde</h1>
    <form action="http://sakila/index.php" method="GET">
        <select name="continent" id="continent" value="<?= $continentID ?>" onchange="this.form.submit()">
            <option value="">Choisir un Continent></option>
            <?php foreach ($continents as $continent) : ?>
                <?php if (isset($_GET["continent"]) && $_GET["continent"] == $continent["id_continent"]) : ?>
                    <option value=<?= $continent["id_continent"] ?> selected><?= $continent["libelle_continent"] ?></option>
                <?php else : ?>
                    <option value=<?= $continent["id_continent"] ?>><?= $continent["libelle_continent"] ?></option>
                <?php endif ?>
            <?php endforeach ?>
        </select>
        <select name="region" id="region" onchange="this.form.submit()">
            <option value="">Choisir une region></option>
            <?php foreach ($regions as $region) : ?>
                <?php if (isset($_GET["region"]) && $_GET["region"] == $region["id_region"]) : ?>
                    <option value=<?= $region["id_region"] ?> selected><?= $region["libelle_region"] ?></option>
                <?php else : ?>
                    <option value=<?= $region["id_region"] ?>><?= $region["libelle_region"] ?></option>
                <?php endif ?>
            <?php endforeach ?>
        </select>
    </form>

    <table id="example" class="display" style="width:100%">

        <thead>
            <tr>
                <th>Pays</th>
                <th>Population totale (en milliers)</th>
                <th>Taux de natalité</th>
                <th>Taux de mortalité</th>
                <th>Espérance de vie</th>
                <th>Taux de mortalité infantile</th>
                <th>Nombre d'enfant(s) par femme</th>
                <th>Taux de croissance</th>
                <th>Population de 65 ans et plus (en milliers)</th>
            </tr>
        </thead>
        <tbody>
            <?php if (isset($stats)) : ?>
                <?php foreach ($stats as $pays) : ?>
                    <tr>
                        <td><?= $pays['libelle_pays'] ?></td>
                        <td><?= $pays['population_pays'] ?></td>
                        <td><?= $pays['taux_natalite_pays'] ?></td>
                        <td><?= $pays['taux_mortalite_pays'] ?></td>
                        <td><?= $pays['esperance_vie_pays'] ?></td>
                        <td><?= $pays['taux_mortalite_infantile_pays'] ?></td>
                        <td><?= $pays['nombre_enfants_par_femme_pays'] ?></td>
                        <td><?= $pays['taux_croissance_pays'] ?></td>
                        <td><?= $pays['population_plus_65_pays'] ?></td>
                    </tr>
                <?php endforeach ?>
            <?php else : ?>
                <tr>
                    <td>No data available in table</td>
                </tr>
            <?php endif ?>
        </tbody>
    </table>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="javascript.js"></script>
</body>

</html>