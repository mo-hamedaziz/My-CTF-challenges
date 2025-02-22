<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Bash'n'Glob</title>
  <style type="text/css">
    html {
      background: radial-gradient(circle, #000, #200000);
    }
    body {
      max-width: 56rem;
      margin: auto;
      text-align: center;
      color: #F8E7E7;
      font-family: ui-monospace, monospace;
      font-size: 18px;
    }
    h1 {
      font-weight: 800;
      margin-bottom: 3rem;
      font-size: 48px;
      color: #FF3131;
      text-shadow: 0px 0px 15px #FF3131;
    }
    h2 {
      font-size: 30px;
      color: #FF5E5E;
      font-weight: 600;
      margin-top: 0;
    }
    p {
      margin: 0;
      color: #FF7B7B;
    }
    div {
      border-radius: 0.5rem;
      margin: 2rem;
      background: #1A0000;
      text-align: left;
      padding: 32px;
      box-shadow: 0px 10px 15px -3px #FF3131, 0px 4px 6px -4px #FF3131;
      border: 1px solid #600000;
    }
    .upload-container {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 1rem;
      padding: 20px;
      border: 2px solid #FF3131;
      border-radius: 8px;
      background: #300000;
      box-shadow: 0px 0px 10px #FF3131;
    }
    .file-input {
      display: none;
    }
    .custom-file-upload {
      background: #600000;
      color: #FF3131;
      padding: 12px 16px;
      border-radius: 8px;
      cursor: pointer;
      font-weight: bold;
      text-transform: uppercase;
      border: 2px solid #FF3131;
      box-shadow: 0px 0px 10px #FF3131;
      transition: all 0.3s ease-in-out;
    }
    .custom-file-upload:hover {
      background: #D60000;
      box-shadow: 0px 0px 15px #D60000;
    }
    #file-name {
      color: #FF7B7B;
      font-weight: bold;
    }
    input[type=submit] {
      background: #FF3131;
      color: #000;
      cursor: pointer;
      font-weight: bold;
      text-transform: uppercase;
      padding: 12px 16px;
      border-radius: 8px;
      box-shadow: 0px 0px 10px #FF3131;
      border: 2px solid #FF3131;
      transition: all 0.3s ease-in-out;
    }
    input[type=submit]:hover {
      background: #D60000;
      box-shadow: 0px 0px 15px #D60000;
    }
  </style>
</head>
<body>
<h1>Bash'n'Glob</h1>
<div>
  <h2>Love Letter Submission Portal</h2>
  <p>Write a heartfelt letter and upload it here 💌</p><br>
  <p><i>Security Notice: To prevent heartbreak, only simple text (.txt) files are allowed.</i></p>
  
  <form action="/" method="post" enctype="multipart/form-data">
    <div class="upload-container">
      <label for="file" class="custom-file-upload">Choose File</label>
      <input type="file" name="file" id="file" class="file-input" onchange="updateFileName()">
      <span id="file-name">No file chosen</span>
      <input type="submit" value="Submit File" name="submit">
    </div>
  </form>

  <?php
  if (isset($_FILES['file'])) {
    $uploadOk = 1;
    $target_dir = "/var/www/html/uploads/";
    $target_file = $target_dir . basename($_FILES["file"]["name"]);

    if (file_exists($target_file)) {
      echo "<p style='color:#FF3131;'>Error: File already exists.</p>";
      $uploadOk = 0;
    }
    if ($_FILES["file"]["size"] > 50000) {
      echo "<p style='color:#FF3131;'>Error: File is too large!</p>";
      $uploadOk = 0;
    }
    if (!str_ends_with($target_file, '.txt')) {
      echo "<p style='color:#FF3131;'>Error: Only .txt files are allowed due to previous exploit attempts.</p>";
      $uploadOk = 0;
    }

    if ($uploadOk == 0) {
      echo "<p style='color:#FF3131;'>File upload failed.</p>";
    } else {
      if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        echo "<p style='color:#7FFF00;'>Success: ". htmlspecialchars(basename($_FILES["file"]["name"])). " uploaded.</p>";
      } else {
        echo "<p style='color:#FF3131;'>Error: Upload failed.</p>";
      }
    }

    $old_path = getcwd();
    chdir($target_dir);
    shell_exec('chmod 000 *');
    chdir($old_path);
  }
  ?>
</div>

<script>
  function updateFileName() {
    const fileInput = document.getElementById('file');
    const fileNameDisplay = document.getElementById('file-name');
    fileNameDisplay.textContent = fileInput.files.length > 0 ? fileInput.files[0].name : "No file chosen";
  }
</script>

</body>
</html>
