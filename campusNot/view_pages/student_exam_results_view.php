<?php 
    include("../security_protocols/admin_check_security.php");
    if($_SESSION["permissionsCode"] != 1125 && $_SESSION["permissionsCode"] != 8383) {
        header("Location: ../index.html");
    }
?>

<html>
    <head>
        <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../styles_pages/style_input_page.css">
        <link rel="stylesheet" href="../styles_pages/style_update_table.css">
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
                <a href="imprint.html" target="_blank">Imprint</a>
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
        <p class="update-table-container" id="studentExamResultsTable">Loading...Please wait!</p>
    </body>
    <div id="filtersModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p>
            <div class="input-form-container">
            <form>
                <div class="form-content">
                    <label>Adjust Filters here</label>
                    <br>
                    <br>
                    <label>Minimum Grade</label>
                    <input class="input-text" type="number" step="0.01" id="minGrade" default="0">
                    <label>Maximum Grade</label>
                    <input class="input-text" type="number" step="0.01" id="maxGrade" default="100">
                    <label for="gradeType">Grade Type</label>
                    <select id="gradeType">
                        <option class="option-text" value='A' default>All</option>
                        <option class="option-text" value='P'>Passing</option>
                        <option class="option-text" value='F'>Failing</option>
                    </select>
                    <label for="orderBy">Order by</label>
                    <select id="orderBy">
                    <option class="option-text" value='G' default>Exam Grade</option>
                        <option class="option-text" value='S'>Student Name</option>
                        <option class="option-text" value='E'>Exam Name</option>
                    </select>
                </div>
            </form>
            <button class="input-button" onclick="applyFilter()">Apply Filter</button>
            </div>               
            </p>
        </div>
    </div>
    <div id="userModal" class="modal">
        <div class="modal-content">
            <span class="close1">&times;</span>
            <p id="userDetail"></p>
        </div>
    </div>
    <div id="examModal" class="modal">
        <div class="modal-content">
            <span class="close2">&times;</span>
            <p id="examDetail"></p>
        </div>
    </div>
</html>

<script>
    let minGrade = document.getElementById('minGrade').value;
    let maxGrade = document.getElementById('maxGrade').value;
    let gradeType = document.getElementById('gradeType').value;
    let orderBy = document.getElementById('orderBy').value;
    $.post('../tables_gateways/student_exam_results_table.php', {minGrade: minGrade, maxGrade: maxGrade, gradeType: gradeType, orderBy: orderBy}, function(table){
        document.getElementById("studentExamResultsTable").innerHTML = table;
    });

    
    document.getElementsByClassName("close")[0].onclick = function() {
        document.getElementById("filtersModal").style.display = "none";
    }
    document.getElementsByClassName("close1")[0].onclick = function() {
        document.getElementById("userModal").style.display = "none";
    }
    document.getElementsByClassName("close2")[0].onclick = function() {
        document.getElementById("examModal").style.display = "none";
    }
    //clicks anywhere outside of the modal, close it -> fancy
    window.onclick = function(event) {
        if (event.target == document.getElementById("filtersModal")) {
            document.getElementById("filtersModal").style.display = "none";
        }
        if (event.target == document.getElementById("userModal")) {
            document.getElementById("userModal").style.display = "none";
        }
        if (event.target == document.getElementById("examModal")) {
            document.getElementById("examModal").style.display = "none";
        }
    }

    function openFilterModal () {
        document.getElementById("filtersModal").style.display = "block";
    }

    function applyFilter () {
        document.getElementById("filtersModal").style.display = "none";
        minGrade = document.getElementById('minGrade').value;
        maxGrade = document.getElementById('maxGrade').value;
        gradeType = document.getElementById('gradeType').value;
        orderBy = document.getElementById('orderBy').value;
        $.post('../tables_gateways/student_exam_results_table.php', {minGrade: minGrade, maxGrade: maxGrade, gradeType: gradeType, orderBy: orderBy}, function(table){
            document.getElementById("studentExamResultsTable").innerHTML = table;
        });
    }

    function openStudentDetailsModal (targetUser) {
        document.getElementById("filtersModal").style.display = "block";
        $.post('../view/student_detail_view.php', {userID: targetUser}, function(detail){
            document.getElementById("userDetail").innerHTML = detail;
        });
    }

    function openExamDetailsModal (targetExam) {
        document.getElementById("filtersModal").style.display = "block";
        $.post('../view/exam_detail_view.php', {examID: targetExam}, function(detail){
            document.getElementById("examDetail").innerHTML = detail;
        });
    }

    setInterval(function() {
        $.post('../tables_gateways/student_exam_results_table.php', {minGrade: minGrade, maxGrade: maxGrade, gradeType: gradeType, orderBy: orderBy}, function(table){
            document.getElementById("studentExamResultsTable").innerHTML = table;
        });
    }, 2000);
   
</script>
