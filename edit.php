<?php
 require("dbConnection.php"); 
?>
<html>
    <head>
        <title>Edit Job</title>
        <meta  charset="UTF-8"/>
    </head>
    <body>
        <h1>Edit Job</h1>
        <?php
        //checking session to protect the page from unloggedin user
        session_start();
        if (!isset($_SESSION['valid_user'])){         
                echo ("You are not logged in, please login to perform this action");	       
                include ("footer_logged_out.php");	
               		              
        }
        else{
            //check if id is store in the method
            if (!isset($_GET['id']) || empty($_GET['id'])) {
				echo "Error: job id not supplied.";
				$db->close();
				exit;
			}
			$jobID = $_GET['id'];	
            
                //check if Post array empty 
                if (isset($_POST['submit'])) {
                    $submit = $_POST['submit'];
                    if ($submit == "Cancel") {
                        $db->close();
                        header('location: jobs.php');
                        exit;
                    }	
                    
                
                    if (!isset($_POST['name']) || empty($_POST['name'])) {
                        echo "Error: Name not supplied.";
                        $db->close();
                        exit;
                    }
                    if (!isset($_POST['email']) || empty($_POST['email'])) {
                        echo "Error: Email not supplied.";
                        $db->close();
                        exit;
                    }
                    if (!isset($_POST['severity']) || empty($_POST['severity'])) {
                        echo "Error: Severity not supplied.";
                        $db->close();
                        exit;
                    }
                    if (!isset($_POST['description']) || empty($_POST['description'])) {
                        echo "Error: Description not supplied.";
                        $db->close();
                        exit;
                    }
        
                    $name = $_POST['name'];
                    $email = $_POST['email'];
                    $severity = $_POST['severity'];
                    $description = $_POST['description'];
                    
                    //edit query
                    $query = "UPDATE jobs 
						  SET customer_name=?, email=?, severity=?, description =? 
						  WHERE id = ?";
						  
				    $stmt = $db->prepare($query);
                   
			    	$stmt->bind_param("ssssi", $name, $email, $severity, $description, $jobID);
				    $stmt->execute();				
				
				    $affectedRows = $stmt->affected_rows;
				    $stmt->close();
				    $db->close();
				
				    if ($affectedRows == 1) {
					echo "Successfully Updated Job<br>";
					echo "<a href=\"jobs.php\">Back to Job List</a>";
					echo "<br><hr>";
					exit;		
				    }
				    else {
					echo "Failed to Update Job<br>";
					echo "<a href=\"jobs.php\">Back to Job List</a>";
					echo "<br><hr>";
					exit;				
				}
                
            }
            else{
                //get job details query to preload in the form 
                $queryJobDetails = "SELECT * FROM jobs WHERE id = ?";
				$stmtJobDetails = $db->prepare($queryJobDetails);
				$stmtJobDetails->bind_param("i", $jobID);
				
				$stmtJobDetails->execute();
				$result = $stmtJobDetails->get_result();
				$stmtJobDetails->close();
				
				$row = $result->fetch_assoc();
				
				$name = $row['customer_name'];
				$email = $row['email'];
                $description = $row['description'];   
                $severity = $row['severity'];
                
        ?>
        <form action="" method="POST"> <!-- Creating form table to preload job's detail and get user input  -->
            <table>
                <tr>
                    <td>Name:</td>
                    <td><input type="text" name="name" value = "<?=$name?>"></td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><input type="text" name="email" value = "<?=$email?>"></td>
                </tr>
                <tr>
                    <td>Severity:</td>
                    <td>
                    <select name ="severity">
                        <option value = "1" <?php if ($severity == 1) {echo 'selected="selected"';}?>>High</option>
                        <option value = "2" <?php if ($severity == 2) {echo 'selected="selected"';}?>>Medium</option>
                        <option value = "3" <?php if ($severity == 3) {echo 'selected="selected"';}?>>Low</option>
                        
                    </select>
                    </td>
                </tr>
                <tr>
                    <td> Proplem Description:</td>
                    <td><textarea name="description" cols="50" rows="10"  maxlength="50"><?=$description?></textarea></td>
                </tr>
            </table>
            <br>
				<input type="submit" name="submit" value="Update">
				<input type="submit" name="submit" value="Cancel">
        <?php 
        	$result->free();    
        }
            $db->close();
            include ("footer_logged_in.php");
        }
        ?>
    </body>
</html>