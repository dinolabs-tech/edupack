<?php
function deleteFolder($folderPath) {
    if (!is_dir($folderPath)) {
        echo "Folder does not exist.";
        return;
    }

    $items = scandir($folderPath);
    foreach ($items as $item) {
        if ($item === '.' || $item === '..') {
            continue;
        }

        $path = $folderPath . DIRECTORY_SEPARATOR . $item;
        if (is_dir($path)) {
            deleteFolder($path); // Recursively delete subfolder
        } else {
            unlink($path); // Delete file
        }
    }

    if (rmdir($folderPath)) {
        echo "Folder 'eduhive' deleted successfully.";
    } else {
        echo "Failed to delete the folder.";
    }
}

// Adjust the folder path if needed
deleteFolder(__DIR__ . '/eduhive');
?>
