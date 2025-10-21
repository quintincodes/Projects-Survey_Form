<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Try to load the extension if not already loaded
if (!extension_loaded('mysqli')) {
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        dl('php_mysqli.dll');
    } else {
        dl('mysqli.so');
    }
}

// Database connection parameters
$servername = "localhost";
$username = "root";  // Change if your MySQL username is different
$password = "MySql1234";  // Change if your MySQL password is different
$dbname = "survey_db";

// Create connection
try {
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Process form submission
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Collect form data
        $name = isset($_POST['name']) ? $conn->real_escape_string($_POST['name']) : '';
        $age = isset($_POST['age']) ? intval($_POST['age']) : 0;
        $email = isset($_POST['email']) ? $conn->real_escape_string($_POST['email']) : '';
        $role = isset($_POST['role']) ? $conn->real_escape_string($_POST['role']) : '';
        
        // Handle file upload
        $picture_path = '';
        if(isset($_FILES['picture']) && $_FILES['picture']['error'] == 0) {
            $upload_dir = 'uploads/';
            
            // Create directory if it doesn't exist
            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }
            
            $filename = time() . '_' . basename($_FILES['picture']['name']);
            $target_path = $upload_dir . $filename;
            
            if(move_uploaded_file($_FILES['picture']['tmp_name'], $target_path)) {
                $picture_path = $target_path;
            }
        }
        
        $learning_preference = isset($_POST['learning_preference']) ? $conn->real_escape_string($_POST['learning_preference']) : '';
        $ai_usage = isset($_POST['ai_usage']) ? $conn->real_escape_string($_POST['ai_usage']) : '';
        $library_relevance = isset($_POST['library_relevance']) ? $conn->real_escape_string($_POST['library_relevance']) : '';
        $opinion = isset($_POST['opinion']) ? $conn->real_escape_string($_POST['opinion']) : '';
        
        // Handle checkbox arrays
        $tools = isset($_POST['tools']) ? implode(', ', $_POST['tools']) : '';
        $learning_resources = isset($_POST['learning_resources']) ? implode(', ', $_POST['learning_resources']) : '';
        
        $future = isset($_POST['future']) ? $conn->real_escape_string($_POST['future']) : '';
        
        // Insert data into database
        $sql = "INSERT INTO survey_entries (name, age, email, role, picture_path, learning_preference, 
                ai_usage, library_relevance, opinion, tools, learning_resources, future) 
                VALUES ('$name', $age, '$email', '$role', '$picture_path', '$learning_preference', 
                '$ai_usage', '$library_relevance', '$opinion', '$tools', '$learning_resources', '$future')";
        
        if ($conn->query($sql) === TRUE) {
            echo "<h1>Thank you for your submission!</h1>";
            echo "<p>Your survey response has been recorded.</p>";
            echo "<p><a href='index.html'>Return to survey form</a></p>";
        } else {
            echo "<h1>Error:</h1>";
            echo "<p>" . $conn->error . "</p>";
        }
    } else {
        // If accessed directly without POST data
        echo "<h1>Database connection successful!</h1>";
        echo "<p>The form processing script is ready.</p>";
        echo "<p><a href='index.html'>Go to survey form</a></p>";
    }
} catch (Exception $e) {
    die("Exception: " . $e->getMessage());
}

// Close the connection
$conn->close();
?>
