<?php
// Initialize variables
$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "fac";

    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Sanitize inputs
    $email = trim($_POST['email']);
    $birthdate = trim($_POST['birthdate']);
    $fav_color = strtolower(trim($_POST['fav_color'])); // Normalize input

    // Debugging: Log inputs (optional)
    // echo "Email: $email, Birthdate: $birthdate, Favorite Color: $fav_color";

    // Prepare the SQL statement
    $sql = "SELECT * FROM faculty WHERE email = ? AND birthdate = ? AND LOWER(fav_color) = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing SQL statement: " . $conn->error);
    }
    $stmt->bind_param("sss", $email, $birthdate, $fav_color);

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if record exists
    if ($result->num_rows > 0) {
        // Redirect to reset password page
        header("Location: resetpass.php?email=" . urlencode($email));
        exit;
    } else {
        $error = "Validation failed. Please check your information.";
    }

    // Close resources
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validate Identity</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(150deg, #f6f8f7, #43324f, #f6f8f7);
            color: #fff;
        }

        .validate-container {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.9), rgba(230, 230, 250, 0.9));
            border-radius: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
            padding: 40px 30px;
            width: 100%;
            max-width: 400px;
            text-align: center;
            position: relative;
        }

        .validate-container h2 {
            font-size: 2em;
            color: #333;
            margin-bottom: 20px;
        }

        .validate-container label {
            display: block;
            margin-bottom: 8px;
            color: #444;
            font-weight: bold;
        }

        .validate-container input[type="date"],
        .validate-container input[type="text"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 10px;
            border: 2px solid #ccc;
            border-radius: 10px;
            font-size: 1em;
            box-sizing: border-box;
            transition: border 0.3s, box-shadow 0.3s;
        }

        .validate-container input[type="date"]:focus,
        .validate-container input[type="text"]:focus {
            border-color: #6a11cb;
            box-shadow: 0 0 8px rgba(106, 17, 203, 0.5);
        }

        .validate-container button {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            color: #fff;
            border: none;
            padding: 12px 20px;
            font-size: 1em;
            cursor: pointer;
            border-radius: 10px;
            transition: transform 0.3s, box-shadow 0.3s;
            width: 100%;
        }

        .validate-container button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        .validate-container .error {
            color: red;
            font-size: 0.9em;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="validate-container">
        <h2>Validate Identity</h2>
        <form action="" method="POST">
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($_GET['email'] ?? ''); ?>">
            <label for="birthdate">Birthdate:</label>
            <input type="date" id="birthdate" name="birthdate" required>
            
            <label for="fav_color">Favorite Color:</label>
            <input type="text" id="fav_color" name="fav_color" placeholder="Enter your favorite color" required>
            
            <?php if (!empty($error)): ?>
                <div class="error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
             
            <button type="submit">Validate</button>
        </form>
    </div>
</body>
</html>
