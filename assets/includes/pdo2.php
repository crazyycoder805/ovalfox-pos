<?php
class NewPDO {

    public $validationErr = [];
    public function upload($fileInputName, $uploadDirectory, $customFilename = null, $sanitizeFilename = true, $allowedFileTypes = ['image/jpeg', 'image/jpg', 'image/png'], $maxFileSize = 10485760)
    {
        
        // Check if the file input is set
        if (!isset($_FILES[$fileInputName])) {
            $this->validationErr[] = "File input not set.";
            return false; // File upload failed.
        }
       
        $files = $_FILES[$fileInputName];
     
        // If $fileInputName is an array, handle multiple file uploads
        if (is_array($files['name'])) {
            $uploadResults = [];

            foreach ($files['name'] as $key => $name) {
                $file = [
                    'name' => $files['name'][$key],
                    'type' => $files['type'][$key],
                    'tmp_name' => $files['tmp_name'][$key],
                    'error' => $files['error'][$key],
                    'size' => $files['size'][$key]
                ];

                // Handle each file individually
                $result = $this->handleFileUpload($file, $uploadDirectory, $customFilename, $sanitizeFilename, $allowedFileTypes, $maxFileSize);

                if ($result !== false) {
                    // File uploaded successfully, add information to the results array
                    $uploadResults[] = $result;
                }
            }
          
            // Return the results for all uploaded files
            return $uploadResults;
        } else {
            
            // Handle single file upload
            return $this->handleFileUpload($files, $uploadDirectory, $customFilename, $sanitizeFilename, $allowedFileTypes, $maxFileSize);
        }
    }

    private function handleFileUpload($file, $uploadDirectory, $customFilename, $sanitizeFilename, $allowedFileTypes, $maxFileSize)
    {
        // Check for errors during file upload
        if ($file['error'] !== UPLOAD_ERR_OK) {
            $this->validationErr[] = "File upload error: " . $file['error'];
            return false; // File upload failed.
        }
       
        // Check if the uploaded file is a valid type
        $fileType = mime_content_type($file['tmp_name']);
       
        if (!in_array($fileType, $allowedFileTypes)) {
            $this->validationErr[] = "Invalid file type.";
            return false; // File upload failed.
        }

        // Check if the file size is within the allowed limit
        if ($file['size'] > $maxFileSize) {
            $this->validationErr[] = "File size exceeds the maximum allowed size.";
            return false; // File upload failed.
        }

        // Determine the file extension from the uploaded file's name
        $originalFilename = $file['name'];
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
        if (!move_uploaded_file($file['tmp_name'], $destination)) {
            $this->validationErr[] = "File upload failed.";
            return false; // File upload failed.
        }
        // echo "<pre>";
        // print_r([
        //     'original_filename' => $originalFilename,
        //     'filename' => $filename,
        //     'filepath' => $destination,
        //     'filetype' => $fileType,
        //     'filesize' => $file['size'],
        // ]);
        // echo "</pre>";
        // Return success (1) and the uploaded file's information
        return [
            'original_filename' => $originalFilename,
            'filename' => $filename,
            'filepath' => $destination,
            'filetype' => $fileType,
            'filesize' => $file['size'],
        ];

    }

    private function sanitizeFilename($filename)
        {
            $filename = preg_replace("/[^a-zA-Z0-9_.-]/", "", $filename);
        

    }

}

$pdo2 = new NewPDO();