<?php
include 'config.php';

if (isset($_GET['ot_id'])) {
    $ot_id = intval($_GET['ot_id']);

    $sql = "SELECT te.tr_nom, te.tr_date, te.tr_exec, te.tr_hr
            FROM Travail_effectué te
            INNER JOIN Ordre_travail ot ON te.ot_id = ot.ot_id
            WHERE te.ot_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $ot_id);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    echo "Invalid request. No ordre de travail ID provided.";
    exit();
}

// Check if there are any rows in the result
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['tr_nom']}</td>
                <td>{$row['tr_date']}</td>
                <td>{$row['tr_exec']}</td>
                <td>{$row['tr_hr']}</td>
              </tr>";
    }
} 
$stmt->close();
$conn->close();
?>
