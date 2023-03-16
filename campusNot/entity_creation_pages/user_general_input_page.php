<?php 
    include("../security_protocols/admin_master_control.php");
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
                <li><a class="active" href="../home_pages/home_page_admin.php">Homepage</a></li>
                <li><a href="../maintenance_pages/maintenance_page_admin.php">Maintenance Page</a></li>
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
            <form id="userGeneralInputForm" name="userGeneralInputForm">
                <div class="form-content">
                    <label>First Name</label>
                    <input class="input-text" type="text" id="firstName" name="firstName" placeholder="William" required>
                    <label>Last Name</label>
                    <input class="input-text" type="text" id="lastName" name="lastName" placeholder="Blake" required>
                    <label>Middle Name</label>
                    <input class="input-text" type="text" id="middleName" name="middleName" placeholder="Emerson">
                    <label>Choose a user type: </label>
                    <select name="userType" id="userType">
                        <option class="option-text" value='S'>Student</option>
                        <option class="option-text" value='P'>Professor</option>
                        <option class="option-text" value='A'>Admin</option>
                    </select>
                </div>
            </form>
            <button class="input-button" onclick="uploadUserGeneral()">Upload</button>
        </div>
    </body>
</html>

<script>
    function uploadUserGeneral () {
        let firstName = document.getElementById('firstName').value;
        let middleName = document.getElementById('middleName').value;
        let lastName = document.getElementById('lastName').value;
        if (firstName == "" || lastName == "") {
            alert("Must provide a complete name!");
            return false;
        }
        let userType =  document.getElementById('userType').value;
        $.post('../entity_creation_gateways/user_general_input.php', {firstName: firstName, userType: userType, lastName: lastName, middleName: middleName }, function(feedback){
            alert( "Response " + feedback);
        });
    }
</script>
