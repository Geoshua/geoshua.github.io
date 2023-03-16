<?php 
    include("../security_protocols/admin_master_control.php");
?>

<html>
    <head>
        <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../styles_pages/style_input_page.css">
        <link rel="stylesheet" href="../styles_pages/style_update_table.css">
        <link rel="stylesheet" href="../styles_pages/style_modal.css">
        <script src="../jquery.min.js"></script>
        <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <link rel="stylesheet" href="../styles_pages/style_autocomplete.css">
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
        <p class="update-table-container" id="updateAdminTable">Loading...Please wait!</p>
    </body>
    <div id="updateAdminModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p>
            <div class="input-form-container">
            <form>
                <div class="form-content">
                    <label id="adminName"></label>
                    <br>
                    <br>
                    <label>Started in</label>
                    <input class="input-text" type="text" id="adminStartYear">
                    <label>Ended In</label>
                    <input class="input-text" type="text" id="adminEndYear">
                    <label>Permissions Code</label>
                    <input type="text" name="adminCode" id="adminCode" class="form-control" placeholder="Enter Permission Code" />
                </div>
            </form>
            <button class="input-button" onclick="updateAdmin()">Upload</button>
        </div>               
            </p>
        </div>
    </div>
</html>

<script>
    $.post('../tables_gateways/admin_basic_general_table.php', {}, function(table){
        document.getElementById("updateAdminTable").innerHTML = table;
    });

    let targetAdminName;
    let targetAdminStartYear;
    let targetAdminEndYear;
    let targetAdminPersissionsCode;
    let userID;
    document.getElementsByClassName("close")[0].onclick = function() {
        document.getElementById("updateAdminModal").style.display = "none";
    }
    //clicks anywhere outside of the modal, close it -> fancy
    window.onclick = function(event) {
        if (event.target == document.getElementById("updateAdminModal")) {
            document.getElementById("updateAdminModal").style.display = "none";
        }
    }

    function openUpdateAdminModal (targetAdminName, targetAdminStartYear, targetAdminEndYear, targetAdminPermissionsCode, targetUserID) {
        $( "#adminCode" ).autocomplete({
            source: ["8383", "6554", "4435", "1125"]
        });
        $( "#adminCode" ).autocomplete( "option", "appendTo", ".eventInsForm" );
        document.getElementById("updateAdminModal").style.display = "block";
        document.getElementById("adminName").innerHTML = targetAdminName;
        document.getElementById("adminStartYear").value = targetAdminStartYear;
        if (targetAdminEndYear == null) {
            document.getElementById("adminEndYear").value = "";
        } else {
            document.getElementById("adminEndYear").value = targetAdminEndYear;
        }
        document.getElementById("adminCode").value = intval(targetAdminPermissionsCode);
        userID = targetUserID;
    }

    function updateAdmin () {
        let adminStartYear = document.getElementById('adminStartYear').value;
        let adminEndYear = document.getElementById('adminEndYear').value;
        let adminPermissionsCode = document.getElementById('adminCode').value;
        $.post('../entity_update_gateways/update_admin_basic_general.php', {userID: userID, adminStartYear: adminStartYear, adminEndYear: adminEndYear, adminPermissionsCode: adminPermissionsCode}, function(feedback){
            alert( "Response " + feedback);
        });
    }

    setInterval(function() {
        $.post('../tables_gateways/admin_basic_general_table.php', {}, function(table){
            document.getElementById("updateAdminTable").innerHTML = table;
        });
    }, 2000);
   
</script>
