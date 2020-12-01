<?php

namespace App\Controllers;

use Core\Controller;
use Core\Model;
use Core\View;

/**
 * The buyer controller class.
 * The controller is used to display the buyer.
 */
class BuyerController extends Controller {
    private $db_connect;
    private $db;

    public function __construct()
    {
        $this->db = Model::getInstance();
        $this->db_connect = $this->db->getConnection();
    }



    public function getBuyers(){

        $sql_query = "SELECT * FROM core_buyer b where entry_at IS NOT NULL";

        if(isset($_GET['searchButton']) && $_GET['searchButton']=='Search'){

            if($_GET['searchByReceiptId']!=''){
                $receiptId = $_GET['searchByReceiptId'];
                $sql_query.=" AND b.receipt_id LIKE '{$receiptId}'";
            }
            if($_GET['fromDate']!='' && $_GET['toDate']!=''){
                $fromDate = $_GET['fromDate'];
                $toDate = $_GET['toDate'];
                $sql_query.=" AND b.entry_at >='{$fromDate}' AND  b.entry_at <='{$toDate}'";
            }

        }



        $result = $this->db_connect->query($sql_query);
        if ( $result->num_rows > 0) {
            return  $result->fetch_all(MYSQLI_ASSOC);
        }
        return false;

    }


    public function insert(){

        date_default_timezone_set('Asia/Dhaka');
        $error= array();

        if($_COOKIE['preventMultipleSubmit']=='yes')
        {
            return array('error'=>true,'status'=>'404','message'=>'Prevent multiple submissions within 24 hours');
        }

        if (empty($_POST["buyer"])) {
            $error['buyer'] = "Buyer is required";
        } else {
            $name = $this->test_input($_POST["buyer"]);
            if(strlen($name)>20){
                $error['buyer'] = "Maximum 20 letters allowed";
            }else{
                // check if name only contains letters and whitespace
                if (!preg_match("/^[a-zA-Z-0-9' ]*$/",$name)) {
                    $error['buyer'] = "Only letters, numbers and white space allowed";
                }
            }
        }

        if (empty($_POST["city"])) {
            $error['city'] = "City is required";
        } else {
            $city = $this->test_input($_POST["city"]);
            // check if name only contains letters and whitespace
            if (!preg_match("/^[a-zA-Z' ]*$/",$city)) {
                $error['city'] = "Only letters and white space allowed";
            }
        }

        if (empty($_POST["receipt_id"])) {
            $error['receipt_id'] = "Receipt Id is required";
        } else {
            $receipt_id = $this->test_input($_POST["receipt_id"]);
            // check if name only contains letters
            if (!preg_match("/^[a-zA-Z']*$/",$receipt_id)) {
                $error['receipt_id'] = "Only letters allowed";
            }
        }

        if (empty($_POST["items"])) {
            $error['items'] = "Item is required";
        } else {
            $items = $this->test_input($_POST["items"]);
            // check if name only contains letters
            if (!preg_match("/^[a-zA-Z' ]*$/",$items)) {
                $error['items'] = "Only letters allowed";
            }
        }

        if (empty($_POST["entry_by"])) {
            $error['entry_by'] = "Entry By is required";
        } else {
            $entry_by = $this->test_input($_POST["entry_by"]);
            // check if name only contains numbers
            if (!preg_match("/^[0-9]*$/",$entry_by)) {
                $error['entry_by'] = "Only numbers allowed";
            }
        }

        if (empty($_POST["phone"])) {
            $error['phone'] = "Phone is required";
        } else {
            $phone = $this->test_input($_POST["phone"]);
            // check if name only contains numbers
            if (!preg_match("/^[0-9]*$/",$phone)) {
                $error['phone'] = "Only numbers allowed";
            }
        }

        if (empty($_POST["amount"])) {
            $error['amount'] = "Amount is required";
        } else {
            $amount = $this->test_input($_POST["amount"]);
            // check if name only contains numbers
            if (!preg_match('/^[0-9]+(\\.[0-9]+)?$/',$amount)) {
                $error['amount'] = "Only numbers allowed";
            }
        }

        if (empty($_POST["buyer_email"])) {
            $error['email'] = "Email is required";
        } else {
            $email = $this->test_input($_POST["buyer_email"]);
            // check if e-mail address is well-formed
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error['email'] = "Invalid email.";
            }
        }

        if(str_word_count($_POST["note"])>30){
            $error['note'] = "Maximum 30 word allowed.";
        }

        if(!empty($error)){
            return array('error'=>true,'status'=>'301',$error);
        }


        $currentDate = date('Y-m-d',strtotime('now'));

        $data = array(
            'amount'=>(int)$_POST['amount'],
            'buyer'=>$this->db_connect->escape_string($_POST["buyer"]),
            'receipt_id'=>$_POST['receipt_id'],
            'items'=>$_POST['items'],
            'buyer_email'=>$_POST['buyer_email'],
            'buyer_ip'=>$this->getUserIpAddr(),
            'note'=>$this->db_connect->escape_string($_POST['note']),
            'city'=>$this->db_connect->escape_string($_POST['city']),
            'phone'=>$_POST['phone'],
            'hash_key'=>hash("sha512", $_POST['receipt_id']),
            'entry_at'=>$currentDate,
            'entry_by'=>(int)$_POST['entry_by'],
        );
        $last_id=$this->db->insert('core_buyer', $data);
        if($last_id){
            setcookie('preventMultipleSubmit','yes', time() + 86400);
            return array('status'=>'200','id'=>$last_id,'message'=>'Buyer has been inserted successfully');
        }else{
            return array('error'=>true,'status'=>'301','message'=>'Something error');
        }

    }

   private function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

   private function getUserIpAddr(){
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            //ip from share internet
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            //ip pass from proxy
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        }else{
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

}
