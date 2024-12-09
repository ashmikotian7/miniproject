<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "fac";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        echo json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]);
        exit;
    }

    // Collect form data
    $facultyID = $_POST['facultyID'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Encrypt the password
    $birthdate = $_POST['birthdate'];
    $fav_color = $_POST['fav_color'];

    // Validate email domain
    if (!str_ends_with($email, "@sode-edu.in")) {
        echo json_encode(["status" => "error", "message" => "This platform is only for @sode-edu.in email addresses."]);
        exit;
    }

    // Insert data into the database
    $sql = "INSERT INTO faculty (facultyID, name, email, password, birthdate, fav_color) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $facultyID, $name, $email, $password, $birthdate, $fav_color);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Signup successful!"]);
    } else {
        echo json_encode(["status" => "error", "message" => "Error: " . $stmt->error]);
    }

    $stmt->close();
    $conn->close();
}
?>
