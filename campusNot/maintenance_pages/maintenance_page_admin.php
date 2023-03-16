<?php 
    include('../security_protocols/admin_check_security.php');
?>

<html>
    <head>
        <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="../styles_pages/style_home_page_admin.css">
        <link rel="stylesheet" href="../styles_pages/style_input_page.css">
    </head>
    <body>
    <form id="logout-form" action="../logout.php" method="post"></form>
        <ul>
            <img class="logo-img" name="logo_cd1" id="logo_cd1" src="../logo_cd1.jpeg">
            <div class=list-holder>
                <li><a href="../home_pages/home_page_admin.php">Homepage</a></li>
                <li><a class="active" href="maintenance_page_admin.php">Maintenance Page</a></li>
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
        <label>Entity Input Pages</label><br><br><br><br>
                <p><a href="../entity_creation_pages/user_general_input_page.php">Add User</a></p><br>
                <p><a href="../entity_creation_pages/club_general_input_page.php">Add Club</a></p><br>
                <p><a href="../entity_creation_pages/announcement_general_input_page.php">Add Announcement</a></p><br>
                <p><a href="../entity_creation_pages/course_general_input_page.php">Add Course</a></p><br>
                <p><a href="../entity_creation_pages/exam_general_input_page.php">Add Exam</a></p><br>

                <label>Relationship Input Pages</label><br><br><br><br>
                <p><a href="../relationship_creation_pages/club_add_user_page.php">Add user to club</a></p><br>

                <label>Entity Update Pages</label><br><br><br><br>
                <p><a href="../entity_update_pages/admin_basic_general_update_page.php">Update Admin</a></p><br>
                <p><a href="../entity_update_pages/club_details_update_page.php">Update Club</a></p><br>
                
                <label>Relationship Update Pages</label><br><br><br><br>

                <label>View Pages</label><br><br><br><br>
                <p><a href="../view_pages/student_exam_results_view.php">Student Exam Results (no uploaded data to view yet)</a></p><br>
                <p><a href="../view_pages/club_managers_view.php">Club Managers</a></p><br>
                <p><a href="../view_pages/club_organisers_view.php">Club Organisers</a></p><br>
        </div>
    </body>
</html>
