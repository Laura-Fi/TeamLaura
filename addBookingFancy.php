<?php
    require_once('incl/session.php');
    require_once('incl/dbConnect.php');

    $bookingDate = ($_REQUEST['bookingDate'] ? $_REQUEST['bookingDate'] : date('Y-m-d'));

    $query = "SELECT * FROM bookings where bookingDate = '" . $bookingDate . "'";
    $result = $mysqli->query($query);


    while ($booking = $result->fetch_assoc())
    {
        for ($i = $booking['bookFrom']; $i < $booking['bookTo']; $i++){
            $bArr[$booking['courtId']."-".$i] = 
                ($_SESSION["isAdmin"] == 1 || $_SESSION["id"] == $booking['memberId'] ? $booking['bookId'] : -1);
        }
    }
 ?>

<html>
<head>
    <title>Book a court</title>
    <link rel="stylesheet" href="style/addBookingFancy.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>

<body>
    <h1>Booking Overview</h1>
    <div class="container">
        <div class="row">
            <div class="col" id="col1">
                <form method="POST">
                    <div class="form-group">
                        <label for="bookingDate">When do you want to play?</label>
                        <input type="date" name="bookingDate" id="bookingDate" value="<?php echo $bookingDate; ?>" onchange="javascript:document.getElementsByTagName('form')[0].submit();">
                    </div>
                </form>
            </div>
            <div class="col"><a href="myBookings.php" id="myBookingLink">My bookings</a><br/>
            <a href="logout.php" id="logoutLink">Logout</a></div>
        </div>
        <div class="row">
            <div class="col" id="timeSlotText">
                Choose your preferred time slot
            </div>
            <?php
                for ($i = 1; $i <= 6; $i++) {
                    echo "<div class='col court'>
                            <img src='img/tennisCourt.jpeg' alt='court' style='width:100%;'>
                            <div class='centered'>Court $i</div>
                        </div>";
                }    
            ?>
        </div>
        <?php
            for ($i = 7; $i <= 21; $i++) {
                echo "<div class='row'><div class='col time'>".$i." - ". ($i + 1) ."</div>";
                for ($j = 1; $j <= 6; $j++) {
                    if ($bArr[$j."-".$i] == -1){
                        echo "<div class='col' id='blocked'>BOOKED</div>";
                    }
                    elseif ($bArr[$j."-".$i] >= 1) {
                        echo "<div class='col' id='editable'><a href='editBooking.php?bookId=".$bArr[$j."-".$i]."'>Edit</a></div>";
                    }
                    else{
                        echo "<div class='col' id='free'><a href='addBooking.php?court=$j&date=$bookingDate&start=$i'>Book</a></div>";
                    }
                }
                echo "</div>";
            }    
        ?>
    </div>
</body>
</html>


