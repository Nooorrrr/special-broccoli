<?php
include 'config.php';


// Ensure the session variables are set
if (!isset($_SESSION['structure']) || !isset($_SESSION['atelier'])) {
    echo "Structure or atelier not set in session.";
    exit();
}

$structure = $_SESSION['structure'];
$atelier = $_SESSION['atelier'];

// Query to fetch data from the database, including dt_id
$sql = "SELECT DISTINCT dt.dt_date, dt.dt_num, dt.dt_code, dt.dt_design, p.prov_nom, dt.dt_aff, dt.dt_id
        FROM demande_travail dt
        INNER JOIN provenance p ON dt.prov_id = p.prov_id
        INNER JOIN ordre_travail ot ON dt.dt_id = ot.dt_id
        INNER JOIN chef_atelier c ON dt.dt_aff = c.chef_struct
        WHERE dt.dt_aff = ? AND ot.ot_atelier = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $structure, $atelier);
$stmt->execute();
$result = $stmt->get_result();

// Check if there are any rows in the result
if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        // Output each row's data in the table
        echo "<tr>";
        echo "<td>" . $row["dt_date"] . "</td>";
        echo "<td>" . $row["dt_num"] . "</td>";
        echo "<td>" . $row["dt_code"] . "</td>";
        echo "<td>" . $row["dt_design"] . "</td>";
        echo "<td>" . $row["prov_nom"] . "</td>";
        echo "<td>" . $row["dt_aff"] . "</td>";
        echo '<td><a href="ot_chef.php?dt_id=' . urlencode($row["dt_id"]) . '&dt_num=' . urlencode($row["dt_num"]) . '">View</a></td>';
        echo '<td><a href="lc_respTGM.php?dt_id=' . urlencode($row["dt_id"]) . '&dt_num=' . urlencode($row["dt_num"]) . '">View</a></td>';
        echo "<td><a>view</a></td>";
        echo "<td><a>view</a></td>";
        echo "<td><a>view</a></td>";
        echo '<td>
            <img src="imgg/mdi--printer.svg" alt="printer" class="print-icon"> 
            <img src="imgg/mdi--eye.svg" alt="eye">
        </td>';
        echo "</tr>";
    }
} 
$conn->close();
?>