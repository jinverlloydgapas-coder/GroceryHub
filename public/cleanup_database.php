<?php

// Simple database cleanup script
$host = '127.0.0.1';
$user = 'root';
$password = '';
$database = 'grocery_db';

try {
    $conn = new mysqli($host, $user, $password, $database);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    // Tables to drop (unused)
    $tables_to_drop = ['cache', 'jobs', 'job_batches', 'failed_jobs'];
    
    echo "<style>body { font-family: Arial, sans-serif; padding: 20px; background: #f5f5f5; }</style>";
    echo "<h1>🧹 Database Cleanup</h1>";
    echo "<hr>";
    
    foreach ($tables_to_drop as $table) {
        $sql = "DROP TABLE IF EXISTS `" . $conn->real_escape_string($table) . "`";
        if ($conn->query($sql) === TRUE) {
            echo "<p style='color: green;'>✓ Dropped table: <strong>$table</strong></p>";
        } else {
            echo "<p style='color: red;'>✗ Error dropping table $table: " . $conn->error . "</p>";
        }
    }
    
    // Show remaining tables
    echo "<hr>";
    echo "<h2>📊 Remaining tables in database:</h2>";
    echo "<ul>";
    $result = $conn->query("SHOW TABLES;");
    if ($result) {
        while ($row = $result->fetch_row()) {
            echo "<li><strong>" . htmlspecialchars($row[0]) . "</strong></li>";
        }
    }
    echo "</ul>";
    
    $conn->close();
    echo "<hr>";
    echo "<p style='color: green; font-size: 18px;'><strong>✅ Database cleanup complete!</strong></p>";
    echo "<p><a href='/' style='color: #0066cc;'>Back to Dashboard</a></p>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
}
?>
