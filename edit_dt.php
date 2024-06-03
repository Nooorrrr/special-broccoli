<?php
session_start();
include 'config.php';

if (isset($_GET['dt_id'])) {
    $dt_id = intval($_GET['dt_id']);

    // Fetch existing data
    $sql = "SELECT * FROM demande_travail WHERE dt_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $dt_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $demande = $result->fetch_assoc();
    
    // Fetch provenances for the dropdown
    $provSql = "SELECT * FROM provenance";
    $provResult = $conn->query($provSql);
    $provenances = $provResult->fetch_all(MYSQLI_ASSOC);
} else {
    echo "Invalid request.";
    exit();
}

// Update data
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $numeroDT = $_POST["numeroDT"];
    $Designation = $_POST["Designation"];
    $serie = $_POST["serie"];
    $affectation = $_POST["affectation"];
    $atm = $_POST["atm"];
    $Date = $_POST["Date"];
    $marque = $_POST["marque"];
    $matricule = $_POST["matricule"];
    $provenance = $_POST["provenance"];
    $rep = $_POST["rep"];
    $type = $_POST["type"];
    $code = $_POST["code"];
    $du = $_POST["du"];
    $Description = $_POST["Description"];

    $updateSql = "UPDATE demande_travail SET dt_num=?, dt_design=?, dt_serie=?, dt_aff=?, dt_ATM=?, dt_date=?, dt_marque=?, dt_matr=?, prov_id=?, dt_dj_rep=?, dt_type=?, dt_code=?, dt_du=?, dt_desc=? WHERE dt_id=?";
    $stmt = $conn->prepare($updateSql);
    $stmt->bind_param("ssssssssisssssi", $numeroDT, $Designation, $serie, $affectation, $atm, $Date, $marque, $matricule, $provenance, $rep, $type, $code, $du, $Description, $dt_id);

    if ($stmt->execute()) {
        echo "Record updated successfully";
        header("Location: home_respTGM.php");
        exit();
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Modifier Demande de travail</title>
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
                <h2 class="title"><strong>Modifier une Demande De Travail</strong></h2>
            </div>
            <div class="form">
                <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"] . '?dt_id=' . $dt_id); ?>">
                <div class="formcontent">
                    <div class="leftform">
                    <label for="numeroDT">N°:</label>
                    <input type="text" id="numeroDT" name="numeroDT" value="<?php echo htmlspecialchars($demande['dt_num']); ?>" required>
                    <label for="Designation">Designation</label>
                    <input type="text" id="Designation" name="Designation" value="<?php echo htmlspecialchars($demande['dt_design']); ?>" required>
                    <label for="serie">Serie:</label>
                    <input type="text" id="serie" name="serie" value="<?php echo htmlspecialchars($demande['dt_serie']); ?>" required>
                    <label for="affectation">Affectation:</label>
                    <select id="affectation" name="affectation" required>
                        <option value="UMN" <?php if ($demande['dt_aff'] == 'UMN') echo 'selected'; ?>>UMN</option>
                        <option value="UMS" <?php if ($demande['dt_aff'] == 'UMS') echo 'selected'; ?>>UMS</option>
                        <option value="URO" <?php if ($demande['dt_aff'] == 'URO') echo 'selected'; ?>>URO</option>
                    </select>
                    <label for="atm">ATM:</label>
                    <input type="text" id="atm" name="atm" value="<?php echo htmlspecialchars($demande['dt_ATM']); ?>" required>
                    </div>

                    <div class="middleform">
                    <label for="date">Date:</label>
                    <input type="date" id="Date" name="Date" value="<?php echo htmlspecialchars($demande['dt_date']); ?>" required>
                    <label for="marque">Marque:</label>
                    <input type="text" id="marque" name="marque" value="<?php echo htmlspecialchars($demande['dt_marque']); ?>" required>
                    <label for="matricule">matricule:</label>
                    <input type="text" id="matricule" name="matricule" value="<?php echo htmlspecialchars($demande['dt_matr']); ?>" required>    
                    <label for="provenance">Provenance:</label>
                    <select name="provenance" id="provenance" required>
                        <?php foreach ($provenances as $prov): ?>
                            <option value="<?php echo $prov['prov_id']; ?>" <?php if ($demande['prov_id'] == $prov['prov_id']) echo 'selected'; ?>><?php echo $prov['prov_nom']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div>
                        <label for="rep">Déjà réparé:</label><br>
                        <div>
                            <label>Oui :</label>
                            <input type="radio" id="rep" name="rep" value="oui" <?php if ($demande['dt_dj_rep'] == 'oui') echo 'checked'; ?> required>
                            <label>Non :</label>
                            <input type="radio" id="rep" name="rep" value="non" <?php if ($demande['dt_dj_rep'] == 'non') echo 'checked'; ?> required>
                        </div>
                    </div>
                   </div>
                   <div class="rightform">
                    <label for="type">Type:</label>
                    <input type="text" id="type" name="type" value="<?php echo htmlspecialchars($demande['dt_type']); ?>" required>
                    <label for="code">Code:</label>
                    <input type="text" id="code" name="code" value="<?php echo htmlspecialchars($demande['dt_code']); ?>" required>
                    <label for="du">du:</label>
                    <input type="date" id="du" name="du" value="<?php echo htmlspecialchars($demande['dt_du']); ?>" required>
                    </div>
                </div>
                <div class="desc-and-button" style="display:flex; flex-direction:column;">
                    <label for="Description" style="margin-bottom:10px;">Description:</label>
                    <input type="text" id="Description" name="Description" value="<?php echo htmlspecialchars($demande['dt_desc']); ?>" style="width: 80%; height:150px;">
                    <button type="submit" style="background-color:#F15E2A; border:none; border-radius:10px; color:white; width:5rem; height: 2rem; margin:10px; position:absolute; left: 70%;">Valider</button>
                </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
