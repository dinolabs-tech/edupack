<?php

class AdmissionSettings {
    private $conn;

    public function __construct($db_connection) {
        $this->conn = $db_connection;
        $this->createSettingsTable();
    }

    private function createSettingsTable() {
        $sql = "CREATE TABLE IF NOT EXISTS admission_settings (
            id INT AUTO_INCREMENT PRIMARY KEY,
            setting_name VARCHAR(255) NOT NULL UNIQUE,
            setting_value TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
        if ($this->conn->query($sql) === TRUE) {
            // Check if 'registration_cost' setting exists, if not, insert a default value
            $this->insertDefaultSetting('registration_cost', '0.00', 's');
            $this->insertDefaultSetting('flutterwave_public_key', '', 's');
            $this->insertDefaultSetting('flutterwave_secret_key', '', 's');
        } else {
            error_log("Error creating admission_settings table: " . $this->conn->error);
        }
    }

    private function insertDefaultSetting($setting_name, $default_value, $type) {
        $stmt = $this->conn->prepare("SELECT setting_value FROM admission_settings WHERE setting_name = ?");
        $stmt->bind_param("s", $setting_name);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows == 0) {
            $insert_stmt = $this->conn->prepare("INSERT INTO admission_settings (setting_name, setting_value) VALUES (?, ?)");
            $insert_stmt->bind_param("s" . $type, $setting_name, $default_value);
            $insert_stmt->execute();
            $insert_stmt->close();
        }
        $stmt->close();
    }

    public function getSetting($setting_name) {
        $stmt = $this->conn->prepare("SELECT setting_value FROM admission_settings WHERE setting_name = ?");
        $stmt->bind_param("s", $setting_name);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $stmt->close();
            return $row['setting_value'];
        }
        $stmt->close();
        return null;
    }

    public function saveSetting($setting_name, $setting_value) {
        $stmt = $this->conn->prepare("INSERT INTO admission_settings (setting_name, setting_value) VALUES (?, ?) ON DUPLICATE KEY UPDATE setting_value = ?");
        $stmt->bind_param("sss", $setting_name, $setting_value, $setting_value);
        if ($stmt->execute()) {
            $stmt->close();
            return true;
        }
        error_log("Error saving setting: " . $this->conn->error);
        $stmt->close();
        return false;
    }
}

?>
