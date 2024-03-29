<?php

class CRUDPDO
{
    private $db;

    public $validationErr = [];

    public function __construct($host, $dbname, $username, $password)
    {
        try {
            $this->db = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, array(PDO::ATTR_PERSISTENT => true));
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    private function getFileContent($fileInputName)
{
    if (is_array($fileInputName)) {
        // Assuming the first element of the array should be used
        $fileInputName = reset($fileInputName);
    }

    if (isset($_FILES[$fileInputName]) && $_FILES[$fileInputName]['error'] === UPLOAD_ERR_OK) {
        return file_get_contents($_FILES[$fileInputName]['tmp_name']);
    }

    return null;
}

public function create($table, $data, $fileInputName = null, $imageColumns = null, $imageExtensionColumns = null)
{
    try {
        $fields = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));

        // If file input name is provided, retrieve file content
        $imageData = ($fileInputName !== null) ? $this->getFileContent($fileInputName) : null;

        // If image data is provided, add image columns to the query
        if ($imageData !== null && is_array($imageColumns)) {
            $fields .= ', ' . implode(', ', $imageColumns);
            $placeholders .= ', :' . implode(', :', $imageColumns);
        }

        // If image extension columns are provided, add them to the query
        if ($imageData !== null && is_array($imageExtensionColumns)) {
            foreach ($imageExtensionColumns as $column) {
                $fields .= ', ' . $column;
                $placeholders .= ', :' . $column;
            }
        }

        $query = "INSERT INTO $table ($fields) VALUES ($placeholders)";
        $stmt = $this->db->prepare($query);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        // If file input name is provided, bind image parameters
        if ($imageData !== null && is_array($imageColumns)) {
            foreach ($imageColumns as $column) {
                $stmt->bindValue(":$column", $imageData);
            }
        }

        // If image extension columns are provided, bind their parameters
        if ($imageData !== null && is_array($imageExtensionColumns)) {
            foreach ($imageExtensionColumns as $column) {
                $extension = $_FILES["image"]["type"];
                $stmt->bindValue(":$column", $extension);
            }
        }

        $stmt->execute();
        return $this->db->lastInsertId();
    } catch (PDOException $e) {
        die("Create failed: " . $e->getMessage());
    }
}

public function update($table, $conditions = [], $data = [], $fileInputName = null, $imageColumns = null, $imageExtensionColumns = null)
{
    // Check if there is data to update
    if (empty($data)) {
        return 0; // No data to update
    }

    // If file input name is provided, retrieve file content
    $imageData = ($fileInputName !== null) ? $this->getFileContent($fileInputName) : null;

    // If image data is provided, add image columns to the query
    if ($imageData !== null && is_array($imageColumns)) {
        $data += array_combine($imageColumns, array_fill(0, count($imageColumns), $imageData));
    }

    // If image extension columns are provided, add them to the query
    if ($imageData !== null && is_array($imageExtensionColumns)) {
        foreach ($imageExtensionColumns as $column) {

            $data[$column] = $_FILES[$fileInputName]["type"];

        }
    }

    // Build the SET clause for updating data
    $setClause = implode(', ', array_map(function ($key) {
        return "$key = :$key";
    }, array_keys($data)));

    // Build the WHERE clause for conditions
    $whereClause = '';
    if (!empty($conditions)) {
        $whereClause = "WHERE " . implode(' AND ', array_map(function ($key) {
            return "$key = :$key";
        }, array_keys($conditions)));
    }

    // Construct the SQL query
    $query = "UPDATE $table SET $setClause $whereClause";

    $stmt = $this->db->prepare($query);

    // Bind values for updating data
    foreach ($data as $key => $value) {
        $stmt->bindValue(":$key", $value);
    }

    // Bind values for conditions
    foreach ($conditions as $key => $value) {
        $stmt->bindValue(":$key", $value);
    }

    if ($stmt->execute()) {
        $rowCount = $stmt->rowCount();
        return $rowCount > 0 ? 1 : 0; // Return 1 if rows were affected, otherwise 0
    } else {
        return 0; // Data not updated
    }
}

















private function getFileContentMulti($fileInputName)
{
    if (is_array($fileInputName)) {
        // Assuming the first element of the array should be used
        $fileInputName = reset($fileInputName);
    }

    if (isset($_FILES[$fileInputName]) && $_FILES[$fileInputName]['error'] === UPLOAD_ERR_OK) {
        return file_get_contents($_FILES[$fileInputName]['tmp_name']);
    }

    return null;
}

public function createMulti($table, $data, $fileInputName = null, $imageColumns = null, $imageExtensionColumns = null)
{
    try {
        $fields = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));

        // If file input name is provided, retrieve file content
        $imageData = ($fileInputName !== null) ? $this->getFileContentMulti($fileInputName) : null;

        // If image data is provided, add image columns to the query
        if ($imageData !== null && is_array($imageColumns)) {
            $fields .= ', ' . implode(', ', $imageColumns);
            $placeholders .= ', :' . implode(', :', $imageColumns);
        }

        // If image extension columns are provided, add them to the query
        if ($imageData !== null && is_array($imageExtensionColumns)) {
            foreach ($imageExtensionColumns as $column) {
                $fields .= ', ' . $column;
                $placeholders .= ', :' . $column;
            }
        }

        $query = "INSERT INTO $table ($fields) VALUES ($placeholders)";
        $stmt = $this->db->prepare($query);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        // If file input name is provided, bind image parameters
        if ($imageData !== null && is_array($imageColumns)) {
            foreach ($imageColumns as $column) {
                $stmt->bindValue(":$column", $imageData);
            }
        }

        // If image extension columns are provided, bind their parameters
        if ($imageData !== null && is_array($imageExtensionColumns)) {
            foreach ($imageExtensionColumns as $column) {
                $extension = $_FILES[$fileInputName]["type"];
                $stmt->bindValue(":$column", $extension);
            }
        }

        $stmt->execute();
        return 1;
    } catch (PDOException $e) {
        die("Create failed: " . $e->getMessage());
    }
}

    public function updateMulti($table, $conditions = [], $data = [], $fileInputName = null, $imageColumns = null, $imageExtensionColumns = null)
    {
        // Check if there is data to update
        if (empty($data)) {
            return 0; // No data to update
        }

        // If file input name is provided, retrieve file content
        if (is_array($fileInputName)) {
            $imageData = array_map([$this, 'getFileContent'], $fileInputName);
        } else {
            $imageData = $this->getFileContent($fileInputName);
        }

        // If image data is provided, add image columns to the query
        if ($imageData !== null && is_array($imageColumns)) {
            $imageDataArray = is_array($imageData) ? $imageData : array_fill(0, count($imageColumns), $imageData);
            $data += array_combine($imageColumns, $imageDataArray);
        }
        

        // If image extension columns are provided, add them to the query
        if ($imageData !== null && is_array($imageExtensionColumns)) {
            foreach ($imageExtensionColumns as $column) {
                $data[$column] = is_array($imageData) ? array_map(function ($file) {
                    return $_FILES[$file]["type"];
                }, (array)$fileInputName) : $_FILES[$fileInputName]["type"];
            }
            
        }

        // Build the SET clause for updating data
        $setClause = implode(', ', array_map(function ($key) {
            return "$key = :$key";
        }, array_keys($data)));

        // Build the WHERE clause for conditions
        $whereClause = '';
        if (!empty($conditions)) {
            $whereClause = "WHERE " . implode(' AND ', array_map(function ($key) {
                return "$key = :$key";
            }, array_keys($conditions)));
        }

        // Construct the SQL query
        $query = "UPDATE $table SET $setClause $whereClause";

        $stmt = $this->db->prepare($query);

        // Bind values for updating data
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        // Bind values for conditions
        foreach ($conditions as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        if ($stmt->execute()) {
            $rowCount = $stmt->rowCount();
            return $rowCount > 0 ? 1 : 0; // Return 1 if rows were affected, otherwise 0
        } else {
            return 0; // Data not updated
        }
    }





    public function mergeStrings(...$strings) {
        $mergedString = '';
        
        foreach ($strings as $str) {
            // Convert to lowercase and remove spaces
            $str = str_replace(' ', '', strtolower($str));
            
            // Merge the strings
            $mergedString .= $str;
        }
        
        return $mergedString;
    }
    





























    public function customQuery($sql)
    {
        try {
            $stmt = $this->db->query($sql);

            if ($stmt !== false) {
                $queryType = strtoupper(explode(' ', trim($sql))[0]);

                if ($queryType === 'SELECT') {
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                } elseif ($queryType === 'INSERT') {
                    return $this->db->lastInsertId();
                } else {
                    return $stmt->rowCount();
                }
            } else {
                return false;
            }
        } catch (PDOException $e) {
            die("Custom query failed: " . $e->getMessage());
        }
    }

    public function read($table, $conditions = [], $customSql = '')
    {
        try {
            $query = "SELECT * FROM $table";

            if (!empty($conditions)) {
                $query .= " WHERE ";
                $conditionsArr = [];

                foreach ($conditions as $field => $value) {
                    $conditionsArr[] = "$field = :$field";
                }

                $query .= implode(" AND ", $conditionsArr);
            }

            if (!empty($customSql)) {
                $query .= " " . $customSql;
            }

            $stmt = $this->db->prepare($query);

            foreach ($conditions as $field => $value) {
                $stmt->bindValue(":$field", $value);
            }

            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Read failed: " . $e->getMessage());
        }
    }



    


    public function updateAffected($table, $conditions = [], $data = [])
    {
        // Check if there is data to update
        if (empty($data)) {
            return 0; // No data to update
        }

        // Build the SET clause for updating data
        $setClause = implode(', ', array_map(function ($key) {
            return "$key = :$key";
        }, array_keys($data)));

        // Build the WHERE clause for conditions
        $whereClause = '';
        if (!empty($conditions)) {
            $whereClause = "WHERE " . implode(' AND ', array_map(function ($key) {
                return "$key = :$key";
            }, array_keys($conditions)));
        }

        // Construct the SQL query
        $query = "UPDATE $table SET $setClause $whereClause";

        $stmt = $this->db->prepare($query);

        // Bind values for updating data
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        // Bind values for conditions
        foreach ($conditions as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        if ($stmt->execute()) {
            // If the update was successful, query for the ID of the updated row
            $updatedRowId = $this->getUpdatedRowId($table, $conditions);
            return $updatedRowId;
        } else {
            return 0; // Data not updated
        }
    }

    // Helper function to get the ID of the updated row
    private function getUpdatedRowId($table, $conditions)
    {
        // Construct a SELECT query to retrieve the updated row ID
        $selectQuery = "SELECT id FROM $table WHERE ";
        $whereClause = implode(' AND ', array_map(function ($key) {
            return "$key = :$key";
        }, array_keys($conditions)));

        $selectQuery .= $whereClause;

        $stmt = $this->db->prepare($selectQuery);

        // Bind values for conditions
        foreach ($conditions as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        if ($stmt->execute()) {
            // Fetch the ID of the updated row
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row ? $row['id'] : 0;
        } else {
            return 0; // Unable to retrieve the updated row ID
        }
    }


    public function searchValue($array, $target)
    {
        $iterator = new RecursiveIteratorIterator(new RecursiveArrayIterator($array));
        foreach ($iterator as $key => $value) {
            if (is_array($target)) {
                $targetKey = isset($target['key']) ? $target['key'] : null;
                $targetValue = isset($target['value']) ? $target['value'] : null;

                if (($targetKey !== null && $key === $targetKey) || ($targetValue !== null && $value === $targetValue)) {
                    return true;
                }
            } elseif ($value === $target || $key === $target) {
                return true;
            }
        }
        return false;
    }

    public function outputImage($table, $imageId, $idColumnName = 'id', $imageColumns = ['image_data'], $imageExtensionColumn = 'image_type')
    {
        try {
            // Construct the SQL query to retrieve image data
            $selectQuery = "SELECT " . implode(', ', $imageColumns) . ", $imageExtensionColumn FROM $table WHERE $idColumnName = :id";
            $stmt = $this->db->prepare($selectQuery);
            $stmt->bindValue(":id", $imageId, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                // Output the image
                foreach ($imageColumns as $column) {
                    header("Content-type: " . $result[$imageExtensionColumn]);
                    echo $result[$column];
                }
            } else {
                // Image not found
                header("HTTP/1.0 404 Not Found");
                echo "Image not found.";
            }
        } catch (PDOException $e) {
            die("Output image failed: " . $e->getMessage());
        }
    }


    public function delete($table, $id, $idColumnName = 'id')
    {
        // Disable foreign key checks
        $disableFKQuery = "SET FOREIGN_KEY_CHECKS = 0;";
        $stmtDisableFK = $this->db->prepare($disableFKQuery);
        $stmtDisableFK->execute();

        // Your DELETE query with optional custom ID column name
        $query = "DELETE FROM $table WHERE $idColumnName = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(":id", $id, PDO::PARAM_INT);

        // Execute the query and return true if successful, false otherwise
        $success = $stmt->execute();

        // Enable foreign key checks
        $enableFKQuery = "SET FOREIGN_KEY_CHECKS = 1;";
        $stmtEnableFK = $this->db->prepare($enableFKQuery);
        $stmtEnableFK->execute();

        return $success; // Returns true if the DELETE query was successful, false otherwise
    }



    public function validateInput($input, $type)
    {
        $length = strlen($input);

        if ($type === 'username') {
            // Username-specific checks
            if ($length < 4 || $length > 20) {
                $this->validationErr[] = "Username must have 4 min length.";
                return false;
            }
        } elseif ($type === 'password') {
            // Password-specific checks
            if ($length < 8) {
                $this->validationErr[] = "Password must have 8 min length.";

                return false;
            }

            if (!preg_match('/[!@#$%^&*()\-_=+{};:,<.>]/', $input)) {
                $this->validationErr[] = "Password must have special characters.";
                return false;
            }

            if (!preg_match('/[0-9]/', $input)) {
                $this->validationErr[] = "Password must have numbers.";

                return false;
            }

            if (!preg_match('/[a-z]/', $input)) {
                $this->validationErr[] = "Password must have lowercase characters.";

                return false;
            }

            if (!preg_match('/[A-Z]/', $input)) {
                $this->validationErr[] = "Password must have uppercase characters.";

                return false;
            }
        } elseif ($type === 'email') {
            // Email-specific checks
            if (!filter_var($input, FILTER_VALIDATE_EMAIL)) {
                $this->validationErr[] = "Email must have valid format.";
                return false;
            }

            list($username, $domain) = explode('@', $input);

            if (!checkdnsrr($domain, 'MX')) {
                $this->validationErr[] = "Email must have valid domain DNS.";

                return false;
            }
        } elseif ($type === 'firstname' || $type === 'lastname') {
            // First name and last name checks
            if (!preg_match('/^[a-zA-Z\s]+$/', $input)) {
                $this->validationErr[] = "" . $type === "firstname" ? "First name" : "Last name" . " must contain alphanumeric characters.";

                return false;
            }

            if ($length < 2) {
                $this->validationErr[] = "" . $type === "firstname" ? "First name" : "Last name" . " atleast contain 2 characters.";

                return false;
            }
        } elseif ($type === 'phone') {
            // Phone number checks
            $input = preg_replace('/[^0-9]/', '', $input);

            if (strlen($input) < 10) {
                $this->validationErr[] =  "Phone number must have 8 min charactes.";
                return false;
            }

            if (!ctype_digit($input)) {
                $this->validationErr[] =  "Phone number must number charactes.";

                return false;
            }
        } elseif ($type === 'cnic') {
            // CNIC-specific checks for PK CNIC
            $input = preg_replace('/[^0-9\-]/', '', $input); // Remove non-numeric characters except dashes

            if (strlen($input) !== 13 && strlen($input) !== 15) {
                $this->validationErr[] = "CNIC must be either 13 or 15 characters long.";
                return false;
            }

            if (preg_match('/^\d{5}-?\d{7}-?\d$/', $input)) {
                // Valid PK CNIC format
                return true;
            }


            // If the input doesn't match any known CNIC format
            $this->validationErr[] = "Invalid CNIC format for this country.";
            return false;
        } else {
            // Invalid type specified
            return false;
        }

        // If all checks pass, the input is valid
        return true;
    }


    public function checkEmptyFields($fields)
    {
        foreach ($fields as $field) {
            // Check if the field is set and not null
            if (!isset($field)) {
                $this->validationErr[] = "One or more fields are not set.";
                return false; // Found an unset field
            }

            // Trim each field to remove leading and trailing spaces
            $trimmedField = trim($field);

            // Check if the trimmed field is empty
            if (empty($trimmedField)) {
                $this->validationErr[] = "Please fill out all the fields";
                return false; // Found an empty field
            }
        }

        return true; // All fields are set and non-empty
    }


    public function isDataInserted($table, $data, $field = null)
    {
        $conditions = [];

        foreach ($data as $key => $value) {
            $conditions[] = "$key = :$key";
        }

        $query = "SELECT COUNT(*) FROM $table WHERE " . implode(" AND ", $conditions);
        $stmt = $this->db->prepare($query);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            $this->validationErr[] = $field . " is already registered";
        }

        return $count > 0; // Return true if the value exists, false otherwise
    }

    public function isDataInsertedUpdate($table, $data, $field = null)
    {
        $conditions = [];

        foreach ($data as $key => $value) {
            $conditions[] = "$key = :$key";
        }

        $query = "SELECT COUNT(*) FROM $table WHERE " . implode(" AND ", $conditions);
        $stmt = $this->db->prepare($query);

        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->execute();
        $count = $stmt->fetchColumn();

        if ($count > 1) {
            $this->validationErr[] = $field . " is already registered";
        }

        return $count > 1; // Return true if the value exists, false otherwise
    }

    public function updateAll($table, $conditions = [], $data = [])
    {
        // Check if there is data to update
        if (empty($data)) {
            return 0; // No data to update
        }

        // Build the SET clause for updating data
        $setClause = implode(', ', array_map(function ($key) {
            return "$key = :$key";
        }, array_keys($data)));

        // Build the WHERE clause for conditions
        $whereClause = '';
        if (!empty($conditions)) {
            $whereClause = "WHERE ";
            $conditionsArr = [];

            foreach ($conditions as $field => $value) {
                $conditionsArr[] = "$field = :$field";
            }

            $whereClause .= implode(' AND ', $conditionsArr);
        }

        // Construct the SQL query
        $query = "UPDATE $table SET $setClause $whereClause";

        $stmt = $this->db->prepare($query);

        // Bind values for updating data
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        // Bind values for conditions
        foreach ($conditions as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        if ($stmt->execute()) {
            return $stmt->rowCount(); // Return the number of affected rows
        } else {
            return 0; // Data not updated
        }
    }





    public function upload($fileInputName, $uploadDirectory, $customFilename = null, $sanitizeFilename = true, $allowedFileTypes = ['image/jpeg', 'image/jpg', 'image/png'], $maxFileSize = 10485760)
    {
        // Check if the file input is set
        if (!isset($_FILES[$fileInputName])) {
            $this->validationErr[] = "File input not set.";
            return false; // File upload failed.
        }

        // Check for errors during file upload
        $files = $_FILES[$fileInputName]; // Initialize $files here

        // Handle multiple file uploads
        if (is_array($files['name'])) {
            $fileCount = count($files['name']);
            $uploadResults = [];

            for ($i = 0; $i < $fileCount; $i++) {
                $file = [
                    'name' => $files['name'][$i],
                    'type' => $files['type'][$i],
                    'tmp_name' => $files['tmp_name'][$i],
                    'error' => $files['error'][$i],
                    'size' => $files['size'][$i]
                ];

                // Check for errors during file upload for each file
                if ($file['error'] !== UPLOAD_ERR_OK) {
                    $this->validationErr[] = "File upload error for '{$file['name']}': " . $file['error'];
                    continue; // Skip this file and proceed with the next one.
                }

                // Check if the uploaded file is a valid type
                $fileType = mime_content_type($file['tmp_name']);
                if (!in_array($fileType, $allowedFileTypes)) {
                    $this->validationErr[] = "Invalid file type for '{$file['name']}'.";
                    continue; // Skip this file and proceed with the next one.
                }

                // Check if the file size is within the allowed limit
                if ($file['size'] > $maxFileSize) {
                    $this->validationErr[] = "File size for '{$file['name']}' exceeds the maximum allowed size.";
                    continue; // Skip this file and proceed with the next one.
                }

                // Determine the file extension from the uploaded file's name
                $originalFilename = $file['name'];
                $extension = pathinfo($originalFilename, PATHINFO_EXTENSION);

                // Generate a filename
                if ($customFilename !== null) {
                    // Use the custom filename if provided and append the extension
                    $filename = $sanitizeFilename ? $this->sanitizeFilename($customFilename) : $customFilename;
                    $filename .= '-' . uniqid() . '.' . $extension; // Add a unique identifier to the filename
                } else {
                    // Generate a unique filename with the extracted extension to prevent overwriting
                    // Generate a unique filename with a timestamp to ensure uniqueness
                    $filename = uniqid() . '-' . time() . '-' . $this->sanitizeFilename($originalFilename);
                    $filename .= '.' . $extension;
                }

                $destination = $uploadDirectory . '/' . $filename;

                // Move the uploaded file to the destination directory
                if (!move_uploaded_file($file['tmp_name'], $destination)) {
                    $this->validationErr[] = "File upload failed for '{$file['name']}'.";
                } else {
                    // File uploaded successfully, add information to the results array
                    $uploadResults[] = [
                        'original_filename' => $originalFilename,
                        'filename' => $filename,
                        'filepath' => $destination,
                        'filetype' => $fileType,
                        'filesize' => $file['size'],
                    ];
                }
            }
            // Return the results for all uploaded files
            return $uploadResults;
        } else {
            // Handle a single file upload
            // Check for errors during file upload
            if ($files['error'] !== UPLOAD_ERR_OK) {
                $this->validationErr[] = "File upload error: " . $files['error'];
                return false; // File upload failed.
            }

            // Check if the uploaded file is a valid type
            $fileType = mime_content_type($files['tmp_name']);
            if (!in_array($fileType, $allowedFileTypes)) {
                $this->validationErr[] = "Invalid file type.";
                return false; // File upload failed.
            }

            // Check if the file size is within the allowed limit
            if ($files['size'] > $maxFileSize) {
                $this->validationErr[] = "File size exceeds the maximum allowed size.";
                return false; // File upload failed.
            }

            // Determine the file extension from the uploaded file's name
            $originalFilename = $files['name'];
            $extension = pathinfo($originalFilename, PATHINFO_EXTENSION);

            // Generate a filename
            if ($customFilename !== null) {
                // Use the custom filename if provided and append the extension
                $filename = $sanitizeFilename ? $this->sanitizeFilename($customFilename) : $customFilename;
                $filename .= '.' . $extension;
            } else {
                // Generate a unique filename with the extracted extension to prevent overwriting
                // Generate a unique filename with a timestamp to ensure uniqueness
                $filename = uniqid() . '-' . time() . '-' . $this->sanitizeFilename($originalFilename);
                $filename .= '.' . $extension;
            }

            $destination = $uploadDirectory . '/' . $filename;

            // Move the uploaded file to the destination directory
            if (!move_uploaded_file($files['tmp_name'], $destination)) {
                $this->validationErr[] = "File upload failed.";
                return false; // File upload failed.
            }

            // Return success (1) and the uploaded file's information
            return [
                'original_filename' => $originalFilename,
                'filename' => $filename,
                'filepath' => $destination,
                'filetype' => $fileType,
                'filesize' => $files['size'],
            ];
        }
    }



    public function headTo($head, $timer = 2000)
    {
        echo "<script>setTimeout(()=> location.href = '$head', $timer);</script>";
    }


    private function sanitizeFilename($filename)
    {
        $filename = preg_replace("/[^a-zA-Z0-9_.-]/", "", $filename);
        return $filename;
    }
    public function getFullURL() {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http";
        $host = $_SERVER['HTTP_HOST'];
        $uri = $_SERVER['REQUEST_URI'];
        return $protocol . "://" . $host . $uri;
    }

    public function getFileBaseNameURL() {
        $url = $this->getFullURL();

        $parsedUrl = parse_url($url);

        $fileName = basename($parsedUrl['path']);

        return $fileName;
    }

    public function __destruct()
    {
        // Close the database connection when the object is destroyed
        $this->db = null;
    }
}

// Usage example:
$dbHost = "localhost";
$dbName = "ovalfoxpos";
$dbUser = "root";
$dbPass = "";

$pdo = new CRUDPDO($dbHost, $dbName, $dbUser, $dbPass);