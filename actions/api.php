<?php
                require ("db_connection.php");
                // $sql = "Select * FROM startups";
                // $result = $connect->query($sql);

                // if ($result->num_rows>0){
                //     while ($row = $result->fetch_assoc()){
                //         $id = $row['id'];
                //         $name = $row['name'];
                //         $type = $row['type'];
                //         $founders = $row['founders'];
                //         $foundingyear = $row['foundingyear'];
                //         $contacts = $row['contacts'];
                //         $location = $row['location'];
                //         $countries_of_operation = $row['countries_of_operation'];
                //         $equityfunding = $row['equityfunding'];
                //         $grants = $row['grants'];
                //         $investor = $row['investor'];
                //         $status = $row['status'];
                //         $number_of_employees = $row['number_of_employees'];
                //         $social_media = $row['social_media'];
                //     }
                //     # code...
                // }
                // else{echo 'Sorry it refused'.$connect->error;}
                ?>

<?php 
    $stmt = $pdo->prepare('select * from startups;');
// $stmt = $pdo->prepare('CALL prcGetRoutes();');
    // $json = []
     $stmt->execute();
     // foreach ($stmt as $row) {
     //        $json .= $row['name'];
     //        $json .= ',';
        // }
     // $json = rtrim($json, ",");
     //    $json .= '] }';

        $json = json_encode($stmt->fetchAll());

        header('Content-Type: application/json');
        echo $json;