<?php
    require_once('incl/session.php');

    $bookingDate = date('Y-m-d');
    
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        require_once('incl/dbConnect.php');

        $courtId = $_POST['courtId'];
        $bookingDate = $_POST['bookingDate'];
        $bookFrom = $_POST['bookFrom'];
        $bookTo = $_POST['bookTo'];
        $guestName = $_POST['guestName'];
        $memberId = $_SESSION['id'];

        if ($bookingDate < date('Y-m-d')) {
            $add_err = "booking date cannot be in the past!";
        }
        elseif ($bookFrom >= $bookTo) {
            $add_err = "invalid time range!";
        }
        else {
            $checkQuery = "SELECT * FROM bookings WHERE courtId =" . $courtId 
            . " and bookingDate = '" . $bookingDate ."' and ((bookFrom <=" .$bookFrom . " and bookTo >" .$bookFrom. ") or (bookFrom <" . $bookTo. " and bookTo >=".$bookTo.") or (bookFrom >" . $bookFrom. " and bookTo <".$bookTo."))" ;
            $checkResult = $mysqli->query($checkQuery);
            //var_dump($checkResult);
            //var_dump($checkQuery);

            if ($checkResult && $checkResult->num_rows == 0) {
                $query = "insert into bookings(courtId, memberId, bookingDate, bookFrom, bookTo, guestName) 
                values ('$courtId', '$memberId', '$bookingDate', '$bookFrom', '$bookTo', '$guestName');";
                $mysqli->query($query); 
                header("Location: myBookings.php?bookCourt=success");           
            } else {
                $add_err = 'Sorry, but that spot is already taken.';   
            }
        }
    }
    else{
        $courtId = (isset($_REQUEST['court']) ? $_REQUEST['court'] : 1);
        $bookingDate = (isset($_REQUEST['date']) ? $_REQUEST['date'] : date('Y-m-d'));
        $bookFrom = (isset($_REQUEST['start']) ? $_REQUEST['start'] : 7);
        $bookTo = $bookFrom + 1;
    }

?>

<html>
<head>
    <title>Book a court</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="style/addBooking.css">
</head>

<body>
    <h1>Book a court</h1>
    <span class="help-block"><?php echo $add_err; ?></span>

    <table>
        <form action="addBooking.php" method="POST">
        <tr>
            <td>
                <label for="bDate">Choose the court:</label>
            </td>
            <td colspan="2">
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
                <label for="bDate">Choose the date:</label>
            </td>
            <td colspan="2">
                <input type="date" id="bDate" name="bookingDate" value="<?php echo $bookingDate; ?>"/>          
            </td>
        </tr>
        <tr>
            <td>
                <label for="bDate">Choose the time:</label>
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
                    for ($i = 8; $i <= 22   ; $i++) {
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
                <label for="name">Enter guest name:</label>            
            </td>
            <td colspan="2">
                <input type="text" id="guestName" name="guestName" value="<?php echo $guestName; ?>"/>
            </td>
        </tr>
    <?php
        }
    ?>
        <tr>
            <td>
                <input type="submit" value="Book"> 
            </td>
            <td colspan="2">
                <a href="myBookings.php" id="myBookingLink">My bookings</a>
            </td>
        </tr>
        </form>
    </table>
</body>
</html>
