<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="First.css">
        
    </head>
    <body> 
        
    <script type="text/javascript">
        function afficherAlerte() {
           
            var message = "Veuillez vous authentifier pour effectuer une recherche.";
            alert(message);
        }
    </script>


            <img id="logo" src="images/logo.PNG" >
            <div class="menu">
                <a id="itemH" href="First.php">Acceuil</a>
                <a id="itemC" href="Connexion.php">Connexion</a>
                <div class="inscription">
                    <button id="itemI"  class="dropbtn">inscription
                      <i class="down"></i>
                    </button>
                    <div class="insc-content">
                      <a href="inspa.php">Patient</a>
                      <a href="insmed.php">Medecin</a>
                      
                    </div>
                  </div>
                   
            
               
            </div>
        
       
        <h1 id="title">consultez un professionnel de santé en ligne</h1>
        <img id="medpic" src="images/themedpic.png">
        <input type="text" id="search" name="search" placeholder="chercher un médecin une spécialité ">

        <script type="text/javascript">
        // Sélection du bouton
        var bouton = document.getElementById("search");

        // Ajout d'un écouteur d'événement pour le clic sur le bouton
        bouton.addEventListener("click", afficherAlerte);
    </script>
       
    </body>
</html>