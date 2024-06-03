<?php
session_start();
include 'config.php';
include 'header.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Demande de travail</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="formstyle.css">
</head>
<body>
    
    <hr class="trai">
    <div class="conteneur">
        <div class="gauche">
            <h2>GMI</h2>
            <div class="cadre">
               <p class="text">Utilisateur</p>
            </div>
        </div>
        <div class="droite">
            <div class="header-droite">
                <h2 class="title"><strong>Ajouter un utilisateur</strong></h2>
            </div>
            <div class="form">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="formcontent">
                        <div class="leftform">
                    
                            <label for="Nom_util">Nom d'utilisateur :</label>
                            <input type="text" id="Nom_util" name="Nom_util" required>
                            <label for="mdp"> Mots de passe:</label>
                            <input type="text" id="mdp" name="mdp" required>
                            <label for="structeur">Structure:</label>
                            <select id="structure" name="structure" required style="border-radius: 50px;
                            border:1px solid #ccc; width: 250px; height: 10px; padding: 10px;">
                                <option value="UMN">UMN</option>
                                <option value="UMS">UMS</option>
                                <option value="URO">URO</option>
                            </select>
                            <label for="role">Role:</label>
                            <select id="role" name="role" required style="border-radius: 50px;
                            border:1px solid #ccc; width: 250px; height: 10px; padding: 10px;">
                                <option value="chef_atelier">chef_atelier</option>
                                <option value="gestionnaire">gestionnaire</option>
                                <option value="responsable">responsable</option>
                            </select>
                            <button type="submit" style="background-color: #F15E2A; border: none; border-radius: 10px; color: white; width: 5rem; height: 2rem; margin: 10px; ">Valider</button>
                        </div>
                       
                        
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<!--hna u shhould add hadik php thingy to add something f base de donner -->


