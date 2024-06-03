<?php
include 'config.php';

if (isset($_GET['dt_id'])) {
    $dt_id = intval($_GET['dt_id']);

    $sql = "SELECT ot.ot_date, ot.ot_num, ot.ot_atelier, ot.ot_code_inter,ot_id,
    dt.dt_code, dt.dt_design
FROM ordre_travail ot 
INNER JOIN demande_travail dt ON ot.dt_id = dt.dt_id
WHERE ot.dt_id = ?";
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
                <td>{$row['ot_date']}</td>
                <td>{$row['ot_num']}</td>
                <td>{$row['dt_code']}</td>
                <td>{$row['dt_design']}</td>
                <td>{$row['ot_atelier']}</td>";
                echo '<td><a href="tr_respTGM.php?ot_id=' . urlencode($row["ot_id"]) . '&ot_num=' . urlencode($row["ot_num"]) . '">View</a></td>';
                echo "<td><img src='imgg/mdi--trash.svg' alt='trash' class='trash-icon'> 
                <img src='imgg/mdi--printer.svg' alt='printer' class='print-icon'>
                <img src='imgg/mdi--eye.svg' alt='eye'>
                <img src='imgg/mdi--pencil.svg' alt='pencil'> </td>
              </tr>";
    }
} 
$stmt->close();
$conn->close();
?>