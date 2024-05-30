<?php
include 'connection.php';



if ($conn->connect_error) {
    die("Erreur de connexion : " . $conn->connect_error);
}

// Récupérer la requête de recherche
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Requête SQL pour vérifier si un médecin existe par nom ou spécialité
$sql = "SELECT * FROM medecin WHERE nom LIKE ? OR specialite LIKE ? OR prenom LIKE ?";
$stmt = $conn->prepare($sql);
$param = "%" . $search . "%";
$stmt->bind_param("sss", $param, $param, $param);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Médecin trouvé, rediriger vers RDV.php
    header("Location: RDV.php");
    exit;
} else {
    // Médecin non trouvé, rediriger vers une page d'erreur ou afficher un message
    echo "Médecin non trouvé";
    // Vous pouvez aussi rediriger vers une page spécifique en cas de non trouvaille
    // header("Location: erreur.php");
    // exit;
}

// Libérer les résultats et fermer la connexion
$stmt->close();
$conn->close();
?>
