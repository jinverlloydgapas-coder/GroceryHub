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
    
    foreach ($tables_to_drop as $table) {
        $sql = "DROP TABLE IF EXISTS `" . $conn->real_escape_string($table) . "`";
        if ($conn->query($sql) === TRUE) {
            echo "✓ Dropped table: $table\n";
        } else {
            echo "✗ Error dropping table $table: " . $conn->error . "\n";
        }
    }
    
    // Show remaining tables
    echo "\n📊 Remaining tables in database:\n";
    $result = $conn->query("SHOW TABLES;");
    if ($result) {
        while ($row = $result->fetch_row()) {
            echo "  - " . $row[0] . "\n";
        }
    }
    
    $conn->close();
    echo "\n✅ Database cleanup complete!\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
