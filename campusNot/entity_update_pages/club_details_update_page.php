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
        <link rel="stylesheet" href="../styles_pages/style_update_table.css">
        <script src="../jquery.min.js"></script>
    </head>
    <body>
        <form id="logout-form" action="../logout.php" method="post"></form>
        <ul>
            <img class="logo-img" name="logo_cd1" id="logo_cd1" src="../logo_cd1.jpeg">
            <div class=list-holder>
                <li><a href="../home_pages/home_page_admin.php">Homepage</a></li>
                <li><a class="active" href="../maintenance_pages/maintenance_page_admin.php">Maintenance Page</a></li>
                <li><a href="#placeholder2">Placeholder2</a></li>
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
        <p class="update-table-container" id="updateClubTable">Loading...Please wait!</p>
    </body>
    <div id="updateClubModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p>
            <div class="input-form-container">
                <form>
                    <div class="form-content">
                        <label id="clubName"></label>
                        <br>
                        <br>
                        <label>Funding</label>
                        <input class="input-text" type="text" id="clubFunding">
                        <label>Max Students</label>
                        <input class="input-text" type="text" id="clubMaxStudents">
                        <label>Max Professors</label>
                        <input class="input-text" type="text" id="clubMaxProfessors">
                        <label>Location</label>
                        <input class="input-text" type="text" id="clubLocation">
                        <label>Description</label>
                        <input class="input-text" type="text-area" id="clubDescription">
                        <label>Mentions</label>
                        <input class="input-text" type="text-area" id="clubMentions">
                    </div>
                </form>
            <button class="input-button" onclick="updateClub()">Update</button>
            </div>               
            </p>
        </div>
    </div>
    <div id="clubDescriptionModal" class="modal">
        <div class="modal-content">
            <span class="close1">&times;</span>
                <div class="input-form-container">
                    <label style="font-size: 2vw"><div id="clubDescriptionModalContent"></div></label>
                </div>
        </div>
    </div>
    <div id="clubMentionsModal" class="modal">
        <div class="modal-content">
            <span class="close2">&times;</span>
            <div class="input-form-container">
                <label style="font-size: 2vw"><div id="clubMentionsModalContent"></div></label>
            </div>
        </div>
    </div>
</html>

<script>
    let table = "";
    $.post('../tables_gateways/club_details_table.php', {}, function(table){
        document.getElementById("updateClubTable").innerHTML = table;
    });

    let targetClubName;
    let targetClubFunding;
    let targetClubMaxS;
    let targetClubMaxP;
    let targetClubLocation;
    let targetClubDescription;
    let targetClubMentions;
    let clubID;
    document.getElementsByClassName("close")[0].onclick = function() {
        document.getElementById("updateClubModal").style.display = "none";
    }
    document.getElementsByClassName("close1")[0].onclick = function() {
        document.getElementById("clubDescriptionModal").style.display = "none";
    }
    document.getElementsByClassName("close2")[0].onclick = function() {
        document.getElementById("clubMentionsModal").style.display = "none";
    }
    //clicks anywhere outside of the modal, close it -> fancy
    window.onclick = function(event) {
        if (event.target == document.getElementById("updateClubModal")) {
            document.getElementById("updateClubModal").style.display = "none";
        }
        if (event.target == document.getElementById("clubDescriptionModal")) {
            document.getElementById("clubDescriptionModal").style.display = "none";
        }
        if (event.target == document.getElementById("clubMentionsModal")) {
            document.getElementById("clubMentionsModal").style.display = "none";
        }
    }

    function openUpdateClubModal (targetClubName, targetClubFunding, targetClubMaxS, targetClubMaxP, targetClubLocation, targetClubDescription, targetClubMentions, targetClubID) {
        document.getElementById("updateClubModal").style.display = "block";
        document.getElementById("clubName").innerHTML = targetClubName;
        document.getElementById("clubFunding").value = targetClubFunding;
        document.getElementById("clubMaxStudents").value = targetClubMaxS;
        document.getElementById("clubMaxProfessors").value = targetClubMaxP;
        document.getElementById("clubLocation").value = targetClubLocation;
        document.getElementById("clubDescription").value = targetClubDescription;
        document.getElementById("clubMentions").value = targetClubMentions;
        clubID = targetClubID;
    }

    function openClubDescriptionModal (ClubDescription) {
        document.getElementById("clubDescriptionModal").style.display = "block"
        document.getElementById("clubDescriptionModalContent").innerHTML = ClubDescription;
    }

    function openClubMentionsModal (ClubMentions) {
        document.getElementById("clubMentionsModal").style.display = "block";
        document.getElementById("clubMentionsModalContent").innerHTML = ClubMentions;
    }

    /*function openClubUsersModal (targetClubID) {
        clubID = targetClubID;
        document.getElementById("clubUsersModal").style.display = "block";
        setter = false;
        $.post('../tables_gateways/club_details_table.php', {clubID: clubID}, function(tableMembers){
            document.getElementById("clubUsersContent").innerHTML = tableMembers;
        });
        setInterval(function(clubID) {
            if (setter = false) {
                $.post('../tables_gateways/club_details_table.php', {clubID: clubID}, function(tableMembers){
                    document.getElementById("clubUsersContent").innerHTML = tableMembers;
                });
            }
        }, 2000);
    } */

    function updateClub () {
        let clubFunding = document.getElementById("clubFunding").value;
        let clubMaxStudents = document.getElementById("clubMaxStudents").value;
        let clubMaxProfessors = document.getElementById("clubMaxProfessors").value;
        let clubLocation = document.getElementById("clubLocation").value;
        let clubDescription = document.getElementById("clubDescription").value;
        let clubMentions = document.getElementById("clubMentions").value;
        $.post('../entity_update_gateways/club_details_update.php', {clubID: clubID, clubFunding: clubFunding, clubMaxStudents: clubMaxStudents, clubMaxProfessors: clubMaxProfessors, clubLocation: clubLocation, clubDescription: clubDescription, clubMentions: clubMentions}, function(feedback){
            alert( "Response " + feedback);
        });
    }

    setInterval(function() {
        $.post('../tables_gateways/club_details_table.php', {}, function(table){
            document.getElementById("updateClubTable").innerHTML = table;
        });
    }, 2000);

   
</script>s
