<?
// Include database connection
include 'db.php';

// Fetch all records from LMS table
$sql = "SELECT * FROM books ORDER BY bookid DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LMS - Book List</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .header h1 {
            font-size: 2.5em;
            margin-bottom: 10px;
        }

        .header p {
            font-size: 1.1em;
            opacity: 0.9;
        }

        .content {
            padding: 30px;
        }

        .book-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .book-table thead {
            background: #f8f9fa;
        }

        .book-table th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #333;
            border-bottom: 2px solid #667eea;
        }

        .book-table td {
            padding: 15px;
            border-bottom: 1px solid #e0e0e0;
        }

        .book-table tbody tr {
            transition: background 0.3s ease;
        }

        .book-table tbody tr:hover {
            background: #f8f9fa;
        }

        .book-title {
            color: #667eea;
            text-decoration: none;
            font-weight: 500;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .book-title:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        .no-records {
            text-align: center;
            padding: 50px;
            color: #666;
            font-size: 1.2em;
        }

        .add-btn {
            display: inline-block;
            background: #667eea;
            color: white;
            padding: 12px 30px;
            border-radius: 25px;
            text-decoration: none;
            margin-bottom: 20px;
            transition: background 0.3s ease;
            font-weight: 500;
        }

        .add-btn:hover {
            background: #764ba2;
        }

        .status {
            padding: 5px 15px;
            border-radius: 15px;
            font-size: 0.9em;
            font-weight: 500;
        }

        .status-available {
            background: #d4edda;
            color: #155724;
        }

        .status-issued {
            background: #fff3cd;
            color: #856404;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📚 Library Management System</h1>
            <p>Browse and manage your book collection</p>
        </div>

        <div class="content">
            <a href="add.php" class="add-btn">➕ Add New Book</a>

            <? if (count($result) > 0): ?>
                <table class="book-table">
                    <thead>
                        <tr>
                            <th>Book ID</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>ISBN</th>
                            <th>Publisher</th>
                            <th>Year</th>
                            <th>Category</th>
                        </tr>
                    </thead>
                    <tbody>
                        <? foreach($result as $row): ?>
                            <tr>
                                <td><? echo htmlspecialchars($row['bookid']); ?></td>
                                <td>
                                    <a href="edit.php?id=<? echo $row['bookid']; ?>" class="book-title">
                                        <? echo htmlspecialchars($row['title']); ?>
                                    </a>
                                </td>
                                <td><? echo htmlspecialchars($row['author']); ?></td>
                                <td><? echo htmlspecialchars($row['isbn']); ?></td>
                                <td><? echo htmlspecialchars($row['publisher']); ?></td>
                                <td><? echo htmlspecialchars($row['year']); ?></td>
                                <td><? echo htmlspecialchars($row['category']); ?></td>
                            </tr>
                        <? endforeach; ?>
                    </tbody>
                </table>
            <? else: ?>
                <div class="no-records">
                    <p>📭 No books found in the library.</p>
                    <p style="margin-top: 10px; font-size: 0.9em;">Click "Add New Book" to get started!</p>
                </div>
            <? endif; ?>
        </div>
    </div>

<?
// Close connection (PDO closes automatically, but can be explicit)
$conn = null;
?>
</body>
</html>
