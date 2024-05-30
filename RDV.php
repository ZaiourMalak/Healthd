<?php
include 'connection.php';

// Récupérer la requête de recherche
$search = isset($_GET['search']) ? $_GET['search'] : '';

if ($search) {
    // Requête SQL pour rechercher les médecins par nom ou spécialité
    $sql = "SELECT * FROM medecin WHERE nom LIKE ? OR specialite LIKE ?";
    $stmt = $conn->prepare($sql);
    $param = "%" . $search . "%";
    $stmt->bind_param("ss", $param, $param);
    $stmt->execute();
    $result = $stmt->get_result();

    // Affichage des résultats
    echo "<h1>Résultats de Recherche pour \"" . htmlspecialchars($search) . "\"</h1>";
    if ($result->num_rows > 0) {
        echo "<ul>";
        while ($row = $result->fetch_assoc()) {
            echo "<li>Dr. " . htmlspecialchars($row['nom']) . " " . htmlspecialchars($row['prenom']) . " - Spécialité: " . htmlspecialchars($row['specialite']) . "</li>";
        }
        echo "</ul>";
    } else {
        echo "<p>Médecin non trouvé</p>";
    }

    // Libérer les résultats et fermer la connexion
    $stmt->close();
    $conn->close();
    exit;
}

// Récupérer un médecin au hasard
$query = "SELECT nom, prenom, specialite FROM medecin ORDER BY RAND() LIMIT 1";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $medecin = $result->fetch_assoc();
} else {
    echo "Aucun médecin trouvé.";
    exit;
}

// Récupérer les rendez-vous existants
$rdvQuery = "SELECT jour, heure FROM rdv";
$rdvResult = $conn->query($rdvQuery);

$rdvData = [];
if ($rdvResult->num_rows > 0) {
    while ($row = $rdvResult->fetch_assoc()) {
        $jour = $row['jour'];
        $heure = date('g:i A', strtotime($row['heure'])); // Convertir l'heure au format 12 heures avec AM/PM
        if (!isset($rdvData[$jour])) {
            $rdvData[$jour] = [];
        }
        $rdvData[$jour][] = $heure;
    }
}

// Enregistrer le rendez-vous si une date est postée
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $day = $_POST['day'];
    $time = $_POST['time'];

    // Convertir l'heure au format 24 heures
    $datetime = date('Y-m-d H:i:s', strtotime("$day $time"));

    $query = "INSERT INTO rdv (jour, heure) VALUES ('$day', '$datetime')";
    
    if ($conn->query($query) === TRUE) {
        echo "Rendez-vous enregistré avec succès.";
    } else {
        echo "Erreur: " . $conn->error;
    }
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <link href="RDV.css" rel="stylesheet">
</head>
<body>
    <img id="logoo" src="images/logo.PNG">
    <div class="menu">
        <a id="itemH" href="PFirst.php">Accueil</a>
        <a id="itemR" href="RDV.php">Rendez-vous</a> 
        <a id="itemD" href="dme.php">Dossiers Médicaux</a>    
    </div>
    <div class="pfcard">
        <div class="profile">
            <img src="images/femaleprofile.jpg" id="profilepic">
            <h1 id="nom&prenom">
                <span name="prenom"><?php echo $medecin['prenom']; ?></span>
                <span name="nom"><?php echo $medecin['nom']; ?></span>
            </h1>
            <p id="specialite" name="specialite"><?php echo $medecin['specialite']; ?></p>
            <button id="Rdvbtn" type="submit">Prendre RDV</button>
        </div>
         
    </div>
    <a href="https://meet.google.com/fto-ynbc-tfz" id="cl">Téléconsultation</a>
    <h2>Disponibilité</h2>
    <div class="availability-list">
        <?php
        $days = ['Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi'];
        foreach ($days as $day) {
            echo '<div class="availability-day">';
            echo "<label class='day'>$day</label>";
            if (isset($rdvData[$day])) {
                foreach ($rdvData[$day] as $time) {
                    echo "<button class='time-available' data-day='$day'>$time</button>";
                }
            } else {
                echo "<p>Aucun créneau disponible</p>";
            }
            echo '</div>';
        }
        ?>
    </div>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const timeButtons = document.querySelectorAll(".time-available");

            timeButtons.forEach(button => {
                button.addEventListener("click", function() {
                    if (!button.classList.contains("reserved")) {
                        timeButtons.forEach(btn => btn.classList.remove("selected"));
                        button.classList.add("selected");
                    }
                });
            });

            document.getElementById("Rdvbtn").addEventListener("click", function() {
                const selectedButton = document.querySelector(".time-available.selected");
                if (selectedButton) {
                    const day = selectedButton.getAttribute("data-day");
                    const time = selectedButton.innerText;
                    const xhr = new XMLHttpRequest();
                    xhr.open("POST", "RDV.php", true);
                    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState === 4 && xhr.status === 200) {
                            alert("Rendez-vous pris pour " + day + " à " + time);
                        }
                    };
                    xhr.send("day=" + day + "&time=" + time);
                } else {
                    alert("Veuillez sélectionner une plage horaire.");
                }
            });
        });
    </script>
</body>
</html>
