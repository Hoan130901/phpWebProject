
    <?php
        $dbAddress ='localhost';
        $dbUser ="webauth";
        $dpPass ="webauth";
        $dbName ="assignment2";

        $db = new mysqli ($dbAddress, $dbUser, $dpPass, $dbName);

        if ($db -> connect_error){
            echo "Could not connect to the database";
            exit;
        }
    ?>
