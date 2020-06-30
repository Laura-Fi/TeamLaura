<?php
    require_once('incl/session.php');
    require_once('incl/dbConnect.php');

    //TO DO
    $bookQuery = "select * from bookings, member where member.id = bookings.memberId";
    if ($_SESSION["isAdmin"] != 1) {
        $bookQuery .= " and memberId =" . $_SESSION["id"];
    }
    $bookQuery .= " order by bookingDate desc, bookFrom, courtId";
    $bookResult = $mysqli->query($bookQuery);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>My bookings</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="style/myBookings.css">
</head>

<body>
    <div class="container">
    <h1>Welcome, <?php echo $_SESSION["firstName"]?>!</h1>
    <h2>These are your bookings:</h1>
    <a href="logout.php" id="logoutLink">Logout</a>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Booking number</th>
                <th>Court number</th>
                <th>Date</th>
                <th style='text-align: right'>From</th>
                <th style='text-align: right'>To</th>
                <?php
                    if ($_SESSION["isAdmin"] == 1) { 
                ?>
                    <th>Booked by</th>
                    <th>For guest</th>
                <?php
                    }
                ?>
            </tr>
        </thead>
        <tbody>
            <tr>
            <?php
            while($curBooking = mysqli_fetch_array($bookResult)) {
                echo "<tr>";
                echo "<td>".$curBooking['bookId']."</td>";
                echo "<td>".$curBooking['courtId']."</td>";
                echo "<td><a href='addBookingFancy.php?bookingDate=".$curBooking['bookingDate']."'>".(new DateTime ($curBooking['bookingDate']))->format('d.m.Y')."</a></td>";
                echo "<td style='text-align: right'>".$curBooking['bookFrom'].":00</td>";
                echo "<td style='text-align: right'>".$curBooking['bookTo'].":00</td>";
                if ($_SESSION["isAdmin"] == 1) { 
                    echo "<td>".$curBooking['firstName']."</td>";
                    echo "<td>".$curBooking['guestName']."</td>"; 
                }
            ?>
                <td><a href=<?php echo "editBooking.php?bookId=".$curBooking["bookId"]?>>Edit</a></td>
                <td><a href=<?php echo "incl/deleteBooking.incl.php?bookId=".$curBooking["bookId"]?> onclick="return confirm('Are you sure you want to delete this booking?');">Delete</a></td>
            <?php
            }
            ?>
            </tr>
        </tbody>
    </table>
    <a href="addBooking.php" id="makeBookingLink">Make a new booking</a><br/>
    <a href="addBookingFancy.php" id="makeBookingLink">Booking overview</a>
    </div>
</body>
</html>
        
