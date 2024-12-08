<?php
$email = $_GET['email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validate Identity</title>
</head>
<body>
    <h2>Validate Identity</h2>
    <form action="validate_identity_action.php" method="POST">
        <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
        <label for="birthdate">Birthdate:</label>
        <input type="date" id="birthdate" name="birthdate" required><br><br>
        
        <label for="fav_color">Favorite Color:</label>
        <input type="text" id="fav_color" name="fav_color" required><br><br>
        
        <button type="submit">Validate</button>
    </form>
</body>
</html>
