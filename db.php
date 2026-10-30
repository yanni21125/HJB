<?php // opening tag
$conn = mysqli_connect("localhost", "root", "", "formdb"); // $=variable, conn=connection mysqli=syntax unmodified

if (!$conn) {
    die("May mali: " . mysqli_connect_error());
}
?> 