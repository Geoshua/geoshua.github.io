<?php 
    include("../security_protocols/admin_check_security.php");
    if($_SESSION["permissionsCode"] != 6554 && $_SESSION["permissionsCode"] != 8383) {
        header("Location: ../index.html");
    }
?>

<html>
    <head>
        <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../styles_pages/style_input_page.css">
        <link rel="stylesheet" href="../styles_pages/style_modal.css">
        <script src="../jquery.min.js"></script>
    </head>
    <body>
        <form id="logout-form" action="../logout.php" method="post"></form>
        <ul>
            <img class="logo-img" name="logo_cd1" id="logo_cd1" src="../logo_cd1.jpeg">
            <div class=list-holder>
                <li><a href="../home_pages/home_page_admin.php">Homepage</a></li>
                <li><a class="active" href="../maintenance_pages/maintenance_page_admin.php">Maintenance Page</a></li>
                <li><a href="../entity_creation_pages/announcement_general_input_page.php">Make an announcement</a></li>
                <li><a href="#placeholder3">Placeholder3</a></li>
                <hr>
                <li><a href="#placeholder4">Placeholder4</a></li>
                <li><a href="#placeholder5">Placeholder5</a></li>
                <li><a href="#placeholder6">Placeholder6</a></li>
                <hr>
                <li><a href="#placeholder7">Placeholder7</a></li>
                <li><a href="#placeholder8">Placeholder8</a></li>
                <li><a href="#placeholder9">Placeholder9</a></li>
            </div>  
        </ul>
        <div class="top-bars">
            <div class="top-section-one">
                <?php echo $_SESSION['userName']?>
                <a href="../imprint.html" target="_blank">Imprint</a>
                <button form="logout-form" type="submit" class="logout-button">Log out</button>
            </div>
            <div class="top-section-two">
                <div class="top-section-two-content">
                    Placeholder1 &nbsp; Placeholder2 &nbsp; Placeholder3
                </div>
                <div class="search-container">
                    <form>
                        <input type="text" placeholder="Search.." name="search">
                        <button onclick="alert('Will be implemented later...')">GO</button>
                    </form>
                </div>
            </div>  
        </div>
        <div class="input-form-container">
            <button class="back-button" onclick="location.href='../maintenance_pages/maintenance_page_admin.php'">Back</button>
            <form>
                <div class="form-content">
                    <label>Club Name</label>
                    <input class="input-text" type="text" id="clubName" name="clubName" placeholder="Computer Science Club" required>
                </div>
            </form>
            <button class="input-button" onclick="uploadClubGeneral()">Upload</button>
        </div>
    </body>
    
</html>

<script>
    function uploadClubGeneral () {
        let clubName = document.getElementById('clubName').value;
        if (clubName.length < 4) {
            alert("Must provide a relevant name!");
            return false;
        }
        $.post('../entity_creation_gateways/club_general_input.php', {clubName: clubName}, function(feedback){
            alert( "Response " + feedback);
        });
    }
</script>
