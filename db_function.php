<?php

class DB_FUNCTIONS{

    private $conn;

    function __construct()
    {
        require_once 'db_connect.php';
        $db = new DB_CONNECT();
        $this->conn = $db->connect();
    }

    function __destruct(){

    }

    public function login($userName, $password){
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE IsAdmin = 0 AND UserName=? AND Password=?");
        $stmt->bind_param('ss', $userName, $password);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $stmt->close();

            $uName = $user['UserName'];
            $Password = $user['Password'];
            if ($uName == $userName && $Password == $password) {
                return $user;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }

    public function validate($barcode){

        $stmt = $this->conn->prepare("select rd.Id, rd.IsCadet from registrationdetails as rd inner join cadetregistration as cr on rd.CadetId = cr.CadetId and cr.RegStatus = 'Paid' where CouponNo = ? and cr.RegCategory != 'Souvenir'");
        $stmt->bind_param('s', $barcode);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows>0){
            $user = $result->fetch_assoc();
            $stmt->close();
            return $user;
        }else{
            return null;
        }
    }

    public function validate_other_event($barcode){

        $stmt = $this->conn->prepare("select rd.ID from registrationdetails as rd inner join cadetregistration as cr on rd.CadetId = cr.CadetId and cr.RegStatus = 'Paid' where CouponNo = ? and cr.RegCategory != 'Souvenir'");
        $stmt->bind_param('s', $barcode);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows>0){
            $user = $result->fetch_assoc();
            $stmt->close();

            return $user;
        }else{
            return null;
        }

    }

    public function check_barcode($barcode, $eventDetId){
        $stmt = $this->conn->prepare("select et.ID from EventAttendance_TRS as et inner join registrationdetails as rd on et.RegDetId = rd.Id where rd.CouponNo = ? and et.EventDetID = ?");
        $stmt->bind_param('si', $barcode, $eventDetId);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows>0){
            $user = $result->fetch_assoc();
            $stmt->close();
            return $user;
        }else{
            return null;
            echo "not found";
        }
    }

    public function register_barcode($eventDetId, $registrationId, $entryBy) {
        $stmt = $this->conn->prepare("INSERT INTO eventattendance_trs (EventDetID, RegDetID, EntryTime, EntryBy) VALUES (?,?,NOW(),?)");
        $stmt->bind_param('iis', $eventDetId, $registrationId, $entryBy);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }


    public function cadet_Details($barcode){

        $stmt = $this->conn->prepare("select cadet.CadetName, cadet.CadetNo, cadet.Intake, cr.ShirtSize, cr.TotalGuest + 1 as 'Total Attendance', cr.AccommodationDesc from registrationdetails as rd inner join cadetregistration as cr on rd.RegistrationId = cr.Id and cr.RegStatus = 'Paid' and rd.IsCadet = 1 inner join cadet on rd.CadetId = cadet.Id where rd.CouponNo = ? and cr.RegCategory != 'Souvenir'  ");
        $stmt->bind_param('s', $barcode);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows>0){

            $details = $result->fetch_assoc();
            $stmt->close();

            return $details;

        }else{
            return null;
        }

    }

    public function check_relation($barcode){

        $stmt = $this->conn->prepare("select rd.IsCadet, cadet.CadetName, cadet.CadetNo,  rd.RelationWithCadet from registrationdetails as rd inner join cadetregistration as cr on rd.RegistrationId = cr.Id and cr.RegStatus = 'Paid' inner join cadet on rd.CadetId = cadet.Id where rd.CouponNo = ? and cr.RegCategory != 'Souvenir'");
        $stmt->bind_param('s', $barcode);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows>0){

            $relation = $result->fetch_assoc();
            $stmt->close();

            return $relation;

        }else{
            return null;
        }


    }


    function getCadetParking($barcode) {

        $stmt = $this->conn->prepare("SELECT rp.ParkingNo FROM registrationdetails as rd 
    INNER JOIN cadetregistration as cr ON rd.RegistrationId = cr.Id AND cr.RegStatus = 'Paid' AND rd.IsCadet = 1 
    INNER JOIN regparkings as rp ON cr.ID = rp.RegistrationId 
    WHERE rd.CouponNo = ? AND cr.RegCategory != 'Souvenir'");
        $stmt->bind_param("s", $barcode);
        $stmt->execute();
        $result = $stmt->get_result();


        if ($result->num_rows>0) {
            $parkings = array();
            while($row = $result->fetch_assoc()){
                $parkings[] = $row;
            }
            $stmt->close();
            return $parkings;
        } else {
            return NULL;
        }
    }

    public function load_events()
    {
        $stmt = $this->conn->prepare("SELECT Id, SubEventTitle FROM `eventdetails` WHERE Id != 1");
        $stmt->execute();
        $result = $stmt->get_result();
        $events = array();
        while ($row = $result->fetch_assoc()) {
            $events[] = $row;
        }
        $stmt->close();
        return $events;
    }



}
