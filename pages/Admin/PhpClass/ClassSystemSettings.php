<?php
class ClassSystemSettings {
    private $conn;
    private $table_name = "tb_settings";

    public function __construct($db) {
        $this->conn = $db;
        $this->initializeTable();
    }

    // Auto-create table if not exists (Simple Migration)
    private function initializeTable() {
        $check = $this->conn->query("SHOW TABLES LIKE '" . $this->table_name . "'");
        if ($check->rowCount() == 0) {
            $sql = "CREATE TABLE " . $this->table_name . " (
                setting_name VARCHAR(100) PRIMARY KEY,
                setting_value TEXT,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )";
            $this->conn->exec($sql);
            
            // Insert default
            $this->updateSetting('max_courses_per_teacher', '10');
        }
    }

    public function getSetting($name, $default = null) {
        $query = "SELECT setting_value FROM " . $this->table_name . " WHERE setting_name = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$name]);
        
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            return $row['setting_value'];
        }
        return $default;
    }

    public function updateSetting($name, $value) {
        // Insert or Update (Upsert)
        $query = "INSERT INTO " . $this->table_name . " (setting_name, setting_value) VALUES (?, ?) 
                  ON DUPLICATE KEY UPDATE setting_value = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$name, $value, $value]);
    }
}
?>
