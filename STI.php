<?php
include 'config.php';

if (isset($_GET['dt_id'])) {
    $dt_id = intval($_GET['dt_id']);

    $sql = "SELECT sti.sti_design, sti.sti_qte, sti.sti_prix, prov.prov_nom
    FROM sous_traitance_interne sti
    INNER JOIN demande_travail dt ON sti.dt_id = dt.dt_id
    INNER JOIN provenance prov ON sti.prov_id = prov.prov_id
    WHERE sti.dt_id = ?";
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
                <td>{$row['sti_design']}</td>
                <td>{$row['sti_qte']}</td>
                <td>{$row['sti_prix']}</td>
                <td>{$row['prov_nom']}</td>
              </tr>";
    }
} 
$stmt->close();
$conn->close();
?>