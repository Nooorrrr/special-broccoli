<?php
session_start();
include 'config.php';

// Ensure the form method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Debugging: Print the credentials
    echo "Credentials: Username: $username, Password: $password<br>";

    // Check in responsable_TGM table
    $sql_responsable = "SELECT * FROM responsable_TGM WHERE util_nom = ? AND util_mdp = ?";
    $stmt_responsable = $conn->prepare($sql_responsable);
    $stmt_responsable->bind_param("ss", $username, $password);
    $stmt_responsable->execute();
    $result_responsable = $stmt_responsable->get_result();

    // Check in gestionnaire table
    $sql_gestionnaire = "SELECT * FROM gestionnaire WHERE util_nom = ? AND util_mdp = ?";
    $stmt_gestionnaire = $conn->prepare($sql_gestionnaire);
    $stmt_gestionnaire->bind_param("ss", $username, $password);
    $stmt_gestionnaire->execute();
    $result_gestionnaire = $stmt_gestionnaire->get_result();

    // Check in chef_atelier table
    $sql_chef = "SELECT * FROM chef_atelier WHERE util_nom = ? AND util_mdp = ?";
    $stmt_chef = $conn->prepare($sql_chef);
    $stmt_chef->bind_param("ss", $username, $password);
    $stmt_chef->execute();
    $result_chef = $stmt_chef->get_result();

    // Check if the user exists in any of the tables
    if ($result_responsable->num_rows > 0) {
        $row = $result_responsable->fetch_assoc();
        $_SESSION['role'] = 'responsable';
        $_SESSION['username'] = $row['util_nom'];
        header('Location: home_respTGM.php');
    } elseif ($result_gestionnaire->num_rows > 0) {
        $row = $result_gestionnaire->fetch_assoc();
        $_SESSION['role'] = 'gestionnaire';
        $_SESSION['username'] = $row['util_nom'];
        $_SESSION['structure'] = $row['gest_struct'];
        header('Location: home_gest.php');
    } elseif ($result_chef->num_rows > 0) {
        $row = $result_chef->fetch_assoc();
        $_SESSION['role'] = 'chef';
        $_SESSION['username'] = $row['util_nom'];
        $_SESSION['structure'] = $row['chef_struct'];
        header('Location: home_chef.php');
    } else {
        echo "<script>
                window.location.href='index.php';
                alert('Invalid username or password');
              </script>";
    }

    $stmt_responsable->close();
    $stmt_gestionnaire->close();
    $stmt_chef->close();
} else {
    echo "Invalid request method.";
}

$conn->close();
?>