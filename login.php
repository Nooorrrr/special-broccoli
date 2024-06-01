<?php
session_start();
include 'config.php';

$username = $_POST['username'];
$password = $_POST['password'];

// Check in responsable table
$sql_responsable = "SELECT * FROM responsable_TGM WHERE util_nom='$username' AND util_mdp='$password'";
$result_responsable = $conn->query($sql_responsable);

// Check in gestionnaire table
$sql_gestionnaire = "SELECT * FROM gestionnaire WHERE util_nom='$username' AND util_mdp='$password'";
$result_gestionnaire = $conn->query($sql_gestionnaire);

// Check in chef table
$sql_chef = "SELECT * FROM chef_atelier WHERE util_nom='$username' AND util_mdp='$password'";
$result_chef = $conn->query($sql_chef);

// Check if the user exists in any of the tables
if ($result_responsable->num_rows > 0) {
    $_SESSION['role'] = 'responsable';
    header('Location: home_respTGM.html');
} elseif ($result_gestionnaire->num_rows > 0) {
    $_SESSION['role'] = 'gestionnaire';
    header('Location: home_respTGM.htm');
} elseif ($result_chef->num_rows > 0) {
    $_SESSION['role'] = 'chef';
    header('Location: home_respTGM.htm');
} else {
    echo "Invalid username or password";
}

$conn->close();
?>
