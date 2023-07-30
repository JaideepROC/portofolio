<?php
include('connection.php');

if (isset($_POST['submit'])) {
    $username = $_POST['user'];
    $password = $_POST['pass'];

    $sql = "SELECT * FROM login WHERE username = ? AND password = ?";
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "ss", $username, $password);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if ($result && mysqli_num_rows($result) > 0) {
        header("Location: admin.php");
        exit();
    } else {
        echo '<script>
            window.location.href = "login.php";
            alert("Incorrect username or password.");
        </script>';
    }
}
?>
