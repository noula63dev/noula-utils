<?php

//upload.php

$file = '';

if(isset($_FILES['file']['name']))
{
 $file_name = $_FILES['file2']['name'];
 $valid_extensions = array("docx","xlsx","jpg","jpeg","png");
 $extension = pathinfo($file_name, PATHINFO_EXTENSION);
 if(in_array($extension, $valid_extensions))
 {
  $upload_path = 'resources/' . $file_name . '.' . $extension;
  if(move_uploaded_file($_FILES['file']['tmp_name'], $upload_path))
  {
   $message = 'File Uploaded';
   $file = $upload_path;
  }
  else
  {
   $message = 'There is an error while uploading file';
  }
 }
 else
 {
  $message = 'Only .docx, .xlsx, .jpg, .jpeg and .png File allowed to upload';
 }
}
else
{
 $message = 'Select File';
}

$output = array(
 'message'  => $message,
 'file'   => $file
);

echo json_encode($output);


?>