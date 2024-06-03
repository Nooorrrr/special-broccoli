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
    <link rel="stylesheet" href="css.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
</head>
<body>

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
                <h2 class="title"><strong>Demande De Travail</strong></h2>
                <input type="text" placeholder="Rechercher..." class="recherche">
                <button class="ajouter"><a href="form.php">+ Ajouter</a></button>
            </div>
            <table class="table">
                <thead>
                <tr>
                    
                    <th>Date</th>
                    <th>num DT</th>
                    <th>Code</th>
                    <th>Designation</th>
                    <th>Provenance</th>
                    <th>Affectation</th>
                    <th>Ordre de travail</th>
                    <th>Liste des
                         consommations</th>
                    <th>Sous traitance externe</th>
                    <th>Sous traitance interne</th>
                    <th>Cout de reparation</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                    <?php include 'DT.php'; ?>
                </tbody>
               
            </table>
        </div>
    </div>
    <script>
        function toggleDropdown() {
            var dropdown = document.getElementById("dropdown");
            dropdown.style.display = dropdown.style.display === "none" ? "block" : "none";
        }
    </script>
</body>
</html>
