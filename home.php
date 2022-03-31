<html>
    <head>
        <title>Home</title>
        <meta charset = "UTF-8">
    </head>
    <body>
        <h1>Job Lodgements</h1>
        <?php
            //check if user are logged in to show correct home content 
            session_start();
            
            $valid_Session = require ('checkSession.php');
            
            $valid_Login = require ('checkLogin.php');

            if($valid_Login || $valid_Session){//user are logging in
                
                $name = $_SESSION['valid_user'];
                echo "Welcome, $name<br><br>";
                echo '<h2>Your Options:</h2>';
                 //valid user content in home page
                    $valid_Login = require ('checkLogin.php');
                    $valid_Session = require ('checkSession.php');
        
                    if($valid_Login || $valid_Session){
                        echo '<a href = "add.php">Add a job</a><br>';
                        echo '<a href = "jobs.php">View all jobs</a>';
                    }
                include ("footer_logged_in.php");
            }
            else{                
                    //show not logged in content
                    echo "You are not logged in";
                    echo '<h2>Your Options:</h2>';
                    echo '<a href = "add.php">Add a job</a><br>';       
                    include ("footer_logged_out.php");				              
            }
        ?>
    </body>
</html>