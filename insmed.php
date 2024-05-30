<?php
session_start();

include("connection.php");

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $nom = mysqli_real_escape_string($conn, $_POST['nom']);
    $prenom = mysqli_real_escape_string($conn, $_POST['prenom']);
    $specialite = mysqli_real_escape_string($conn, $_POST['specialite']);
    $telephone = mysqli_real_escape_string($conn, $_POST['telephone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $mot_passe = mysqli_real_escape_string($conn, $_POST['mot_passe']);

    if (!empty($nom) && !empty($prenom) && !empty($specialite) && !empty($telephone) && !empty($email) && !empty($mot_passe)) {
        $query = "INSERT INTO medecin (nom, prenom, specialite, telephone, email, mot_passe) VALUES ('$nom', '$prenom', '$specialite', '$telephone', '$email', '$mot_passe')";

        if (mysqli_query($conn, $query)) {
            echo "<script>alert('Inscription réussie!'); window.location.href='EspaceMed.php';</script>";
        } else {
            echo "Erreur : " . mysqli_error($conn);
        }
        die;
    } else {
        echo "Entrez des informations valides !";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link href="insmed.css" rel="stylesheet">
</head>
<body>
    <img id="logo" src="images/logo.PNG">
    <div class="menu">
        <a id="itemH" href="First.php">Accueil</a>
        <a id="itemC" href="Connexion.php">Connexion</a>
        <div class="inscription">
            <button id="itemI" class="dropbtn">Inscription
                <i class="down"></i>
            </button>
            <div class="insc-content">
                <a href="inspa.php">Patient</a>
                <a href="insmed.php">Médecin</a>
            </div>
        </div>
    </div>
    <div class="container" id="container">
        <div class="form-container">
            <form method="post">
                <input type="text" placeholder="Nom" name="nom"><br>
                <input type="text" placeholder="Prénom" name="prenom"><br>
                <input list="specialites" name="specialite" placeholder="Spécialité">
                <datalist id="specialites">
                    <option value="Allergologie">Allergologie</option>
                    <option value="Anatomie pathologique">Anatomie pathologique</option>
                    <option value="Andrologie">Andrologie</option>
                    <option value="Anesthésiologie">Anesthésiologie</option>
                    <option value="Cardiologie">Cardiologie</option>
                    <option value="Chirurgie">Chirurgie</option>
                    <option value="Chirurgie cardiaque">Chirurgie cardiaque</option>
                    <option value="Chirurgie plastique, reconstructive et esthétique">Chirurgie plastique, reconstructive et esthétique</option>
                    <option value="Chirurgie générale">Chirurgie générale</option>
                    <option value="Chirurgie gynécologique">Chirurgie gynécologique</option>
                    <option value="Chirurgie maxillo-faciale">Chirurgie maxillo-faciale</option>
                    <option value="Chirurgie oculaire">Chirurgie oculaire</option>
                    <option value="Chirurgie orale">Chirurgie orale</option>
                    <option value="Chirurgie pédiatrique">Chirurgie pédiatrique</option>
                    <option value="Chirurgie thoracique">Chirurgie thoracique</option>
                    <option value="Chirurgie vasculaire">Chirurgie vasculaire</option>
                    <option value="Chirurgie viscérale">Chirurgie viscérale</option>
                    <option value="Neurochirurgie">Neurochirurgie</option>
                    <option value="Dermatologie">Dermatologie</option>
                    <option value="Endocrinologie">Endocrinologie</option>
                    <option value="Gastro-entérologie">Gastro-entérologie</option>
                    <option value="Gériatrie">Gériatrie</option>
                    <option value="Gynécologie">Gynécologie</option>
                    <option value="Hématologie">Hématologie</option>
                    <option value="Hépatologie">Hépatologie</option>
                    <option value="Infectiologie">Infectiologie</option>
                    <option value="Médecine du travail">Médecine du travail</option>
                    <option value="Médecine générale">Médecine générale</option>
                    <option value="Médecine interne">Médecine interne</option>
                    <option value="Médecine nucléaire">Médecine nucléaire</option>
                    <option value="Médecine palliative">Médecine palliative</option>
                    <option value="Néonatologie">Néonatologie</option>
                    <option value="Néphrologie">Néphrologie</option>
                    <option value="Neurologie">Neurologie</option>
                    <option value="Oncologie">Oncologie</option>
                    <option value="Ophtalmologie">Ophtalmologie</option>
                    <option value="Orthopédie">Orthopédie</option>
                    <option value="Oto-rhino-laryngologie">Oto-rhino-laryngologie</option>
                    <option value="Pédiatrie">Pédiatrie</option>
                    <option value="Pneumologie">Pneumologie</option>
                    <option value="Psychiatrie">Psychiatrie</option>
                    <option value="Radiologie">Radiologie</option>
                    <option value="Radiothérapie">Radiothérapie</option>
                    <option value="Rhumatologie">Rhumatologie</option>
                    <option value="Urologie">Urologie</option>
                </datalist><br>
                <input type="tel" placeholder="Téléphone" name="telephone"><br>
                <input type="email" placeholder="Email" name="email"><br>
                <input type="password" placeholder="Mot de passe" name="mot_passe"><br>
                <button type="submit" name="creer">Créer un compte</button>
            </form>
            <img id="motif" src="images/motif.png">
            <img id="motif1" src="images/motif.png">
        </div>
        <h1>Bienvenue! Créez votre espace Médecin</h1>
        <h2>Facilitez votre travail avec notre plateforme de téléconsultation médicale</h2>
        <h3>Offrez des soins de qualité, où que vous soyez</h3>
    </div>
</body>
</html>
