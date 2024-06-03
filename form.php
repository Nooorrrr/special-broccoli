<?php
session_start();
include 'config.php';

// Fetch provenance options from the database
$sql_provenance = "SELECT prov_id, prov_nom FROM provenance";
$result_provenance = $conn->query($sql_provenance);
$provenances = [];
if ($result_provenance->num_rows > 0) {
    while ($row = $result_provenance->fetch_assoc()) {
        $provenances[] = $row;
    }
}
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
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="formcontent">
                        <div class="leftform">
                            <label for="numeroDT">N°:</label>
                            <input type="text" id="numeroDT" name="numeroDT" required>
                            <label for="Designation">Designation</label>
                            <input type="text" id="Designation" name="Designation" required>
                            <label for="serie">Serie:</label>
                            <input type="text" id="serie" name="serie" required>
                            <label for="affectation">Affectation:</label>
                            <select id="affectation" name="affectation" required>
                                <option value="UMN">UMN</option>
                                <option value="UMS">UMS</option>
                                <option value="URO">URO</option>
                            </select>
                            <label for="atm">ATM:</label>
                            <input type="text" id="atm" name="atm" required>
                        </div>
                        <div class="middleform">
                            <label for="Date">Date:</label>
                            <input type="date" id="Date" name="Date" required>
                            <label for="marque">Marque:</label>
                            <input type="text" id="marque" name="marque" required>
                            <label for="matricule">Matricule:</label>
                            <input type="text" id="matricule" name="matricule" required>
                            <label for="provenance">Provenance:</label>
                            <select name="provenance" id="provenance" required>
                                <?php foreach ($provenances as $prov): ?>
                                    <option value="<?php echo $prov['prov_id']; ?>"><?php echo $prov['prov_nom']; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div>
                                <label for="rep">Déjà réparé:</label><br>
                                <div>
                                    <label>Oui:</label>
                                    <input type="radio" id="rep" name="rep" value="oui" required>
                                    <label>Non:</label>
                                    <input type="radio" id="rep" name="rep" value="non" required>
                                </div>
                            </div>
                        </div>
                        <div class="rightform">
                            <label for="type">Type:</label>
                            <input type="text" id="type" name="type" required>
                            <label for="code">Code:</label>
                            <input type="text" id="code" name="code" required>
                            <label for="du">Du:</label>
                            <input type="date" id="du" name="du" required>
                        </div>
                    </div>
                    <div class="desc-and-button" style="display: flex; flex-direction: column;">
                        <label for="Description" style="margin-bottom: 10px;">Description:</label>
                        <textarea id="Description" name="Description" style="width: 80%; height: 150px;"></textarea>
                        <button type="submit" style="background-color: #F15E2A; border: none; border-radius: 10px; color: white; width: 5rem; height: 2rem; margin: 10px; position: absolute; left: 70%;">Valider</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>

<?php
// Insert data into the database if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $numeroDT = $_POST['numeroDT'];
    $designation = $_POST['Designation'];
    $serie = $_POST['serie'];
    $affectation = $_POST['affectation'];
    $atm = $_POST['atm'];
    $date = $_POST['Date'];
    $marque = $_POST['marque'];
    $matricule = $_POST['matricule'];
    $provenance = $_POST['provenance']; // Selected value from the dropdown list
    $rep = $_POST['rep'];
    $type = $_POST['type'];
    $code = $_POST['code'];
    $du = $_POST['du'];
    $description = $_POST['Description'];

    // Insert data into the database
    $sql = "INSERT INTO demande_travail (dt_num, dt_design, dt_serie, dt_aff, dt_ATM, dt_date, dt_marque, dt_matr,prov_id, dt_dj_rep, dt_type, dt_code, dt_du, dt_desc) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssssssssssssss", $numeroDT, $designation, $serie, $affectation, $atm, $date, $marque, $matricule, $provenance, $rep, $type, $code, $du, $description);

        // Execute the statement
        if ($stmt->execute()) {
            echo "Demande de travail ajoutée avec succès.";
        } else {
            echo "Une erreur s'est produite lors de l'ajout de la demande de travail: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    } else {
        echo "Une erreur s'est produite lors de la préparation de la requête: " . $conn->error;
    }

    // Close the database connection
    $conn->close();
}
?>



