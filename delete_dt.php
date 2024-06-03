<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['dt_id'])) {
        $dt_id = intval($_POST['dt_id']);

        // Prepare the delete statement
        $sql = "DELETE FROM demande_travail WHERE dt_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $dt_id);

        if ($stmt->execute()) {
            echo 'success';
        } else {
            echo 'Error: ' . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        echo 'No dt_id provided';
    }
} else {
    echo 'Invalid request method';
}
?>