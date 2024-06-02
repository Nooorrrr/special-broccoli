<?php
include 'config.php';

if (isset($_GET['dt_id'])) {
    $dt_id = intval($_GET['dt_id']);

    $sql = "SELECT ste.ste_design, ste.ste_qte,
    ste.ste_prix, ste.ste_four
FROM sous_traitance_externe ste
INNER JOIN demande_travail dt ON ste.dt_id = dt.dt_id
WHERE ste.dt_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $dt_id);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    echo "Invalid request. No demande de travail ID provided.";
    exit();
}

// Check if there are any rows in the result
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['ste_design']}</td>
                <td>{$row['ste_qte']}</td>
                <td>{$row['ste_prix']}</td>
                <td>{$row['ste_four']}</td>
              </tr>";
    }
} 
$stmt->close();
$conn->close();
?>