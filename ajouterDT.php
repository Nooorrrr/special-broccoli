<?php
include 'config.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $date = $_POST['Date'];
    $num = $_POST['numeroDT'];
    $designation = $_POST['Designation'];
    $serie = $_POST['serie'];
    $affectation = $_POST['affectation'];
    $atm = $_POST['atm'];
    $marque = $_POST['marque'];
    $matricule = $_POST['matricule'];
    $provenance = $_POST['Provenance'];
    $rep = $_POST['rep'];
    $type = $_POST['type'];
    $code = $_POST['code'];
    $du = $_POST['du'];
    $description = $_POST['Description'];

    // Insert data into database
    $sql = "INSERT INTO demande_travail (dt_date, dt_num, dt_design, dt_serie, dt_aff, dt_ATM, dt_marque, dt_matr, prov_id, dt_dj_rep, dt_type, dt_code,dt_ du, dt_desc) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssssssssss", $date, $num, $designation, $serie, $affectation, $atm, $marque, $matricule, $provenance, $rep, $type, $code, $du, $description);
    
    // Execute the statement
    if ($stmt->execute()) {
        echo "Demande de travail ajoutée avec succès.";
    } else {
        echo "Une erreur s'est produite lors de l'ajout de la demande de travail.";
    }

    // Close the statement and database connection
    $stmt->close();
    $conn->close();
}
?>
