<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="profil.css">
        
    </head>
    <body> 
    <?php
   
    $disponibilites = [
        'Dimanche' => ['', '', ''],
        'Lundi' => ['', '', ''],
        'Mardi' => ['', '', ''],
        'Mercredi' => ['', '', ''],
        'Jeudi' => ['', '', ''],
        'Vendredi' => ['', '', ''],
        'Samedi' => ['', '', '']
    ];

    
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "project";

        
        $conn = new mysqli($servername, $username, $password, $dbname);

       
        if ($conn->connect_error) {
            die("Connexion échouée: " . $conn->connect_error);
        }

       
        $stmt = $conn->prepare("INSERT INTO rdv (jour, heure) VALUES (?, ?)");
        $stmt->bind_param("ss", $jour, $heure);

        
        $jours = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];

        foreach ($jours as $jour) {
            if (isset($_POST[$jour])) {
                foreach ($_POST[$jour] as $index => $heure) {
                    
                    $disponibilites[$jour][$index] = $heure;

                    if (!empty($heure)) {
                        $stmt->execute();
                    }
                }
            }
        }
        
       
    
        
        $stmt->close();
        $conn->close();

       
    }
    
include 'connection.php';

// Récupérer un médecin au hasard
$query = "SELECT nom, prenom, specialite FROM medecin ORDER BY RAND() LIMIT 1";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $medecin = $result->fetch_assoc();
} else {
    echo "Aucun médecin trouvé.";
    exit;
}
    ?>
    
        
            <img id="logo" src="images/logo.PNG" >
            
            <div class="menu">
           
            <a id="i1"  href="Grdv.php">Gestion des rendez-vous</a>
            <a  id="i2" href="profil.php">Votre profil</a>
            </div>
            
            <div class="pfcard">
                <div class="profile">
                    <img src="images/femaleprofile.jpg" id="profilepic">
                    <h3 id="nom&prenom">
                        <span name="prenom"><?php echo $medecin['prenom']; ?></span>  <span name="nom"><?php echo $medecin['nom']; ?></span>
                    </h3>
                    <p id="specialite" name="specialite"><?php echo $medecin['specialite']; ?></p>
                    
                </div>
            </div>

            <form method="POST" action="">
        <div class="availability-list">
            <?php foreach ($disponibilites as $jour => $heures) : ?>
                <div class="availability-day">
                    <label class="day"><?php echo $jour; ?></label>
                    <?php foreach ($heures as $index => $heure) : ?>
                        <input class="time-available" name="<?php echo $jour; ?>[]" type="time" value="<?php echo $heure; ?>">
                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <button type="submit" id="btn">Enregistrer</button>
    </form>
</body>
</html>
