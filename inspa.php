<?php    
session_start();

include("connection.php");
include("functions.php");

if($_SERVER['REQUEST_METHOD'] == "POST")
{
    $nom_p = mysqli_real_escape_string($conn, $_POST['nom_p']);
    $prenom_p = mysqli_real_escape_string($conn, $_POST['prenom_p']);
    $sexe = mysqli_real_escape_string($conn, $_POST['sexe']);
    $date_naissance = mysqli_real_escape_string($conn, $_POST['date_naissance']);
    $telephone = mysqli_real_escape_string($conn, $_POST['telephone']);
    $nom_utilisateur = mysqli_real_escape_string($conn, $_POST['nom_utilisateur']);
    $mot_passe = mysqli_real_escape_string($conn, $_POST['mot_passe']);

    if(!empty($nom_p) && !empty($prenom_p) && !empty($sexe) && !empty($date_naissance) && !empty($telephone) && !empty($nom_utilisateur) && !empty($mot_passe) && !is_numeric($nom_utilisateur))
    {
        $query = "INSERT INTO patient (nom_p, prenom_p, sexe, date_naissance, telephone, nom_utilisateur, mot_passe) VALUES ('$nom_p', '$prenom_p', '$sexe', '$date_naissance', '$telephone', '$nom_utilisateur', '$mot_passe')";
        
        if(mysqli_query($conn, $query)) {
            echo "<script>alert('Inscription réussie!'); window.location.href='Connexion.php';</script>";
        } else {
            echo "Erreur : " . mysqli_error($conn);
        }
        die;
    }
    else {
        echo "Entrez des informations valides !";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link href="inspa.css" rel="stylesheet">
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
                <input type="text" placeholder="Nom" name="nom_p"><br>
                <input type="text" placeholder="Prénom" name="prenom_p"><br>
                <label id="lblsx">Sexe</label><br>
                <div class="radio1">
                    <input type="radio" name="sexe" value="male" id="radioinput">Masculin
                </div>
                <div class="radio1">
                    <input type="radio" name="sexe" value="female" id="radioinput">Féminin
                </div>
                <label id="lbldn">Date naissance</label><br>
                <input type="date" id="inputdatenais" name="date_naissance"><br>
                <input type="tel" placeholder="Téléphone" name="telephone"><br>
                <input type="text" placeholder="Nom d'utilisateur" name="nom_utilisateur"><br>
                <input type="password" placeholder="Mot de passe" name="mot_passe"><br>
                
                <button type="submit" name="créer">Créer un compte</button>
            </form>
            <img id="motif" src="images/motif.png">
            <img id="motif1" src="images/motif.png">
        </div>
        <h1>Bienvenue! Créez votre espace patient</h1>
        <h2>Profitez des avantages d'être un membre de notre communauté</h2>
        <h3>Pour une meilleure accessibilité et qualité des soins pour les patients</h3>
    </div>
</body>
</html>
