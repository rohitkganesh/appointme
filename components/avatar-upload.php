

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload Avatar</title>
    <link rel="stylesheet" href="../Styles/dashboard.css">
    <link rel="stylesheet" href="../Styles/style-prev.css">
</head>
<body>
    <h2>Upload Avatar</h2>
    <form action="../components/avatar.php" method="post" enctype="multipart/form-data">
        <input  type="file" name="avatar" accept="image/*" required>
        <button class='logout-btn' type="submit" name="upload">Upload</button>
    </form>
</body>
</html>
