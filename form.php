<?php
session_start();
include 'config.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Demande de travail</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="formstyle.css">
</head>
<body>
    <header>
        <img src="imgg/images.png" alt="Logo" class="logo">
        <div class="profile"><?php echo htmlspecialchars($_SESSION['username']); ?></div>
    </header>
    <hr class="trai">
    <div class="conteneur">
        <div class="gauche">
            <h2>GMI</h2>
            <div class="cadre">
               <p class="text">Tableau de bord</p>
            </div>
        </div>
        <div class="droite">
            <div class="header-droite">
                <h2 class="title"><strong>Ajouter une Demande De Travail</strong></h2>
            </div>
            <div class="form">
                <form action="/submit" method="post">
                <div class="formcontent">
                    <div class="leftform">
                    <label for="numeroDT">N°:</label>
                    <input type="text" id="numeroDT" name="numeroDT" required>
                    <label for="Designation">Designation</label>
                    <input type="text" id="Designation" name="Designation" required>
                    <label for="serie">Serie:</label>
                    <input type="text" id="serie" name="serie" required>
                    <label for="affectation">Affectation:</label>
                    <input type="text" id="affectation" name="affection" required>
                    <label for="atm">ATM:</label>
                    <input type="text" id="atm" name="atm" required>
                    </div>

                    <div class="middleform">
                    <label for="date">Date:</label>
                    <input type="date" id="Date" name="Date" required>
                    <label for="marque">Marque:</label>
                    <input type="text" id="marque" name="marque" required>
                    
                    <label for="matricule">matricule:</label>
                    <input type="text" id="matricule" name="matricule" required>    
                    <label for="type">Provenance:</label>
                    <input type="text" id="Provenance" name="Provenance" required>

                    <div >
                        <label for="rep">deja reparé:</label><br>
                        <div>
                        <label >Oui :</label>
                        <input type="radio" id="rep" name="rep" required>
                        <label >Non :</label>
                        <input type="radio" id="rep" name="rep" required>
                        </div>
                    </div>
                   </div>
                   <div class="rightform">
                    <label for="type">Type:</label>
                    <input type="text" id="type" name="type" required>
                    <label for="type">code:</label>
                    <input type="text" id="code" name="code" required>
                    <label for="du">du:</label>
                    <input type="date" id="du" name="du" required>
                    </div>
                 
                </div>
                <div class="desc-and-button" style="display:flex; flex-direction:column;">
                <label for="Description" style="margin-bottom:10px;">Description:</label>
                <input type="text" id="Description" name="Description" style="width: 80%; height:150px; ">
                <button type="submit" style="background-color:#F15E2A; border:none; border-radius:10px; color :white; width:5rem; height: 2rem; margin:10px; position:absolute; left: 70%; ">Valider</button> 
                </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
