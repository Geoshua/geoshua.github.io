<?php 
    include("../security_protocols/user_check_security.php");
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
                <?php if($_SESSION['userType'] == 'A') {
                    echo '<li><a class="active" href="../maintenance_pages/maintenance_page_admin.php">Maintenance Page</a></li>';
                }
                ?>
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
            <form>
                <div class="form-content">
                    <label>Announcement</label>
                    <input class="input-text" type="textarea" id="announceDescription" name="announceDescription" placeholder="I would like to ask..." required>
                    <label>Importance</label>
                    <input class="input-text" type="number" id="announceRank" name="announceRank" value="0" placeholder="0" required>
                    <label>For above value: Students can have maximum 2.<br>
                        Professors can go up to 8. <br>
                        Admins can go up to 30 depending on permissions. <br> 
                        Please try to sick to the following rule (for students): <br>
                        0 - selling/buying stuff <br>
                        1 - club/events invitations <br>
                        2 - lost objects (campus card), urgent requests <br>
                    </label>
                </div>
            </form>
            <button class="input-button" onclick="uploadAnnouncementGeneral()">Post</button>
        </div>
    </body>
    
</html>

<script>
    function uploadAnnouncementGeneral () {
        let announceDescription = document.getElementById('announceDescription').value;
        let announceRank = document.getElementById('announceRank').value;
        if (announceDescription.length < 10) {
            alert("Please provide a relevant description!");
            return false;
        }
        if (announceRank == "" || announceRank < 0) {
            alert("Must provide a rank!");
            return false;
        }
        $.post('../entity_creation_gateways/announcement_general_input.php', {announceDescription: announceDescription, announceRank: announceRank}, function(feedback){
            alert( "Response " + feedback);
        });
    }
</script>
