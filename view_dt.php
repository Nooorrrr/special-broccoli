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

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Voir Demande de travail</title>
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
                <h2 class="title"><strong>Voir Demande De Travail</strong></h2>
            </div>
            <div class="form">
                <div class="formcontent">
                    <div class="leftform">
                    <label for="numeroDT">N°:</label>
                    <input type="text" id="numeroDT" name="numeroDT" value="<?php echo htmlspecialchars($demande['dt_num']); ?>" disabled>
                    <label for="Designation">Designation</label>
                    <input type="text" id="Designation" name="Designation" value="<?php echo htmlspecialchars($demande['dt_design']); ?>" disabled>
                    <label for="serie">Serie:</label>
                    <input type="text" id="serie" name="serie" value="<?php echo htmlspecialchars($demande['dt_serie']); ?>" disabled>
                    <label for="affectation">Affectation:</label>
                    <select id="affectation" name="affectation" disabled>
                        <option value="UMN" <?php if ($demande['dt_aff'] == 'UMN') echo 'selected'; ?>>UMN</option>
                        <option value="UMS" <?php if ($demande['dt_aff'] == 'UMS') echo 'selected'; ?>>UMS</option>
                        <option value="URO" <?php if ($demande['dt_aff'] == 'URO') echo 'selected'; ?>>URO</option>
                    </select>
                    <label for="atm">ATM:</label>
                    <input type="text" id="atm" name="atm" value="<?php echo htmlspecialchars($demande['dt_ATM']); ?>" disabled>
                    </div>
                    <div class="middleform">
                    <label for="date">Date:</label>
                    <input type="date" id="Date" name="Date" value="<?php echo htmlspecialchars($demande['dt_date']); ?>" disabled>
                    <label for="marque">Marque:</label>
                    <input type="text" id="marque" name="marque" value="<?php echo htmlspecialchars($demande['dt_marque']); ?>" disabled>
                    <label for="matricule">matricule:</label>
                    <input type="text" id="matricule" name="matricule" value="<?php echo htmlspecialchars($demande['dt_matr']); ?>" disabled>    
                    <label for="provenance">Provenance:</label>
                    <select name="provenance" id="provenance" disabled>
                        <?php foreach ($provenances as $prov): ?>
                            <option value="<?php echo $prov['prov_id']; ?>" <?php if ($demande['prov_id'] == $prov['prov_id']) echo 'selected'; ?>><?php echo $prov['prov_nom']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <div>
                        <label for="rep">Déjà réparé:</label><br>
                        <div>
                            <label>Oui :</label>
                            <input type="radio" id="rep" name="rep" value="oui" <?php if ($demande['dt_dj_rep'] == 'oui') echo 'checked'; ?> disabled>
                            <label>Non :</label>
                            <input type="radio" id="rep" name="rep" value="non" <?php if ($demande['dt_dj_rep'] == 'non') echo 'checked'; ?> disabled>
                        </div>
                    </div>
                   </div>
                   <div class="rightform">
                    <label for="type">Type:</label>
                    <input type="text" id="type" name="type" value="<?php echo htmlspecialchars($demande['dt_type']); ?>" disabled>
                    <label for="code">Code:</label>
                    <input type="text" id="code" name="code" value="<?php echo htmlspecialchars($demande['dt_code']); ?>" disabled>
                    <label for="du">du:</label>
                    <input type="date" id="du" name="du" value="<?php echo htmlspecialchars($demande['dt_du']); ?>" disabled>
                    </div>
                </div>
                <div class="desc-and-button" style="display:flex; flex-direction:column;">
                    <label for="Description" style="margin-bottom:10px;">Description:</label>
                    <input type="text" id="Description" name="Description" value="<?php echo htmlspecialchars($demande['dt_desc']); ?>" style="width: 80%; height:150px;" disabled>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
