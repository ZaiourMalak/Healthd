<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="PFirst.css">
</head>
<body>
    <img id="logo" src="images/logo.PNG">
    <div class="menu">
        <a id="itemH" href="PFirst.php">Accueil</a>
        <a id="itemR" href="RDV.php">Rendez-vous</a>
        <a id="itemD" href="dme.php">Dossiers Médicaux</a>
    </div>

    <h1 id="title">Consultez un professionnel de santé en ligne</h1>
    <img id="medpic" src="images/themedpic.png">
    <form action="search.php" method="GET">
        <input type="text" id="search" name="search" placeholder="Chercher un médecin ou une spécialité" required>
        
        <button type="submit">Rechercher</button>
    </form>
</body>
</html>
