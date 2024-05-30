<?php
session_start();

include("connection.php");

$message = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $nom_utilisateur = mysqli_real_escape_string($conn, $_POST['nom_utilisateur']);
    $mot_passe = mysqli_real_escape_string($conn, $_POST['mot_passe']);

    if (!empty($nom_utilisateur) && !empty($mot_passe)) {
        $query = "SELECT * FROM patient WHERE nom_utilisateur = '$nom_utilisateur'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);

            if ($mot_passe == $user_data['mot_passe']) { // Comparaison directe du mot de passe
                $_SESSION['user_id'] = $user_data['id'];
                $message = "Bienvenue à votre espace patient!";
                echo "<script>alert('$message'); window.location.href='PFirst.php';</script>";
                die;
            } else {
                $message = "Nom d'utilisateur ou mot de passe incorrect.";
            }
        } else {
            $message = "Nom d'utilisateur ou mot de passe incorrect.";
        }
    } else {
        $message = "Veuillez entrer des informations valides.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link href="Connexion.css" rel="stylesheet">
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
            <form method="post" action="connexion.php">
                <h1>Espace Patient</h1>
                <?php
                if (!empty($message)) {
                    echo "<p style='color:red;'>$message</p>";
                }
                ?>
                <input placeholder="Nom d'utilisateur" type="text" name="nom_utilisateur" required><br>
                <input placeholder="Mot de passe" type="password" name="mot_passe" required><br>
                <button type="submit" name="connecter">Connecter</button>
                
                <a href="EspaceMed.php" id="lienpmedecin">Je suis un professionnel de santé</a>
            </form>
        </div>
        <img src="loginpat.jpg" id="loginpatient">
    </div>
</body>
</html>



