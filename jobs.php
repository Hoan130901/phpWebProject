<?php require("dbConnection.php"); ?>
<html>
    <head>
        <meta charset="utf-8">
        <title>Jobs</title>
    </head>
    <body>
        <h1>List of Jobs</h1>
        <?php 
            $query = "SELECT * from jobs order by customer_name asc";
            $q_result = $db->query($query);
            if ($q_result->num_rows > 0){ //check if there is any job 
                if(isset($_POST['search'])){
                    echo '<h4> Sorting by '.$_POST['filter'].'</h4><br />';
                }else{
                    echo '<h4>Sorting by Customer Name</h4><br />';
                }
            ?>
                <form action="" method="POST"> <!--- Creating sorting form --->
                    <label>Sort By:</label>
                    
                    <select name="filter">
                        <option>Customer Name</option>
                        <option>Severity</option>
                    </select>
                    <button type="submit" name="search">Go</button>
                </form>
                <table border="1" cellspacing="2" cellpadding="5">  <!--- Creating job list table --->
                    <thead>
                        <tr>
                            <th>Customer Name</th>
                            <th>Customer Email</th>
                            <th>Severity</th>
                            <th>Description</th>
                            <th></th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            
                            if(isset($_POST['search'])){
                                $filter = $_POST['filter'];
                                if ($filter == 'Customer Name') {//sort by customer name
                                    $query_ = "SELECT * from jobs ORDER BY customer_name asc"; 
                                }elseif ($filter == 'Severity') {//sort by severity
                                    $query_ = "SELECT * from jobs ORDER BY severity asc";
                                }
                               
                                $stmt = $db->query($query_);
                                while($value  = $stmt->fetch_array())://read every row in the table and get value into variables
                                    $name = $value['customer_name'];
                                    $email = $value['email'];
                                    $description = $value['description'];
                                    
                                    //set severity string value for table visibility
                                    if($value['severity']==1){
                                        $severity = "High";
                                    }elseif($value['severity'] == 2){
                                        $severity = "Medium";
                                    }elseif($value['severity'] == 3){
                                        $severity = "Low";
                                    }
                        //prepare table?>
                        <tr>
                            <td align="center"><?=$name?></td>
                            <td align="center"><?=$email?></td>
                            <td align="center"><?=$severity?></td>
                            <td align="center"><?=$description?></td>
                            <td class="text-center">
                                    <form action="edit.php" method="GET">                                   
                                    <button type="submit" name = "id" value="<?=$value['id']?>">Edit</button>
                                    </form>
                                       
                                    </td>
                                    <td>
                                    <form action="delete.php" method="GET">                                   
                                    <button type="submit" name = "id" value="<?=$value['id']?>">Delete</button>
                                    </form>
                                    </td>
                        </tr>
                        <?php endwhile;
                        }else{
                            while($value  = $q_result->fetch_array()):
                                if ($value['severity'] == 1):
                                    $severity = 'High';
                                elseif($value['severity'] == 2):
                                    $severity = 'Medium';
                                elseif($value['severity'] == 3):
                                    $severity = 'Low';
                                endif;
                        ?>
                                <tr>
                                    <td class="text-center"><?=$value['customer_name']?></td>
                                    <td class="text-center"><?=$value['email']?></td>
                                    <td class="text-center"><?=$severity?></td>
                                    <td class="text-center"><?=$value['description']?></td>
                                    <td class="text-center">
                                    <form action="edit.php" method="GET">                                   
                                    <button type="submit" name="id" value="<?=$value['id']?>">Edit</button>
                                    </form>
                                       
                                    </td>
                                    <td>
                                    <form action="delete.php" method="GET">                                   
                                    <button type="submit" name="id" value="<?=$value['id']?>">Delete</button>
                                    </form>
                                    </td>
                                </tr>
                        <?php 
                        endwhile;
                        }
                        ?>
                </table>       
        <?php  
        include ("footer_logged_in.php");
        }else{
                echo 'There is no job in your list';
            }
        $db->close();
        ?>

    </body>
</html>