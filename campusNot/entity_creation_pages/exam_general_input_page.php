<?php 
    include('../security_protocols/admin_check_security.php');
    if($_SESSION["permissionsCode"] != 4435 && $_SESSION["permissionsCode"] != 8383) {
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
        <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
        <link rel="stylesheet" href="../styles_pages/style_autocomplete.css">
    </head>
    <body>
        <form id="logout-form" action="../logout.php" method="post"></form>
        <ul>
            <img class="logo-img" name="logo_cd1" id="logo_cd1" src="../logo_cd1.jpeg">
            <div class=list-holder>
                <li><a class="active" href="../home_pages/home_page_admin.php">Homepage</a></li>
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
        <p class="update-table-container" id="viewCourseTable">Loading...Please wait!</p>
    </body>
    <div id="addExamModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p>
            <div class="input-form-container">
                <form>
                    <div class="form-content">
                        <label id="courseName"></label>
                        <br>
                        <br>
                        <label>Exam Name</label>
                        <input class="input-text" type="text" id="examName">
                        <label>Attempt</label>
                        <input class="input-text" type="number" step="1.0" id="examAttempt">
                        <label>Date</label>
                        <input class="input-text" type="date" id="examDate">
                        <label>Start Time</label>
                        <input class="input-text" type="time" id="examTimeStart">
                        <label>End Time</label>
                        <input class="input-text" type="time" id="examTimeEnd">
                        <label>Location</label>
                        <br>
                        <input type="text" id="examLocation" class="form-control" placeholder="Enter Location"/>
                        <br>
                        <div id="locationList"></div>
                        <label>Mentions</label>
                        <input class="input-text" type="text" id="examMentions">
                    </div>
                </form>
            <button class="input-button" onclick="uploadExam()">Upload</button>
            </div>               
            </p>
        </div>
    </div>
</html>

<script>
    let table = "";
    let courseIDaux;
    $.post('../tables_gateways/course_add_exam_table.php', {}, function(table){
        document.getElementById("viewCourseTable").innerHTML = table;
    });

    document.getElementsByClassName("close")[0].onclick = function() {
        document.getElementById("addExamModal").style.display = "none";
    }
    

    //clicks anywhere outside of the modal, close it -> fancy
    window.onclick = function(event) {
        if (event.target == document.getElementById("addExamModal")) {
            document.getElementById("addExamModal").style.display = "none";
        }
    }

    function openAddExamModal(targetCourseName, targetCourseID) {
        let examLocation = document.getElementById("examLocation").value;
        $(document).ready(function(){  
            $('#examLocation').keyup(function(){  
                var examLocation = $(this).val();  
                if(examLocation != '')  {  
                    $.ajax({  
                        url:"../view/exam_location_view.php",  
                        method:"POST",  
                        data:{examLocation: examLocation},  
                        success:function(data)  
                        {  
                            $('#locationList').fadeIn();  
                            $('#locationList').html(data);  
                        }  
                    });  
                }  
            });  
            $(document).on('click', 'li', function(){  
                $('#examLocation').val($(this).text());  
                $('#locationList').fadeOut();
            });  
        });
        document.getElementById("addExamModal").style.display = "block";
        document.getElementById("courseName").innerHTML = targetCourseName;
        courseIDaux = targetCourseID;
    }
    function uploadExam () {
        let examName = document.getElementById('examName').value;
        let courseID = courseIDaux;
        let examAttempt = document.getElementById('examAttempt').value;
        let examDate = document.getElementById('examDate').value;
        let examTimeStart = document.getElementById('examTimeStart').value;
        let examTimeEnd = document.getElementById('examTimeEnd').value;
        let examMentions = document.getElementById('examMentions').value;
        let examLocation = document.getElementById('examLocation').value;
        if (examName == "") {
            alert("Must provide a name!");
            return false;
        }
        $.post('../entity_creation_gateways/exam_general_input.php', 
            {examName: examName, courseID: courseID, examAttempt: examAttempt, examDate: examDate, 
            examTimeStart: examTimeStart, examTimeEnd: examTimeEnd, examMentions: examMentions, examLocation: examLocation}, function(feedback){
            alert( "Response " + feedback);
        });
    }

    setInterval(function() {
        $.post('../tables_gateways/course_add_exam_table.php', {}, function(table){
            document.getElementById("viewCourseTable").innerHTML = table;
        });
    }, 2000);
</script>
