<?php
$hostname = "localhost";
$username = "root";
$password = "";
$database = "gas_leak_detection";

$conn = mysqli_connect($hostname, $username, $password, $database);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

echo "Database connection is OK!<br>";

// Check if the required POST variables are set
if (isset($_POST["GasLevel"], $_POST["Buzzer"], $_POST["Lampu_Bahaya"], $_POST["Lampu_Aman"])) {
    
    // Assign the POST variables to local PHP variables
    $GasLevel = $_POST["GasLevel"];
    $Buzzer = $_POST["Buzzer"];
    $Lampu_Bahaya = $_POST["Lampu_Bahaya"];
    $Lampu_Aman = $_POST["Lampu_Aman"];

    // Prepare the SQL statement with the correct variables
    $sql = "INSERT INTO gas_leak1 (`Gas Level`, Buzzer, `Lampu BAHAYA`, `Lampu AMAN`) 
            VALUES ('$GasLevel', '$Buzzer', '$Lampu_Bahaya', '$Lampu_Aman')";
    
    // Execute the query and check if it's successful
    if (mysqli_query($conn, $sql)) {
        echo "New record created successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
} else {
    echo "Error: Missing required input fields.";
}

?>
