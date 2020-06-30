<?php
    require_once('incl/session.php');
    require_once('incl/dbConnect.php');[];

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $bookId = $_POST['bookId'];
        $courtId = $_POST['courtId'];
        $bookingDate = $_POST['bookingDate'];
        $bookFrom = $_POST['bookFrom'];
        $bookTo = $_POST['bookTo'];
        $guestName = $_POST['guestName'];

        if ($bookingDate < date('Y-m-d')) {
            $edit_err = "booking date cannot be in the past!";
        }
        elseif ($bookFrom >= $bookTo) {
            $edit_err = "invalid time range";
        }
        else {
            $checkQuery = "SELECT * FROM bookings WHERE courtId =" . $courtId 
            . " and bookId <> " . $bookId
            . " and bookingDate = '" . $bookingDate ."' and ((bookFrom <=" .$bookFrom . " and bookTo >" .$bookFrom. ") or (bookFrom <" . $bookTo. " and bookTo >=".$bookTo.") or (bookFrom >" . $bookFrom. " and bookTo <".$bookTo."))" ;
            $checkResult = $mysqli->query($checkQuery);
            //var_dump($checkResult);
            //var_dump($checkQuery);

            if ($checkResult && $checkResult->num_rows == 0) {
                $updateQuery = "update bookings set courtId = $courtId, bookingDate = '$bookingDate',
                    bookFrom = $bookFrom, bookTo = $bookTo, guestName = '$guestName' where bookId = $bookId";
                if ($_SESSION["isAdmin"] != 1) {
                    $updateQuery .= " and memberId =" . $_SESSION["id"];
                }
                    
                if ($mysqli->query($updateQuery)){
                    header("Location: myBookings.php?bookCourt=success");
                }
                else{
                    $edit_err = "update failed! <a href='myBookings.php'>back</a>";
                }
            }
            else {
                $edit_err = 'Sorry, but that spot is already taken.';   
            }
        }
    }
    else{
        $bookQuery = "select * from bookings";
        if ($_SESSION["isAdmin"] == 1) {
            $bookQuery .= " join member on member.id = bookings.memberId";
        }
        $bookQuery .= " where bookId = " . $_REQUEST["bookId"];
        if ($_SESSION["isAdmin"] != 1) {
            $bookQuery .= " and memberId =" . $_SESSION["id"];
        }
        $bookResult = $mysqli->query($bookQuery);
        if ($bookResult && $bookResult->num_rows == 1) {
            //var_dump($bookResult);
            $curBooking = $bookResult -> fetch_assoc();

            $bookId = $curBooking['bookId'];
            $courtId = $curBooking['courtId'];
            $memberFirstName = $curBooking['firstName'];
            $bookingDate = $curBooking['bookingDate'];
            $bookFrom = $curBooking['bookFrom'];
            $bookTo = $curBooking['bookTo'];
            $guestName = $curBooking['guestName'];
        }
        else{
            $edit_err = "invalid booking! <a href='myBookings.php'>back</a>";
        }
    }
        
?>


<html>
<head>
    <title>Book a court</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="style/editBooking.css">
</head>

<body>
    <h1>Change your booking</h1>
    <span class="help-block"><?php echo $edit_err; ?></span>

    <table>
        <form action="editBooking.php" method="POST">
        <input type="hidden" id="bookId" name="bookId" value="<?php echo $bookId?>">
        <tr>
            <td>
                <label for="courtNr">Change your court:</label>
            </td>
            <td>
                <select name="courtId" id="court">
                    <?php
                        for ($i = 1; $i <= 6; $i++) {
                            echo "<option value=$i" . ($i == $courtId ? " selected" : "") .">Court $i</option>";
                        }    
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <label for="bDate">Change the date:</label>
            </td>
            <td>
                <input type="date" id="bDate" name="bookingDate" value="<?php echo $bookingDate?>">
            </td>
        </tr>
        <tr>
            <td>
                <label for="bDate">Change the time:</label>
            </td>
            <td>
                <label for="bDate">From:</label>
                <select name="bookFrom" id="bookFrom">
                <?php
                    for ($i = 7; $i <= 21; $i++) {
                        echo "<option value=$i" . ($i == $bookFrom ? " selected" : "") .">$i:00</option>";
                    }    
                ?>
                </select>
            </td>
            <td>
                <label for="bDate">To:</label>
                <select name="bookTo" id="bookTo">
                <?php
                    for ($i = 8; $i <= 22; $i++) {
                        echo "<option value=$i" . ($i == $bookTo ? " selected" : "") .">$i:00</option>";
                    }    
                ?>
                </select> 
            </td>
        </tr>
        <?php 
            if ($_SESSION["isAdmin"] == 1) { 
        ?>     
        <tr>
            <td>
                <label for="name">Guest name:</label>
            </td>
            <td>
                <input type="text" id="name" name="guestName" value="<?php echo $guestName?>">
            </td>
        </tr>
        <tr>
            <td>
                <label for="name">Booked by:</label>
            </td>
            <td>
                <span><?php echo $memberFirstName?></span>
            </td>
        </tr>
        <?php
            }
        ?>
        <tr>
            <td>
                <input type="submit" value="Change"> 
            </td>
            <td colspan="2">
                <a href="myBookings.php" id="myBookingLink">My bookings</a>
            </td>
        </tr>
        </form>
    </table>
</body>
</html>