<?php
include 'config.php';

// Ensure the session variable is set
if (!isset($_SESSION['structure'])) {
    echo "Structure not set in session.";
    exit();
}

$structure = $_SESSION['structure'];

// Query to fetch data from the database, including dt_id
$sql = "SELECT dt.dt_date, dt.dt_num, dt.dt_code, dt.dt_design, p.prov_nom, dt.dt_aff, dt.dt_id
        FROM demande_travail dt
        INNER JOIN provenance p ON dt.prov_id = p.prov_id
        WHERE dt.dt_aff = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $structure);
$stmt->execute();
$result = $stmt->get_result();

// Check if there are any rows in the result
if ($result->num_rows > 0) {
    // Output data of each row
    while ($row = $result->fetch_assoc()) {
        // Output each row's data in the table
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row["dt_date"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["dt_num"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["dt_code"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["dt_design"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["prov_nom"]) . "</td>";
        echo "<td>" . htmlspecialchars($row["dt_aff"]) . "</td>";
        echo '<td><a href="ot_gest.php?dt_id=' . urlencode($row["dt_id"]) . '&dt_num=' . urlencode($row["dt_num"]) . '">View</a></td>';
        echo '<td><a href="lc_gest.php?dt_id=' . urlencode($row["dt_id"]) . '&dt_num=' . urlencode($row["dt_num"]) . '">View</a></td>';
        echo '<td><a href="ste_gest.php?dt_id=' . urlencode($row["dt_id"]) . '&dt_num=' . urlencode($row["dt_num"]) . '">View</a></td>';
        echo '<td><a href="sti_gest.php?dt_id=' . urlencode($row["dt_id"]) . '&dt_num=' . urlencode($row["dt_num"]) . '">View</a></td>';
        echo "<td><a>view</a></td>";
        echo '<td>
            <img src="imgg/mdi--printer.svg" alt="printer" class="print-icon"> 
            <img src="imgg/mdi--eye.svg" alt="eye">
        </td>';
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='12'>No records found.</td></tr>";
}

$stmt->close();
$conn->close();
?>
