<?php
    
    //check if name and password have been set in the $_POST array
    if (isset($_POST['name']) || isset($_POST['password'])){
    if (!isset($_POST['name']) || empty($_POST['name'])) {
        echo "Name not supplied_check login";
	    return false;
    }
    if (!isset($_POST['password']) || empty($_POST['password'])) {
        echo "Password not supplied_check login";
	    return false;
    }

    
    require('dbConnection.php');
    //get the name and password values from $_POST and store them in variables $name and $password
    $name = $_POST['name'];
    $password = $_POST['password'];
    //check login query and return count value 
    $loginQuery = "SELECT count(*) FROM authorized_users WHERE username=? AND password = sha1(?)";
    //prepare query
    $stmt = $db->prepare($loginQuery);
	$stmt->bind_param("ss", $name, $password); //set input value for query
	$stmt->execute();

    $result = $stmt->get_result();
    $stmt->close();

    if (!$result) {
        $db->close();
        exit;
    }
    
    //retrieve first row
    $row = $result->fetch_row();
    //check if the count value is greater than 0
    if ($row[0] > 0) {//user exists in the database, logged in  
        session_start();     
        $_SESSION['valid_user'] = $name;
        header ('Location: home.php?name='.$_SESSION['valid_user']);
        $db->close();
        
        return true;
    }
    else {//not found user
        
        $db->close();
        header ('Location: home.php');
        return false;
    }
}
return false;
    
?>