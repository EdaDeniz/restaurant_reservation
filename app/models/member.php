<?php


class member extends user implements Usermanagment {



    /*
        Guest will make a reservation, you will use the global add method
        You have to use notify the user of his operation
        
    */
    public function addReservation(reservation $Reservation) {
        //Creating database object
        $DB = Database::getObject();

        //Getting reservation details from session and reservation object
        // User-Reservation Ender hoca bakar buna :D

        $userID = $_SESSION['id'];
        $date = $Reservation->getDate();
        $time = $Reservation->getTime();
        $duration = $Reservation->getDuration();

        //Sending reservation details to add method to add to the database
        $reserve = array("user_id"=>$userID,"date"=>$date,"time"=>$time,"duration"=>$duration);
        $DB->add("reservations",$reserve);

        //Selecting the reservation's id of reservation enter previous.
        $sql = "SELECT `id` FROM `reservations` WHERE user_id =$userID AND `date` = '$date' AND `time` = '$time' AND `duration` = $duration";

        //Recieving an object of reservation
        $check = $DB->execute($sql);

        //Getting array of reservation
        $row = mysqli_fetch_array($check);

        //get tables numbers
        $tables = $Reservation->getTable();

        //Adding tables to the reservation
        for($counter = 0; $counter<sizeof($tables); $counter++) {
            $tableNumber = array("id"); //Creating an array of table's array
            //Recieving tables' number from the database from their id
            $getTableID = mysqli_fetch_array($DB->get("table", $tableNumber ,"table_number",$tables[$counter]->getTableNumber()));
            $table = array("reservation_id"=>$row[0],"table_id"=>$getTableID[0]); //Creating an array of reservations' and tables' id
            $DB->add("reservation_tables",$table); //Adding reservation's tables in the database
        }

        //Setting member's id in the reservation and notify the user via email
        $Reservation->setMemberID($userID);
        $Reservation->setReservationID($row[0]);
        $this->notify($Reservation, 1);

        //Return reservation's id
        return $row[0];
    }

    /*
        Guest will update a reservation, you will use the global update method
        You have to use notify the user of his operation
    */
    public function updateReservation(reservation $Reservation) {
        //Creating an object of the database
        $DB = Database::getObject();

        //Getting user's id from the session
        $userID = $_SESSION['id'];

         //Getting reservation details
         $reserveID = $Reservation->getReservationID();
         $date = $Reservation->getDate();
         $time = $Reservation->getTime();
         $duration = $Reservation->getDuration();

         //Selecting reservation's date in time Turkey duration from the database by user's id
         $reserve = array("user_id"=>$userID,"date"=>$date,"time"=>$time,"duration"=>$duration);

         //Updating the reservation in the database
         $check = $DB->edit("reservations",$reserve,"id",$reserveID);

         //Getting tables info
         $tables = $Reservation->getTable();
         //Deleting all tables connected to the reservation and make the user's select new tables
         $DB->delete("reservation_tables","reservation_id",$reserveID);

         //Adding selected tables to the database
         for($counter = 0; $counter<sizeof($tables); $counter++) {
             $tableNumber = array("id"); //Creating an array of tables' id

             //Getting selected table's id
             $getTableID = mysqli_fetch_array($DB->get("table", $tableNumber ,"table_number",$tables[$counter]->getTableNumber()));

             //Adding selected tables to the database
             $table = array("reservation_id"=>$reserveID,"table_id"=>$getTableID[0]);
             $DB->add("reservation_tables",$table);
         }

         //Setting member's id in the reservation and notify the user via email
         $Reservation->setMemberID($userID);
         $this->notify($Reservation, 2);
    }

    /*
        Guest will delete a reservation, you will use the global delete method
        You have to use notify the user of his operation
    */
    public function deleteReservation(reservation $reservation) {
        $DB = Database::getObject(); //Creating an object of database
        $DB->delete("reservations","id",$reservation->getReservationID()); //Delete reservation by id of reservation
        $DB->closeConnection(); //Close conection

        //Setting member's id in the reservation and notify the user via email
        $userID = $_SESSION('id');
        $Reservation->setMemberID($userID);
        $this->notify($Reservation, 3);
    }

   

    /*
        User will get an email to notify him when he makes, updates or deletes a reservation
    */
    public function notify(reservation $reservation , $type) {
        //Creating an object of the database
        $DB = Database::getObject();

        //Getting user's id from the reservation object
        $memberID = $reservation->getMemberID();

        //Selecting user's email from the database
        $query = "SELECT `user`.`email` FROM `user` WHERE `user`.`id` = $memberID";
        $row = $DB->execute($query);

        //Recieving user's email
        $result = mysqli_fetch_array($row);
        $smugMail = "noreply@smug.com"; //Sending email
        $clientmail = $result[0];  //Selecting the first email from the array

        //Email text
        $DataMsg = "Date: " . $reservation->getDate() . "<br>Time: " . $reservation->getTime()
                . "<br>Duration: " . $reservation->getDuration();

        /*
            Selecting the message header depends on the reservation operation type
            - $type == 1 : New reeservation has been created
            - $type == 2 : New reeservation has been updated
            - $type == 3 : New reeservation has been deleted
        */
        if ($type == 1)
            $fullMsg = "Your reservation is Accepted <br>" . $DataMsg;
        else if ($type == 2)
            $fullMsg = "Your reservation is Updated <br>" . $DataMsg;
        else
            $fullMsg = "Your reservation is Deleted <br>";

        //Sending the email
        //mail($clientmail, $smugMail, $fullMsg); ---> beceremedik

        //Closing database connection
        $DB->closeConnection();
    }

    public static function find($id) {
        $DB = Database::getObject();
        $row = mysqli_fetch_assoc($DB->get('user', ['first_name', 'last_name', 'email', 'phone_number', 'user_type_id'], 'id', $id));
        $moreData = mysqli_fetch_assoc($DB->get('member_details', ['password','address'], 'user_id', $id));
        $member = new member();
        $member->setAddress($moreData['address']);
        $member->setEmail($row['email']);
        $member->setId($id);
        $member->setPassword($moreData['password']);
        $member->setType($row['user_type_id']);
        $member->setphoneNumber($row['phone_number']);
        $member->setFirstName($row['first_name']);
        $member->setLastName($row['last_name']);
        return $member;
    }

    
}
