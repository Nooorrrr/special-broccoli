<?php
include 'config.php';

if (isset($_GET['lc_id'])) {
    $lc_id = intval($_GET['lc_id']);

    $sql = "SELECT c.c_design, c.c_ref, c.c_qte, c.c_pu, c.c_bs
            FROM consommation c
            INNER JOIN liste_consommations lc ON c.lc_id = lc.lc_id
            WHERE c.lc_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $lc_id);
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
                <td>{$row['c_design']}</td>
                <td>{$row['c_ref']}</td>
                <td>{$row['c_qte']}</td>
                <td>{$row['c_pu']}</td>
                <td>{$row['c_bs']}</td>
              </tr>";
    }
} 
$stmt->close();
$conn->close();
?>
