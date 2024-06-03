<?php
include 'config.php';
?>
<header>
    <img src="imgg/images.png" alt="Logo" class="logo">
    <div class="profile" onclick="toggleDropdown()">
        <?php echo htmlspecialchars($_SESSION['username']); ?>
        <div class="dropdown-content" id="dropdown">
            <a href="logout.php">Logout</a>
        </div>
    </div>
</header>
<style>
    .profile {
        position: relative;
        display: inline-block;
        cursor: pointer;
    }

    .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f1f1f1;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
    }

    .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
    }

    .dropdown-content a:hover {background-color: #ddd;}
</style>
<script>
    function toggleDropdown() {
        var dropdown = document.getElementById("dropdown");
        dropdown.style.display = dropdown.style.display === "none" ? "block" : "none";
    }
</script>
