<?php
    require_once('session.php');
    require_once('dbConnect.php');

    $query = "delete from bookings where bookId = " . $_REQUEST["bookId"];
    $mysqli->query($query);

    header("Location: ../myBookings.php?bookCourt=success");
?>

