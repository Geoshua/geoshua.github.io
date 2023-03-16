<?php
    include("../db.php");
    $connect = mysqli_connect($host, $user, $pass, $db);    
    if(isset($_POST["examLocation"]))  {  
        $output = '';  
        $query = "SELECT * FROM exam_details WHERE examLocation LIKE '%".$_POST["examLocation"]."%'";  
        $result = mysqli_query($connect, $query);  
        $output = '<ul class="list-unstyled">';  
        if(mysqli_num_rows($result) > 0)  {  
            while($row = mysqli_fetch_array($result))  {  
                    $output .= '<li>'.$row["examLocation"].'</li>';  
            }  
        }  
        else  {  
            $output .= '<li>Location Not Found</li>';  
        }  
        $output .= '</ul>';  
        echo $output;  
    }  
?>