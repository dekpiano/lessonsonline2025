<?php

class ClassUploader {
    private $targetDirectory = "../../../../uploads/";
    private $maxFileSize = 5000000; // 5MB
    private $allowedTypes = ['jpg' => 'image/jpeg', 'png' => 'image/png', 'gif' => 'image/gif'];
    private $fileName;
    private $imageFileType;
    private $fileTempName;
    private $newWidth;
    private $newHeight;
    private $Directory;

    public function __construct($filename,$tmpname, $newWidth,$Directory) {
        $this->fileName = basename($filename);
        $this->imageFileType = strtolower(pathinfo($this->fileName, PATHINFO_EXTENSION));
        $this->fileTempName = $tmpname;
        $this->newWidth = $newWidth;
        $this->Directory = $Directory;

        if (!is_dir($this->targetDirectory.$Directory."/")) {
            mkdir($this->targetDirectory.$Directory."/", 0777, true);
        }

        //$this->newHeight = $newHeight;
    }

    public function upload() {
        // Check if image file is a actual image or fake image
        // $check = getimagesize($this->fileTempName);
        // if($check === false) {
        //     return json_encode(['Msg'=>0,'Text'=> "File is not an image."]);
        // }

        // Check file size
        // if ($_FILES["CourseImage"]["size"] > $this->maxFileSize) {
        //     return json_encode(['Msg'=>0,'Text'=> "Sorry, your file is too large"]);
        // }

        // Allow certain file formats
        if(!array_key_exists($this->imageFileType, $this->allowedTypes)) {
            return json_encode(['Msg'=>0,'Text'=> ""]);
        }

        // Check if file already exists
        if (file_exists($this->targetDirectory.$this->Directory."/". $this->fileName)) {
            return json_encode(['Msg'=>0,'Text'=> "Sorry, file already exists."]);
        }

        $newFilePath = $this->generateNewFileName();
        if (move_uploaded_file($this->fileTempName, $newFilePath)) {
            $this->resizeImage($newFilePath);
            return json_encode(['Msg'=>1,'Text'=>basename($newFilePath)]);
        } else {
            return json_encode(['Msg'=>1,'Text'=>basename($newFilePath)]);
        }
    }

    private function resizeImage($newFilePath) {
        list($originalWidth, $originalHeight) = getimagesize($newFilePath);
        // คำนวณความสูงใหม่โดยรักษาอัตราส่วนด้านของภาพ
        $newHeight = ($this->newWidth / $originalWidth) * $originalHeight;
    
        $thumb = imagecreatetruecolor($this->newWidth, $newHeight);
        $source = $this->createImageFromType($newFilePath);
    
        // Resize
        imagecopyresampled($thumb, $source, 0, 0, 0, 0, $this->newWidth, $newHeight, $originalWidth, $originalHeight);
    
        // Save resized image
        $this->saveImage($thumb, $newFilePath);
    }

    private function createImageFromType($filepath) {
        switch ($this->imageFileType) {
            case 'jpg':
            case 'jpeg':
                return imagecreatefromjpeg($filepath);
            case 'png':
                return imagecreatefrompng($filepath);
            case 'gif':
                return imagecreatefromgif($filepath);
        }
    }

    private function saveImage($image, $filepath) {
        switch ($this->imageFileType) {
            case 'jpg':
            case 'jpeg':
                imagejpeg($image, $filepath);
                break;
            case 'png':
                imagepng($image, $filepath);
                break;
            case 'gif':
                imagegif($image, $filepath);
                break;
        }
    }

    private function generateNewFileName() {
        // Generate a unique name for the image: use time and random number
        $newFileName = time() . '-' . rand(1000, 9999) . '.' . $this->imageFileType;
        return $this->targetDirectory.$this->Directory."/".$newFileName;
    }

    public function deleteImage($filePath) {
        // ตรวจสอบว่าไฟล์มีอยู่จริง
        if (file_exists($filePath)) {
            // ลบไฟล์
            if (unlink($filePath)) {
                return "ไฟล์ถูกลบแล้ว";
            } else {
                return "เกิดข้อผิดพลาดในการลบไฟล์";
            }
        } else {
            return "ไม่มีไฟล์นี้อยู่";
        }
    }
    
}

?>
