<html>
<head>
	<meta charset="utf-8">
	<title>Login</title>
</head>
<body>
    <?php
        require("dbConnection.php");
        //login form
        echo <<<END
        <h1>Login</h1>
        <form action="checkLogin.php" method="post">
        <p>Username: <input type="text" name="name"></p>
        <p>Password: <input type="password" name="password"></p>
        <p><input type="submit" name="submit" value="Log In"></p>
        </form>
        END;
        include("footer_logged_out.php");
    ?>

    
</body>
</html>