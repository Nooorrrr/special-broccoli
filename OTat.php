<?php
include 'config.php';

if (isset($_GET['dt_id'])) {
    $dt_id = intval($_GET['dt_id']);

    $sql = "SELECT DISTINCT ot.ot_date, ot.ot_num, ot.ot_atelier, ot.ot_code_inter,
    dt.dt_code, dt.dt_design
FROM ordre_travail ot 
INNER JOIN demande_travail dt ON ot.dt_id = dt.dt_id
INNER JOIN chef_atelier c ON ot.ot_atelier = c.chef_at
WHERE ot.dt_id = ? AND c.chef_at = ?";

    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $dt_id, $_SESSION['atelier']); // Assuming $_SESSION['atelier'] holds the chef's atelier
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
                <td>{$row['ot_date']}</td>
                <td>{$row['ot_num']}</td>
                <td>{$row['dt_code']}</td>
                <td>{$row['dt_design']}</td>
                <td>{$row['ot_atelier']}</td>
                <td><a>view</a></td>
                <td><img src='imgg/mdi--printer.svg' alt='printer' class='print-icon'>
                <img src='imgg/mdi--eye.svg' alt='eye'><td>
              </tr>";
    }
} 
$stmt->close();
$conn->close();
?>