<html>
    <head>
        <title>
            Add Job
        </title>
        <meta  charset="UTF-8"/>
    </head>
    <body>
        <h1>Add Job</h1>
        <?php
        require("dbConnection.php");//add database connection
        //check if there are already variables for $_POST['submit']
        if (isset($_POST['submit'])) {
            $submit = $_POST['submit'];
            if ($submit == "Cancel") {
                $db->close();
                header('location: home.php');
                exit;
            }	
            
            //check if there are already variables for $_POST array
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
            //set variable for array
            $name = $_POST['name'];
			$email = $_POST['email'];
			$severity = $_POST['severity'];
            $description = $_POST['description'];
                //insert query
                $query = "INSERT INTO jobs (customer_name, email, severity, description) VALUES (?, ?, ?, ?)";
				
				$stmt = $db->prepare($query);
				$stmt->bind_param("ssss", $name, $email, $severity, $description);
				$stmt->execute();				
				
				$affectedRows = $stmt->affected_rows;
				$stmt->close();
				$db->close();
				
				if ($affectedRows == 1) {
					echo "Successfully Added Job<br>";
					echo "<a href=\"jobs.php\">Back to Job List</a>";
					echo "<br><hr>";
					exit;		
				}
				else {
					echo "Failed to Add Job<br>";
					echo "<a href=\"jobs.php\">Back to Job List</a>";
					echo "<br><hr>";
					exit;				
				}
			}
        ?>
        <form action="" method="POST"><!-- Creating form table for input -->
            <table>
                <tr>
                    <td>Name:</td>
                    <td><input type="text" name="name"></td>
                </tr>
                <tr>
                    <td>Email:</td>
                    <td><input type="text" name="email"></td>
                </tr>
                <tr>
                    <td>Severity:</td>
                    <td>
                    <select name ="severity">
                        <option value = "1">High</option>
                        <option value = "2">Medium</option>
                        <option value = "3">Low</option>
                    </select>
                    </td>
                </tr>
                <tr>
                    <td> Proplem Description:</td>
                    <td><textarea name="description" id="" cols="50" rows="10"  maxlength="50">
                    </textarea></td>
                </tr>
            </table>
            <br>
				<input type="submit" name="submit" value="Add">
				<input type="submit" name="submit" value="Cancel">
            <?php
            //checking session to display correct footer content
            session_start();
            $valid_Session = require ('checkSession.php');          
            $valid_Login = require ('checkLogin.php');
            if($valid_Login || $valid_Session){//user are logging in
                include ("footer_logged_in.php");
            }
            else{                
                include ("footer_logged_out.php");				              
            }
            ?>
    </body>
</html>