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
    <script>
        // Function to delete a row
        function deleteRow(btn) {
            var row = btn.closest('tr');
            row.parentNode.removeChild(row);
        }

        // Function to print a row's content as PDF
        async function printRow(btn) {
            var row = btn.closest('tr');
            var cells = row.getElementsByTagName('td');
            var doc = new jspdf.jsPDF();

            let content = '';
            for (var i = 0; i < cells.length - 1; i++) { // -1 to exclude the last cell containing icons
                content += cells[i].innerText + ' ';
            }

            doc.text(content, 10, 10);
            doc.save('row-content.pdf');
        }

        document.addEventListener('DOMContentLoaded', function() {
            var trashIcons = document.querySelectorAll('.trash-icon');
            var printIcons = document.querySelectorAll('.print-icon');

            trashIcons.forEach(function(icon) {
                icon.addEventListener('click', function() {
                    deleteRow(this);
                });
            });

            printIcons.forEach(function(icon) {
                icon.addEventListener('click', function() {
                    printRow(this);
                });
            });
        });
    </script>
</head>
<body>
    
    <?php
    if (isset($_GET['dt_id']) && isset($_GET['dt_num'])) {
    $dt_id = $_GET['dt_id'];
    $numDT = $_GET['dt_num'];
    $_SESSION['numDT'] = $numDT; // Set numDT in session
} else {
    echo "Invalid request.";
    exit();
} ?>
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
                <h2 class="title"><strong>Sous traitances externe</strong></h2>
                <h3 class="title"><strong>Num DT: <?php echo $_SESSION['numDT']; ?></strong></h3>
                <input type="text" placeholder="Rechercher..." class="recherche">
                <button class="ajouter"><a href="form.html">+ Ajouter</a></button>
            </div>
            <table class="table">
                <thead>
                <tr>
                    
                    <th>Designation</th>
                    <th>qte</th>
                    <th>prix</th>
                    <th>fournisseur</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                    <?php include 'STIgest.php'; ?>
                </tbody>
               
            </table>
        </div>
    </div>
</body>
</html>