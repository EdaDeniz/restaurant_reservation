<?php


class Guest extends Human {
    /*
        Guest will sign up for an account

    */

    public function Regestration($Email , $Password , $firstname, $lastname,$address , $phonenumber) {
        $DB = Database::getObject();
        $userid = mysqli_fetch_array($DB->get("user_types",array("id"),"type","user"));
        $array = array("first_name" => $firstname, "last_name" => $lastname, "email" => $Email, "phone_number" => $phonenumber, "user_type_id" => $userid[0]);
        if (Validation::checkEmail($Email) != "update") {
            $DB->add("user", $array);
        } else {
            $DB->edit("user", $array, "email", $array["email"]);
        }

        $getuserID = mysqli_fetch_array($DB->get("user", array("id"), "email", $Email));
        //echo $getuserID[0]; --> I tried this but olmadı why???

        $Password = md5($Password);
        $DB->add("member_details", array("user_id" => $getuserID[0], "password" => $Password, "address" => $address));

        $associativeArray = array("id" => $getuserID[0], "first_name" => $firstname, "last_name" => $lastname, "email" => $Email, "phone_number" => $phonenumber, "user_type_id" => 0, "address" => $address);

        foreach ($associativeArray as $key => $value) {
            $_SESSION["$key"] = $value;
        }
        $_SESSION["password"] = $Password;
    }

    /*
        Guest will make a reservation, you will use the global add method
    */
    public function addReservation(reservation $reservation) {
        //TODO
    }

    /*
        Guest will update a reservation, you will use the global update method
    */
    public function updateReservation(reservation $reservation) {
        //TODO
    }

    /*
        Guest will delete a reservation, you will use the global delete method
    */
    public function deleteReservation(reservation $reservation) {
        //TODO
    }
}
