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


if (isset($_POST['event']) && isset($_POST['date']) && isset($_POST['time']) && isset($_POST['price'])) {
    $event = $_POST['event'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $price = $_POST['price'];


    $sql = "INSERT INTO events (event_name, date, time, price) VALUES (?, ?, ?, ?)";
    

    $stmt = $conn->prepare($sql);
    
   
    $stmt->bind_param("ssss", $event, $date, $time, $price);

    if ($stmt->execute()) {
        echo 'Event added successfully.';
    } else {
        echo 'Error adding event: ' . $stmt->error;
    }
    
 
    $stmt->close();
}


if (isset($_POST['band']) && isset($_POST['genre'])) {
    $band = $_POST['band'];
    $genre = $_POST['genre'];

    $sql = "INSERT INTO bands (band_name, genre) VALUES (?, ?)";
    
   
    $stmt = $conn->prepare($sql);
  
    $stmt->bind_param("ss", $band, $genre);

 
    if ($stmt->execute()) {
        echo 'Band added successfully.';
    } else {
        echo 'Error adding band: ' . $stmt->error;
    }
    
 
    $stmt->close();
}


if (isset($_POST['event_id']) && isset($_POST['band_id'])) {
    $eventId = $_POST['event_id'];
    $bandId = $_POST['band_id'];

   
    $sql = "UPDATE events SET band_id = ? WHERE id = ?";
    
    
    $stmt = $conn->prepare($sql);
    
  
    $stmt->bind_param("ii", $bandId, $eventId);

    
    if ($stmt->execute()) {
        echo 'Event and Band connected successfully.';
    } else {
        echo 'Error connecting event and band: ' . $stmt->error;
    }
    

    $stmt->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel</title>
</head>
<body>
    <h1>Admin Panel</h1>
    <h2>Create Event</h2>
    <form method="POST" action="admin.php">
        <label for="event">Event:</label>
        <input type="text" name="event" required><br>

        <label for="date">Date:</label>
        <input type="date" name="date" required><br>

        <label for="time">Time:</label>
        <input type="text" name="time" required><br>

        <label for="price">Price:</label>
        <input type="text" name="price" required><br>

        <input type="submit" value="Add Event">
    </form>

    <h2>Create Band</h2>
    <form method="POST" action="admin.php">
        <label for="band">Band:</label>
        <input type="text" name="band" required><br>

        <label for="genre">Genre:</label>
        <input type="text" name="genre" required><br>

        <input type="submit" value="Add Band">
    </form>

    <h2>Connect Event and Band</h2>
    <form method="POST" action="admin.php">
        <label for="event_id">Event:</label>
        <select name="event_id" required>
            <?php
          
            $sql = "SELECT * FROM events";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                while ($event = $result->fetch_assoc()) {
                    if (empty($event['band_id'])) {
                        echo '<option value="' . $event['id'] . '">' . $event['event_name'] . '</option>';
                    }
                }
            }
            ?>
        </select><br>

        <label for="band_id">Band:</label>
        <select name="band_id" required>
            <?php
           
            $sql = "SELECT * FROM bands";
            $result = $conn->query($sql);
            if ($result && $result->num_rows > 0) {
                while ($band = $result->fetch_assoc()) {
                    echo '<option value="' . $band['id'] . '">' . $band['band_name'] . '</option>';
                }
            }
            ?>
        </select><br>

        <input type="submit" value="Connect">
    </form>
</body>
</html>
