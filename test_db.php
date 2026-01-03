<?php
// test_db.php
include 'includes/db.php';

if ($conn) {
    echo "<h1>✅ Database Connection Successful!</h1>";
    echo "<p>Connected to database: <strong>fowzi_store</strong></p>";
} else {
    echo "<h1>❌ Connection Failed</h1>";
    echo "<p>" . $conn->connect_error . "</p>";
}
?>
