<?php

header('Access-Control-Allow-Origin:*');
header('Content-Type: application/json');
header('Access-Control-Allow-Method:DELETE');
header('Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Request-With');

include ('function.php');


$requestMethod = $_SERVER["REQUEST_METHOD"];

if($requestMethod == "DELETE"){
     
    if (isset($_GET['id'])){

        $deleteCustomer = deleteCustomer($_GET);
        echo $customer;

    }
    else{
        $customeList=getCustomerList();
        echo $customerList;

    }


     $customerList = getCustomerList();
     echo $customerList;


}

else
{
    $data = [
        'satus' => 405, 
        'message'=> $requestMethod.'Method Not Allowed',

    ];
    header("HTTP/1.0 405 Method Not Allowed");
    echo json_encode($data);
}
?>