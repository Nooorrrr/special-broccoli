<?php
include 'config.php';

// Query to fetch data from the database
$sql = "SELECT dt.dt_date, dt.dt_num, dt.dt_code, dt.dt_design, p.prov_nom, dt.dt_aff, dt.dt_id
FROM demande_travail dt
INNER JOIN provenance p ON dt.prov_id = p.prov_id";

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
        echo '<td><a href="ot_respTGM.php?dt_id=' . $row["dt_id"] . '&dt_num=' . $row["dt_num"] . '">View</a></td>';
        echo '<td><a href="lc_respTGM.php?dt_id=' . $row["dt_id"] . '&dt_num=' . $row["dt_num"] . '">View</a></td>';
        echo '<td><a href="ste_respTGM.php?dt_id=' . $row["dt_id"] . '&dt_num=' . $row["dt_num"] . '">View</a></td>';
        echo '<td><a href="sti_respTGM.php?dt_id=' . $row["dt_id"] . '&dt_num=' . $row["dt_num"] . '">View</a></td>';
        echo '<td><a href="fc_respTGM.php?dt_id=' . $row["dt_id"] . '&dt_num=' . $row["dt_num"] . '">View</a></td>';
        echo '<td>
        <img src="imgg/mdi--trash.svg" alt="trash" class="trash-icon" data-id="' . $row["dt_id"] . '"> 
            <img src="imgg/mdi--printer.svg" alt="printer" class="print-icon"> 
            <a href="view_dt.php?dt_id=' . $row["dt_id"] . '">
            <img src="imgg/mdi--eye.svg" alt="eye">
        </a>
            <img src="imgg/mdi--pencil.svg" alt="pencil" class="edit-icon" data-id="' . $row["dt_id"] . '"> 
        </td>';
        echo "</tr>";
    }
} 
$conn->close();
?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var trashIcons = document.querySelectorAll('.trash-icon');

    trashIcons.forEach(function(icon) {
        icon.addEventListener('click', function() {
            var dt_id = this.getAttribute('data-id');
            if (confirm('Are you sure you want to delete this record?')) {
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'delete_dt.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        if (xhr.responseText == 'success') {
                            alert('Record deleted successfully');
                            location.reload();
                        } else {
                            alert('Error deleting record: ' + xhr.responseText);
                        }
                    }
                };
                xhr.send('dt_id=' + dt_id);
            }
        });
    });
});
</script>

<script>
        document.addEventListener('DOMContentLoaded', function() {
            var trashIcons = document.querySelectorAll('.trash-icon');
            var editIcons = document.querySelectorAll('.edit-icon');

            trashIcons.forEach(function(icon) {
                icon.addEventListener('click', function() {
                    var dt_id = this.getAttribute('data-id');
                    if (confirm('Are you sure you want to delete this record?')) {
                        var xhr = new XMLHttpRequest();
                        xhr.open('POST', 'delete_dt.php', true);
                        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                        xhr.onreadystatechange = function() {
                            if (xhr.readyState == 4 && xhr.status == 200) {
                                if (xhr.responseText == 'success') {
                                    alert('Record deleted successfully');
                                    // Remove the row from the table
                                    var row = icon.closest('tr');
                                    row.parentNode.removeChild(row);
                                } else {
                                    alert('Error deleting record: ' + xhr.responseText);
                                }
                            }
                        };
                        xhr.send('dt_id=' + dt_id);
                    }
                });
            });

            editIcons.forEach(function(icon) {
                icon.addEventListener('click', function() {
                    var dt_id = this.getAttribute('data-id');
                    window.location.href = 'edit_dt.php?dt_id=' + dt_id;
                });
            });
        });
    </script>