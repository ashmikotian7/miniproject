<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data from POST request
    $facultyID = trim($_POST['facultyID']);
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate the input fields (additional layer of validation)
    if (empty($facultyID) || empty($name) || empty($email) || empty($password)) {
        echo "<script>
                alert('All fields are required.');
                window.history.back();
              </script>";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>
                alert('Invalid email address.');
                window.history.back();
              </script>";
        exit;
    }

    // Check if the email ends with '@sode-edu.in'
    if (!str_ends_with($email, '@sode-edu.in')) {
        echo "<script>
                alert('Only emails ending with @sode-edu.in are allowed.');
                window.history.back();
              </script>";
        exit;
    }

    // Database connection details
    $servername = "localhost";
    $username = "root"; // Update if your database username is different
    $dbpassword = "";   // Update if your database password is different
    $dbname = "fac"; // Database name

    // Create a database connection
    $conn = new mysqli($servername, $username, $dbpassword, $dbname);

    // Check for connection errors
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Hash the password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // SQL query to insert data
    $sql = "INSERT INTO faculty (facultyID, name, email, password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // Bind parameters
        $stmt->bind_param("ssss", $facultyID, $name, $email, $hashedPassword);

        // Execute the statement
        if ($stmt->execute()) {
            echo "<script>
                    alert('Sign up successful! Redirecting to login page...');
                    window.location.href = 'faclogin.html';
                  </script>";
        } else {
            // Handle errors during execution
            echo "<script>
                    alert('Error: Could not sign up. " . $stmt->error . "');
                    window.history.back();
                  </script>";
        }

        // Close the statement
        $stmt->close();
    } else {
        // Handle errors preparing the statement
        echo "<script>
                alert('Error preparing the statement: " . $conn->error . "');
                window.history.back();
              </script>";
    }

    // Close the database connection
    $conn->close();
}
?>
