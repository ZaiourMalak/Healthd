<?php
session_start();

include("connection.php");

$message = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $mot_passe = mysqli_real_escape_string($conn, $_POST['mot_passe']);

    if (!empty($email) && !empty($mot_passe)) {
        $query = "SELECT * FROM medecin WHERE email = '$email'";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);

            if ($mot_passe === $user_data['mot_passe']) {
                $_SESSION['user_id'] = $user_data['id'];
                $message = "Bienvenue à votre espace médecin!";
                echo "<script>alert('$message'); window.location.href='Profil.php';</script>";
                die;
            } else {
                $message = "Email ou mot de passe incorrect.";
            }
        } else {
            $message = "Email ou mot de passe incorrect.";
        }
    } else {
        $message = "Veuillez entrer des informations valides.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <link href="EspaceMed.css" rel="stylesheet">
</head>
<body>
    <img id="logo" src="images/logo.PNG">
    <div class="menu">
        <a id="itemH" href="First.php">Home</a>
        <a id="itemC" href="Connexion.php">Connexion</a>
        <div class="inscription">
            <button id="itemI" class="dropbtn">Inscription
                <i class="down"></i>
            </button>
            <div class="insc-content">
                <a href="inspa.php">Patient</a>
                <a href="insmed.php">Medecin</a>
            </div>
        </div>
    </div>
    <div class="container" id="container">
        <div class="form-container">
            <form method="post" action="">
                <h1>Espace Médecin</h1>
                <?php
                if (!empty($message)) {
                    echo "<p style='color:red;'>$message</p>";
                }
                ?>
                <input placeholder="Email" type="email" name="email" required><br>
                <input placeholder="Mot de passe" type="password" name="mot_passe" required><br>
                <button type="submit">Connecter</button>
                
                <a href="Connexion.php" id="lienpmedecin">Je suis un patient</a>
            </form>
        </div>
        <img src="8465661.jpg" id="nrs">
    </div>
</body>
</html>


