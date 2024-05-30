<?php
session_start();
include 'connection.php';

function get_nom_utilisateur($conn) {
    $query = "SELECT nom_utilisateur FROM patient";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['nom_utilisateur'];
    } else {
        return null;
    }
}

$nom_utilisateur = get_nom_utilisateur($conn);
$carte_affichee = !is_null($nom_utilisateur);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="Grdv.css">
    <title>Gestion des rendez-vous</title>
</head>
<body>
    <img id="logo" src="images/logo.PNG">
    <div class="menu">
        <a id="i1" href="Grdv.php">Gestion des rendez-vous</a>
        <a id="i2" href="profil.php">Votre profil</a>
    </div>
    
    <?php if ($carte_affichee): ?>
    <div class="container" id="container">
        <div class="carte">
            <label id="nom_utilisateur"><?php echo htmlspecialchars($nom_utilisateur); ?></label><br>
            <a id="dm" href="Patdme.php">DME</a>
        </div>
        <div class="valid-btns" id="valid-btns">
            <button type="button" value="Accepter" id="Acc">Accepter</button>
            <button type="button" value="Refuser" id="Ref">Refuser</button>
        </div>
        <div class="lien">
            <a href="https://meet.google.com/fto-ynbc-tfz" id="tl">Téléconsultation</a>
        </div>
    </div>
    <?php else: ?>
    <div>
        <p id="pp">Aucun rendez-vous</p>
    </div>
    <?php endif; ?>

    <script>
        document.getElementById('Acc').addEventListener('click', function() {
            document.getElementById('valid-btns').style.display = 'none';
            alert('Rendez-vous accepté');
        });

        document.getElementById('Ref').addEventListener('click', function() {
            document.getElementById('container').style.display = 'none';
            alert('Rendez-vous refusé');
        });
    </script>
</body>
</html>
