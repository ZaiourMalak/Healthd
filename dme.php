<?php 
include ('connection.php');

if(isset($_POST['submit'])){
    $file_name = basename($_FILES['fichier']['name']);
    $tempname = $_FILES['fichier']['tmp_name'];
    $folder = 'DME/' . $file_name;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($folder, PATHINFO_EXTENSION));

    // Vérification des erreurs de téléchargement
    if ($_FILES['fichier']['error'] !== UPLOAD_ERR_OK) {
        echo "<h3>Erreur de téléchargement : " . $_FILES['fichier']['error'] . "</h3>";
        $uploadOk = 0;
    }

    

    // Check if file already exists
    if (file_exists($folder)) {
        echo "Désolé, le fichier existe déjà.";
        $uploadOk = 0;
    }

    // Check file size
    if ($_FILES['fichier']['size'] > 5000000) { // Limité à 5 Mo
        echo "Désolé, votre fichier est trop volumineux.";
        $uploadOk = 0;
    }

    // Allow certain file formats
    $allowed_types = array("jpg", "jpeg", "png", "gif", "pdf");
    if(!in_array($imageFileType, $allowed_types)) {
        echo "Désolé, seuls les fichiers JPG, JPEG, PNG, GIF et PDF sont autorisés.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Désolé, votre fichier n'a pas été téléchargé.";
    } else {
        // if everything is ok, try to upload file
        if (move_uploaded_file($tempname, $folder)) {
            // Insérer le nom du fichier dans la base de données
            $query = mysqli_query($conn, "INSERT INTO dme (fichier) VALUES ('" . mysqli_real_escape_string($conn, $file_name) . "')");
            if ($query) {
                echo "<h2>Le fichier a été téléchargé avec succès !</h2>";
            } else {
                echo "<h3>Erreur lors de l'insertion dans la base de données</h3>";
            }
        } else {
            echo "<h3>Le fichier n’a pas été téléchargé</h3>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        .menu {
            font-family: 'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif;
            padding: 20px;
            margin-left: 350px;
            position: absolute;
            top: 80px;
            left: 300px;
        }
        #itemH, #itemR, #itemD {
            padding-right: 50px;
            font-size: 21px;
            background: linear-gradient(to top, rgb(199, 127, 127), rgb(49, 80, 216));
            -webkit-background-clip: text;
            color: transparent;
            cursor: pointer;
        }
        #logo {
            width: 200px;
        }
        #itemR {
            position: relative;
            left: 60px;
            top: 0px;
        }
        #itemD {
            position: relative;
            left: 100px;
            top: 0px;
        }
        .container {
            border: 3px solid;
            width: 800px;
            height: auto;
            position: relative;
            left: 270px;
            border-radius: 70px;
            border-style: outset;
            box-shadow: 5px 5px 15px 1px rgb(137, 43, 226);
        }
        form {
            padding: 50px 120px;
        }
        h1 {
            font-family: 'Times New Roman', Times, serif;
            padding-left: 240px;
            font-size: 30px;
            font-weight: 200;
            background: linear-gradient(to top, rgb(53, 21, 128), rgb(202, 49, 216));
            -webkit-background-clip: text;
            color: transparent;
        }
        #btn {
            font-family: 'Times New Roman', Times, serif;
            color: rgb(127, 78, 173);
            font-weight: 600;
            font-size: 18px;
            position: relative;
            left: 80px;
        }
        #file {
            position: relative;
            left: 50px;
        }
        .gallery img {
            max-width: 100%;
            margin: 10px;
        }
    </style>
</head>
<body>
    <img id="logo" src="images/logo.PNG">
    <div class="menu">
        <a id="itemH" href="PFirst.php">Accueil</a>
        <a id="itemR" href="RDV.php">Rendez-vous</a>    
        <a id="itemD" href="dme.php">Dossiers Médicaux</a>    
    </div>
    <div class="container">
        <h1>Vos Dossiers Médicaux</h1>
        <form method="post" enctype="multipart/form-data">
            <input type="file" name="fichier" id="file">
            <button id="btn" type="submit" name="submit">Ajouter</button>
        </form>
        <div class="gallery">
          <?php  
          $res = mysqli_query($conn, "SELECT * FROM dme");
          while($row = mysqli_fetch_assoc($res)) {
            $file_path = 'DME/' . htmlspecialchars($row['fichier']);
            if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $file_path)) {
                echo '<img src="' . $file_path . '" alt="Image uploadée" />';
            } else {
                echo '<a href="' . $file_path . '">' . htmlspecialchars($row['fichier']) . '</a>';
            }
          }
          ?>
        </div>
    </div>
</body>
</html>
