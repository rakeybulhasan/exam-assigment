<?php

use App\Controllers\BuyerController;
use Core\Model;

require_once __DIR__ . '/vendor/autoload.php';
define("APPLICATION_PATH",  dirname(__FILE__));
$db = Model::getInstance();
$mysqli = $db->getConnection();

$result = array('error'=>false);
$action = '';

if(isset($_POST['action'])){
    $action=$_POST['action'];
}

if($action==='INSERT'){
    $productObj = new BuyerController();
    $result = $productObj->insert();
}
if($action==='UPDATE'){
    $productObj = new Product();
    $result = $productObj->updateProduct();
}

if($action==='DELETE'){
    $productObj = new Product();
    $result = $productObj->deleteProduct();
}

if($action==='PRODUCT_LIST'){
    $productObj = new Product();
    $products = $productObj->getProducts();
    $output='';

    if($products){

       $result['products']= $products;

    }else{
        $result['error']=true;
        $result['message']='Something is wrong';
    }

}
echo json_encode($result);

