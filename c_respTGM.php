<?php
session_start();
include 'config.php';
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
    <header>
        <img src="imgg/images.png" alt="Logo" class="logo">
        <div class="profile"><?php echo htmlspecialchars($_SESSION['username']); ?></div>
    </header>
    <?php
    if (isset($_GET['lc_id']) && isset($_GET['lc_num'])) {
    $ot_id = $_GET['lc_id'];
    $numLC = $_GET['lc_num'];
    $_SESSION['numLC'] = $numLC; // Set numDT in session
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
                <h2 class="title"><strong>Les Consommations</strong></h2>
                <h3 class="title"><strong>Num LC: <?php echo $_SESSION['numLC']; ?></strong></h3>
                <input type="text" placeholder="Rechercher..." class="recherche">
            </div>
            <table class="table">
                <thead>
                <tr>
                    
                    <th>Designation</th>
                    <th>reference</th>
                    <th>Qte</th>
                    <th>prix unitaire</th>
                    <th>N° BS</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                    <?php include 'C.php'; ?>
                </tbody>
               
            </table>
        </div>
    </div>
</body>
</html>