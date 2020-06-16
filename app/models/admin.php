<?php

/*
*  Admin side of Çelikler
 */

class admin extends user {
    /*
      Admin adds a new food item to the menu, you will call global add method
     */

    public function addfood(food $food) {
        //assign variable to this name in data base
        $value_food = ['name' => $food->getName(), 'description' => $food->getDesription(), 'price' => $food->getPrice(), 'type_id' => $food->getType(), 'rate' => $food->getRate(), 'users_count' => 0];
        $DB = Database::getObject(); //create object
        //check if food add or not. We add&take all food to the CELIKLER database
        if (($DB->add("food", $value_food))) {
            $result = mysqli_fetch_array($DB->get("food", ["id"], "name", $food->getName()));
            //get here id from table after add it
            $id = $result[0]; //assgin id into var
            $Pic = $food->getPic(); //assgin pic to var
            //print_r( $Pic);
            //check if it array or not
            if ($Pic) {
                if (is_array($Pic)) {
                    //make query to add several pic for 1 food
                    $sql = "INSERT INTO pictures (food_id,picture) values ";
                    $valuesArr = array();
                    foreach ($Pic as $row) {
                        $valuesArr[] = "('$id', '$row')";
                    }
                    $sql .= implode(',', $valuesArr);
                    $DB->execute($sql); //excute query
                    //echo $sql;
                    return $id;
                } else {
                    $DB->add("pictures", ["food_id" => $id, "picture" => $Pic]); //if pic not an array
                }
            }
        } else {
            //echo 'error';//if  cant add food
        }
    }

    /*
      Admin updates a food item from the menu, you will call global update method
     */

    public function updatefood(food $food) {
        //assgin variable to this name in data base
        $value_food = ['name' => $food->getName(), 'description' => $food->getDesription(), 'price' => $food->getPrice(), 'type_id' => $food->getType()];
        $DB = Database::getObject(); //create object
        //check if food add or not
        if (($DB->edit("food", $value_food, 'id', $food->getID()))) {
            $id = $food->getID(); //assgin id into var
            $Pic = $food->getPic(); //assgin pic to var
            if ($Pic) {
                $DB->delete('pictures', 'food_id', $id);
            }
            //check if it array or not
            if (is_array($Pic)) {
                //make query to add several pic for 1 food
                $sql = "INSERT INTO pictures (food_id,picture) values ";
                $valuesArr = array();
                foreach ($Pic as $row) {
                    $valuesArr[] = "('$id', '$row')";
                }
                $sql .= implode(',', $valuesArr);
                $DB->execute($sql); //excute query
                return $id;
            }
        }
    }

    /*
      Admin deletes a food item from the menu
    */

    public function deletefood(food $food) {
        $DB = Database::getObject();
        $id = $food->getID();
        $query = "SELECT `order`.`date` FROM `order` WHERE `order`.`id` IN (SELECT `order_food`.`food_id` FROM `order_food` WHERE `order_food`.`food_id` = '$id')";
        $result = $DB->execute($query);
        if (mysqli_num_rows($result) == 0) {
            $DB->delete('pictures', 'food_id', $id);
            $DB->delete('food', 'id', $id);
        }
        else
        {
            echo "error";
        }
        $DB->closeConnection();
    }

    

    public function setAccessiblePages(employee $Employee) {
        //TODO
    }

    /*
      Add a new table to the database and chooses it loaction, you will call global add method
     */

    public function addTable(table $table) {
        $DB = Database::getObject(); // With a pocket of an object from the database to interact with: D
        if (!$DB->add('table', ['x' => $table->getX() 
                    , 'y' => $table->getY()
                    , 'table_number' => $table->getTableNumber() // This remains the number of the table itself, which is addictive, and it does not work with the database 
                    , 'chairs_number' => $table->getSeatsNumber() 
                ])) {
            return "Error inserting table<br>"; 
        } else {
            return mysqli_fetch_assoc($DB->get('table', ['id'], 'table_number', $table->getTableNumber()))['id']; 
        }
        $DB->closeConnection();
    }

    public function updateTable(table $table) {
        $DB = Database::getObject();
        if ($DB->edit("table", ['x' => $table->getX()
                    , 'y' => $table->getY()
                    , 'table_number' => $table->getTableNumber()
                    , 'chairs_number' => $table->getSeatsNumber()
                        ], "id", $table->getID())) {
            return 'done';
        } else {
            return "Error";
        }
    }

    /*
      Deletes a table from the database, you will call global delete method
     */

    public function DeleteTable(table $table) {
        $DB = Database::getObject(); 
                if (!$DB->delete('table', 'table_number', $table->getTableNumber())) {
            //echo "Error delete table<br>"; 
        } else {
            //echo "Done<br>";
        }
        $DB->closeConnection(); 
    }

    /*
      Reads reservation records from the database and shows it the admin
      You will show him all reservations, and it will contain
      - Name
      - Phone Number
      - Email
      - Date
      - Hour
      - Duration
      - Tables number
      - Tables he reserved
      - Payment method
      Çelikler Rest.'s admin can see all the reservation by this :D
     */

    public static function showAllreservations() {
        /*
         * Query for select data 'All reservations' from 4 tables and caldulate the number of chairs of each reservation
         * output it with ordering date & time
         */
        $DB = Database::getObject();
        $sql = "SELECT user.id ,user.first_name , user.last_name , user.phone_number , user.email , reservations.date , reservations.time , concat(\"[\", GROUP_CONCAT(`table`.id), \"]\") as `tables` ,"
                . "reservations.duration , SUM(table.chairs_number) as `chairs_number` FROM user "
                . "JOIN reservations ON user.id=reservations.user_id "
                . "JOIN reservation_tables ON reservations.id=reservation_tables.reservation_id "
                . "JOIN `table` ON reservation_tables.table_id=`table`.`id` "
                . "GROUP BY reservation_tables.reservation_id "
                . "ORDER BY reservations.date , reservations.time";

        //call function execute which take query and execute it
        $check = $DB->execute($sql);
        return mysqli_fetch_all($check, MYSQLI_ASSOC);



    }
/*public static function showAllMembers() {
       
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
*/

}
