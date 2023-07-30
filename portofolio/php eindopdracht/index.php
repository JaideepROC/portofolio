<?php
session_start();


$servername = "localhost";
$username = "schooluser";
$password = "Jaideepsingh13";
$dbname = "school3";


$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


function getBandDetails($bandId, $conn)
{
    $sql = "SELECT * FROM bands WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $bandId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        return $result->fetch_assoc();
    }

    return null;
}


function filterEventsByMonth($conn, $month)
{
 
    $sql = "SELECT * FROM events WHERE DATE_FORMAT(date, '%Y-%m') = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $month);
    $stmt->execute();
    $result = $stmt->get_result();

    $filteredEvents = [];
    if ($result && $result->num_rows > 0) {
        while ($event = $result->fetch_assoc()) {
            $filteredEvents[] = $event;
        }
    }

    return $filteredEvents;
}


$sql = "SELECT * FROM events";
$result = $conn->query($sql);
$events = [];
if ($result && $result->num_rows > 0) {
    while ($event = $result->fetch_assoc()) {
        $events[] = $event;
    }
}


$month = isset($_GET['month']) ? $_GET['month'] : date('Y-m');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Main Page</title>
</head>
<body>
    <h1>Main Page</h1>
    <form method="GET" action="index.php">
        <label for="month">Search by Month:</label>
        <input type="month" name="month" value="<?php echo $month; ?>">
        <input type="submit" value="Search">
    </form>

    <?php
    // Filter events by month
    $filteredEvents = filterEventsByMonth($conn, $month);

    if (count($filteredEvents) > 0) {
        echo '<h2>Events</h2>';
        foreach ($filteredEvents as $event) {
            echo '<h3>' . $event['event_name'] . '</h3>';
            echo '<p>Date: ' . $event['date'] . '</p>';
            echo '<p>Time: ' . $event['time'] . '</p>';
            echo '<p>Price: ' . $event['price'] . '</p>';

            $band = getBandDetails($event['band_id'], $conn);
            if ($band) {
                echo '<p>Band: ' . $band['band_name'] . '</p>';
                echo '<p>Genre: ' . $band['genre'] . '</p>';
            } else {
                echo '<p>Band: Not connected</p>';
            }

            echo '<hr>';
        }
    } else {
        echo 'No events found.';
    }
    ?>
    <a href="login.php">admin</a>
</body>
</html>


