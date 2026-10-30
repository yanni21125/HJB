<?php
include("db.php");


if ($_SERVER['REQUEST_METHOD'] === "GET"){
    $PRODUCTId = $_GET["PRODUCTId"];
    $FRUIT = $_GET["FRUIT"];
    $QNTTY = $_GET["QNTTY"];
    $UNITS = $_GET["UNITS"];
    $PRICE = $_GET["PRICE"];
    $IMAGE = $_GET["IMAGE"];
    $USER = $_GET["USER"];
    $CONTACT = $_GET["CONTACT"];

    $TOTAL = $PRICE * $QNTTY;


    $sql = "INSERT INTO orders(PRODUCTId, QNTTY, TOTAL, USER, CONTACT)
            VALUES('$PRODUCTId', '$QNTTY', '$TOTAL', '$USER', '$CONTACT')";


        if(mysqli_query($conn, $sql)){
            echo "Order Placed!";
        } else{
            echo "Error: ". mysqli_error($conn);
        }


        header("Location: index.php");


}
?>