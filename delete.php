<?php
 require("dbConnection.php"); 
?>
<html>
    <head>
        <title>Delete Job</title>
        <meta  charset="UTF-8"/>
    </head>
    <body>
        <h1>Delete Job</h1>
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
            
                if (isset($_POST['submit'])) {
                    $submit = $_POST['submit'];
                    if ($submit == "Cancel") {
                        $db->close();
                        header('location: jobs.php');
                        exit;
                    }	
                    //delete job query
                    $query = "DELETE from jobs WHERE id = ?";
						  
				    $stmt = $db->prepare($query);
                   
			    	$stmt->bind_param("i",$jobID);
				    $stmt->execute();				
				
				    $affectedRows = $stmt->affected_rows;
				    $stmt->close();
				    $db->close();
				
				    if ($affectedRows == 1) {
					echo "Successfully Deleted Job<br>";
					echo "<a href=\"jobs.php\">Back to Job List</a>";
					echo "<br><hr>";
					exit;		
				    }
				    else {
					echo "Failed to delete Job<br>";
					echo "<a href=\"jobs.php\">Back to Job List</a>";
					echo "<br><hr>";
					exit;				
				}
                
            }
            else{  //get job details query to preload in the form 
                $queryJobDetails = "SELECT * FROM jobs WHERE id = ?";
				$stmtJobDetails = $db->prepare($queryJobDetails);
				$stmtJobDetails->bind_param("i", $jobID);
				
				$stmtJobDetails->execute();
				$result = $stmtJobDetails->get_result();
				$stmtJobDetails->close();
				
				$row = $result->fetch_assoc();
				
				$name = $row['customer_name'];
				$email = $row['email'];
				$severity = $row['severity'];
                $description = $row['description'];
                if($row['severity']== 1 ){
                    $severity = "High";
                }
                else if($row['severity']== 2 ){
                    $severity = "Medium";
                }  
                else if($row['severity']== 3 ){
                    $severity = "Low";
                } 
        ?>
        <form action="" method="POST"> <!-- Table for job details -->
            <table>
                <tr>
                    <td>Name:</td>
                    <td><?=$name?></td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><?=$email?></td>
                </tr>
                <tr>
                    <td>Severity:</td>
                    <td><?=$severity?></td>
                </tr>
                <tr>
                    <td> Proplem Description:</td>
                    <td><?=$description?></td>
                </tr>
            </table>
            <br>
				<input type="submit" name="submit" value="Delete">
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