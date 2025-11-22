<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>XAMPP Stack - Welcome</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            text-align: center;
            margin-bottom: 30px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin: 30px 0;
        }
        .info-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            border-left: 4px solid #007bff;
        }
        .info-card h3 {
            margin: 0 0 10px 0;
            color: #333;
        }
        .info-card p {
            margin: 0;
            color: #666;
        }
        .links {
            text-align: center;
            margin-top: 30px;
        }
        .links a {
            display: inline-block;
            margin: 10px;
            padding: 10px 20px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            transition: background 0.3s;
        }
        .links a:hover {
            background: #0056b3;
        }
        .status {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>🚀 XAMPP Stack is Running!</h1>
        
        <div class="status">
            <strong>✅ Apache Server is working correctly!</strong><br>
            Your XAMPP Docker stack is up and running on port 8011.
        </div>

        <div class="info-grid">
            <div class="info-card">
                <h3>🐘 PHP Info</h3>
                <p>PHP Version: <?php echo phpversion(); ?></p>
                <p>Server: <?php echo $_SERVER['SERVER_SOFTWARE']; ?></p>
            </div>
            
            <div class="info-card">
                <h3>🗂️ Document Root</h3>
                <p><?php echo $_SERVER['DOCUMENT_ROOT']; ?></p>
            </div>
            
            <div class="info-card">
                <h3>⏰ Server Time</h3>
                <p><?php echo date('Y-m-d H:i:s'); ?></p>
                <p>Timezone: <?php echo date_default_timezone_get(); ?></p>
            </div>
            
            <div class="info-card">
                <h3>🌐 Request Info</h3>
                <p>Host: <?php echo $_SERVER['HTTP_HOST']; ?></p>
                <p>Method: <?php echo $_SERVER['REQUEST_METHOD']; ?></p>
            </div>
        </div>

        <div class="links">
            <a href="/practice/">Practice Directory</a>
            <a href="http://localhost:8080" target="_blank">phpMyAdmin</a>
            <a href="/phpinfo.php">PHP Info</a>
        </div>

        <h2>📁 Available Directories</h2>
        <ul>
            <?php
            $directories = glob('./*', GLOB_ONLYDIR);
            if (empty($directories)) {
                echo '<li>No subdirectories found</li>';
            } else {
                foreach ($directories as $dir) {
                    $dirName = basename($dir);
                    echo '<li><a href="/' . $dirName . '/">' . $dirName . '/</a></li>';
                }
            }
            ?>
        </ul>
    </div>
</body>
</html>