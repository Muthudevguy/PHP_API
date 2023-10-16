<?php

require '../INC/dbcon.php';


function deleteCustomer($customerParams)
{
    global $conn;

    if (isset($customerParams['id'])) {

        return error422('customer id not found in URL');
    } elseif ($customerParams['id'] == null) {

        return error422('Enter the custoer id');
    }
    $customerId = mysqli_real_escape_string($conn, $customerParams['id']);

    $query = "DELETE FROM customer WHERE id = '$customerId ' LIMIT 1";

    $result = mysqli_query($conn, $query);

    if ($result) {
        $data = [
            'status' => 200,
            'message' => 'customer deleted successfully'

        ];
        header ("HTTP/1.0 200 ok");
        return json_encode($data);

    }
    else{
        $data = [
            'status' => 404,
            'message' => 'customer not found',

        ];
        header("HTTP/1.0 Not Found");
        return json_encode($data);
    }
}

function updateCustomer($customerinput, $customerParams)
{
    global $conn;

    if (!isset($customerParams['id'])) {


        return error422('customer id not found in url');
    } elseif ($customerParams['id'] == null) {

        return error422('enter the customer id');
    }

    $customerId = mysqli_real_escape_string($conn, $customerParams['id']);

    $name = mysqli_real_escape_string($conn, $customerinput['name']);
    $email = mysqli_real_escape_string($conn, $customerinput['email']);
    $phone = mysqli_real_escape_string($conn, $customerinput['phone']);


    if (empty(trim($name))) {
        return error422('enter your name');
    } elseif (empty(trim($email))) {
        return error422('enter your email');
    } elseif (empty(trim($phone))) {
        return error422('enter your phone');
    } else {
        $query = "UPDATE customer SET name='$name', email='$email', phone='$phone' where id='$customerId' LIMIT 1";
        $result = mysqli_query($conn, $query);

        if ($result) {

            $data = [
                'status' => 201,
                'message' => 'Customer Updated Successfully',
            ];
            header('HTTP/1.0 5 201 Created');
            return json_encode($data);
        } else {
            $data = [
                'status' => 500,
                'message' => 'Internal server error',
            ];
            header('HTTP/1.0 500 Internal Server Error');
            return json_encode($data);
        }
    }
}





function error422($message)
{
    $data = [
        'satus' => 422,
        'message' => $message,

    ];
    header("HTTP/1.0 422 Unprocessable entity");
    echo json_encode($data);
    exit();
}

function storeCustomer($customerinput)
{
    global $conn;

    $name = mysqli_real_escape_string($conn, $customerinput['name']);
    $email = mysqli_real_escape_string($conn, $customerinput['email']);
    $phone = mysqli_real_escape_string($conn, $customerinput['phone']);


    if (empty(trim($name))) {
        return error422('enter your name');
    } elseif (empty(trim($email))) {
        return error422('enter your email');
    } elseif (empty(trim($phone))) {
        return error422('enter your phone');
    } else {
        $query = "INSERT INTO customer (name,email,phone) VALUE ('$name','$email','$phone')";
        $result = mysqli_query($conn, $query);

        if ($result) {

            $data = [
                'status' => 201,
                'message' => 'Customer Created Successfully',
            ];
            header('HTTP/1.0 5 201 Created');
            return json_encode($data);
        } else {
            $data = [
                'status' => 500,
                'message' => 'Internal server error',
            ];
            header('HTTP/1.0 500 Internal Server Error');
            return json_encode($data);
        }
    }
}


function getCustomerList()
{


    global $conn;

    $query = "SELECT * FROM customer";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        if (mysqli_num_rows($query_run) > 0) {

            $res = mysqli_fetch_all($query_run, MYSQLI_ASSOC);

            $data = [
                'status' => 200,
                'message' => 'customer list fetched successfully',
                'data' => $res,
            ];
        } else {
            $data = [
                'status' => 404,
                'message' => 'No Customer Found',
            ];
            header("HTTP/1.0 404 No Customer Found");
            return json_encode($data);
        }
    } else {
        $data = [
            'status' => 500,
            'message' => 'Internal server error',
        ];
        header('HTTP/1.0 500 Internal Server Error');
        return json_encode($data);
    }
}
function getCustomer($customerParams)
{

    global $conn;
    if ($customerParams['id'] == null) {
        return error422('Enter your customer id');
    }

    $customerId = mysqli_real_escape_string($conn, $customerParams['id']);
    $query = "SELECT * FROM customer WHERE id='$customerId' LIMIT 1";
    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $res = mysqli_fetch_assoc($result);

            $data = [
                'statis' => 200,
                'message' => 'Customer Fetched Successfully',
                'data' => $res
            ];
            header("HTTP/1.0 200 ok");
            return json_encode($data);
        } else {
            $data = [
                'statis' => 404,
                'message' => 'No Customer Found',
            ];
            header("HTTP/1.0 404 Not Found");
            return json_encode($data);
        }
    } else {
        $data = [
            'status' => 500,
            'message' => 'Internal Server Error',
        ];
    }
}
