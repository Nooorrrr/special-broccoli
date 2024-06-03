<?php
include 'config.php';

$dt_id = intval($_GET['dt_id']);

// Step 5: Check if there is a Fiche_couts entry for the given dt_id
$sql_fiche_check = "SELECT COUNT(*) as count FROM Fiche_couts WHERE dt_id = ?";
$stmt_fiche_check = $conn->prepare($sql_fiche_check);
$stmt_fiche_check->bind_param("i", $dt_id);
$stmt_fiche_check->execute();
$result_fiche_check = $stmt_fiche_check->get_result();
$row_fiche_check = $result_fiche_check->fetch_assoc();

if ($row_fiche_check['count'] == 0) {
    echo "No Fiche_couts entry found for Demande de Travail ID: $dt_id";
    exit();
}

// Step 1: Calculate total cost for Liste Consommations
$sql_consommation = "SELECT SUM(c.c_pu * c.c_qte) AS total_consommation
                     FROM Consommation c
                     INNER JOIN Liste_consommations lc ON c.lc_id = lc.lc_id
                     WHERE lc.dt_id = ?";
$stmt_consommation = $conn->prepare($sql_consommation);
$stmt_consommation->bind_param("i", $dt_id);
$stmt_consommation->execute();
$result_consommation = $stmt_consommation->get_result();
$total_consommation = $result_consommation->fetch_assoc()['total_consommation'] ?? 0;

// Step 2: Calculate total cost for Sous Traitance Interne
$sql_sti = "SELECT SUM(sti.sti_prix * sti.sti_qte) AS total_sti
            FROM Sous_traitance_interne sti
            WHERE sti.dt_id = ?";
$stmt_sti = $conn->prepare($sql_sti);
$stmt_sti->bind_param("i", $dt_id);
$stmt_sti->execute();
$result_sti = $stmt_sti->get_result();
$total_sti = $result_sti->fetch_assoc()['total_sti'] ?? 0;

// Step 3: Calculate total cost for Sous Traitance Externe
$sql_ste = "SELECT SUM(ste.ste_prix * ste.ste_qte) AS total_ste
            FROM Sous_traitance_externe ste
            WHERE ste.dt_id = ?";
$stmt_ste = $conn->prepare($sql_ste);
$stmt_ste->bind_param("i", $dt_id);
$stmt_ste->execute();
$result_ste = $stmt_ste->get_result();
$total_ste = $result_ste->fetch_assoc()['total_ste'] ?? 0;

// Step 4: Calculate total cost for Travail Effectués
$fixed_rate = 500.00;
$sql_travail = "SELECT SUM(te.tr_hr) AS total_hours
                FROM Travail_effectué te
                INNER JOIN Ordre_travail ot ON te.ot_id = ot.ot_id
                WHERE ot.dt_id = ?";
$stmt_travail = $conn->prepare($sql_travail);
$stmt_travail->bind_param("i", $dt_id);
$stmt_travail->execute();
$result_travail = $stmt_travail->get_result();
$total_hours = $result_travail->fetch_assoc()['total_hours'] ?? 0;
$total_travail = $total_hours * $fixed_rate;

// Step 5: Fetch other costs and details from Fiche_couts
$sql_fiche = "SELECT f_num, f_date, f_mtp, f_maux, f_bv, f_cf, f_tol, f_elec, f_cons, f_hyd, f_eqaux, f_mat, f_pneu, f_tc
              FROM Fiche_couts
              WHERE dt_id = ?";
$stmt_fiche = $conn->prepare($sql_fiche);
$stmt_fiche->bind_param("i", $dt_id);
$stmt_fiche->execute();
$result_fiche = $stmt_fiche->get_result();
$total_fiche = 0;
$f_num = '';
$f_date = '';

if ($row_fiche = $result_fiche->fetch_assoc()) {
    $total_fiche = array_sum(array_slice($row_fiche, 2)); // Summing cost columns
    $f_num = $row_fiche['f_num'];
    $f_date = $row_fiche['f_date'];
}

// Calculate the grand total
$grand_total = $total_consommation + $total_sti + $total_ste + $total_travail + $total_fiche;

// Display the total cost
//echo "<h2>Total Cost: " . number_format($grand_total, 2) . "</h2>";

// Display the result in a table
echo "  <tr>
            <td>{$f_num}</td>
            <td>{$f_date}</td>
            <td>" . number_format($grand_total, 2) . "</td>
            <td>
           <img src='imgg/mdi--trash.svg' alt='trash' class='trash-icon'> 
            <img src='imgg/mdi--printer.svg' alt='printer' class='print-icon'> 
            <img src='imgg/mdi--eye.svg' alt='eye'>
            <img src='imgg/mdi--pencil.svg' alt='pencil'> 
            </td>
        </tr>";

$stmt_consommation->close();
$stmt_sti->close();
$stmt_ste->close();
$stmt_travail->close(); 
$stmt_fiche->close();
$stmt_fiche_check->close();
$conn->close();
?>