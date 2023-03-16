<?php 
    include('../security_protocols/admin_check_security.php');
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
        <link rel="stylesheet" href="../styles_pages/style_autocomplete.css">
        <script src="../jquery.min.js"></script>
        <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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
        <p class="update-table-container" id="viewClubTable">Loading...Please wait!</p>
    </body>
    <div id="addClubUserModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p>
            <div class="input-form-container">
                <!--<label id="clubName"></label><br>
                <p class="update-table-container" id="viewUserTable"></p>
                <label for="autocomplete">Select a user</label><br>
                <input id="autocomplete"> -->
                <label>Owner</label>
                <select name="isOwner" id="isOwner">
                    <option class="option-text" value='0'>No</option>
                    <option class="option-text" value='1'>Yes</option>
                </select>
                <label>Organiser</label>
                <select name="isOrganiser" id="isOrganiser">
                    <option class="option-text" value='0'>No</option>
                    <option class="option-text" value='1'>Yes</option>
                </select>
                <label>Enter User Name</label>  
                <input type="text" name="autocomplete" id="autocomplete" class="form-control" placeholder="Enter User Name" />  
                <div id="userList"></div>
            </div>
            <button class="update-button" onclick="addClubUser()">Add</button>
            </p>
        </div>
    </div>
</html>

<script>
    let table = "";
    let table2 = "";
    let clubIDaux;
    let setter = false;
    let userName;
    $.post('../tables_gateways/club_add_user_table.php', {}, function(table){
        document.getElementById("viewClubTable").innerHTML = table;
    });

    document.getElementsByClassName("close")[0].onclick = function() {
        document.getElementById("addClubUserModal").style.display = "none";
        setter = false;
    }
    

    //clicks anywhere outside of the modal, close it -> fancy
    window.onclick = function(event) {
        if (event.target == document.getElementById("addClubUserModal")) {
            document.getElementById("addClubUserModal").style.display = "none";
            setter = false;
        }
    }

    function openAddClubUserModal(targetClubID, targetClubName) {
        document.getElementById("addClubUserModal").style.display = "block";
        //document.getElementById("clubName").innerHTML = targetClubName;
        //clubIDaux = targetClubID;
        //setter = true;
        /*let userList = [ "c++", "java", "php", "coldfusion", "javascript", "asp", "ruby" ];
        let userlist;
        $.post('../tables_gateways/user_add_to_club_list.php', {clubID: clubIDaux}, function(userList){
            //alert(userList);
            userlist = userList;
        });
        //let userlist = JSON.stringify(userList);
        //alert(userlist);
        //let list = JSON.parse(userList);
        $( "#autocomplete" ).autocomplete({
           source: userlist
        });
        $( "#autocomplete" ).autocomplete( "option", "appendTo", ".eventInsForm" );
        //$.post('../tables_gateways/user_add_to_club_table.php', {clubID: clubIDaux}, function(table2){
            //document.getElementById("viewUserTable").innerHTML = table2;
        //});*/
        $(document).ready(function(){  
            $('#autocomplete').keyup(function(){  
                var userName = $(this).val();  
                if(userName != '')  {  
                    $.ajax({  
                        url:"../tables_gateways/user_add_to_club_list.php",  
                        method:"POST",  
                        data:{userName:userName, clubID: targetClubID},  
                        success:function(data)  
                        {  
                            $('#userList').fadeIn();  
                            $('#userList').html(data);  
                        }  
                    });  
                }  
            });  
            $(document).on('click', 'li', function(){  
                $('#autocomplete').val($(this).text());  
                $('#userList').fadeOut();
            }); 
            //$( "#autocomplete" ).autocomplete( "option", "appendTo", ".eventInsForm" ); 
        });
        //userName = document.getElementByID("autocomplete").value;
        clubID = targetClubID;
    }

    function addClubUser () {
        userName = document.getElementById('autocomplete').value;
        let isOwner = document.getElementById('isOwner').value;
        let isOrganiser = document.getElementById('isOrganiser').value;
        $.post('../relationship_creation_gateways/user_add_to_club.php', 
            {userName: userName, clubID: clubID, isOwner: isOwner, isOrganiser: isOrganiser}, function(feedback){
            alert( "Response " + feedback);
        });
        //alert(clubID + " " + userName);
        /*$.post('../tables_gateways/user_add_to_club_table.php', {clubID: clubIDaux}, function(table2){
           document.getElementById("viewUserTable").innerHTML = table2;
        });*/
    }

    function removeClubUser (userID, clubID) {
        $.post('../relationship_removal_gateways/user_remove_from_club.php', 
            {userID: userID, clubID: clubID}, function(feedback){
            alert( "Response " + feedback);
        });
        //$.post('../tables_gateways/user_add_to_club_table.php', {clubID: clubIDaux}, function(table2){
            //document.getElementById("viewUserTable").innerHTML = table2;
        //});
    }
    
    setInterval(function() {
        if (setter) {
            //$.post('../tables_gateways/user_add_to_club_table.php', {clubID: clubIDaux}, function(table2){
               // document.getElementById("viewUserTable").innerHTML = table2;
            //});
        } else {
            $.post('../tables_gateways/club_add_user_table.php', {}, function(table){
                document.getElementById("viewClubTable").innerHTML = table;
            });
        }
    }, 2000);
</script>
