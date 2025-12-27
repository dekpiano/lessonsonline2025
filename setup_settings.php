<?php
include_once 'php/Database/Database.php';

$database = new Database();
$db = $database->getConnection();

$sql = "CREATE TABLE IF NOT EXISTS tb_settings (
    setting_name VARCHAR(100) PRIMARY KEY,
    setting_value TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

try {
    $db->exec($sql);
    echo "Table tb_settings created successfully.\n";
    
    // Insert default value if not exists
    $sqlInsert = "INSERT IGNORE INTO tb_settings (setting_name, setting_value) VALUES ('max_courses_per_teacher', '10')";
    $db->exec($sqlInsert);
    echo "Default setting inserted.\n";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
