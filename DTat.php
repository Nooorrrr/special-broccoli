<?php
session_start();
include 'config.php';


// Query to fetch data from the database
$structure = $_SESSION['structure'];
$sql = "SELECT dt.dt_date, dt.dt_num, dt.dt_code, dt.dt_design, p.prov_nom, dt.dt_aff
FROM demande_travail dt
INNER JOIN provenance p ON dt.prov_id = p.prov_id
WHERE dt.dt_aff = '$structure'";

$result = $conn->query($sql);

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
        echo "<td><a>view</a></td>";
        echo "<td><a>view</a></td>";
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