<?php
// Include database connection
include 'db.php';

$message = '';
$error = '';

// Get book ID from URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header('Location: list.php');
    exit();
}

$bookid = $_GET['id'];

// Handle form submission for update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
    try {
        $sql = "UPDATE books SET 
                title = :title,
                author = :author,
                isbn = :isbn,
                publisher = :publisher,
                year = :year,
                category = :category
                WHERE bookid = :bookid";
        
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':title' => $_POST['title'],
            ':author' => $_POST['author'],
            ':isbn' => $_POST['isbn'],
            ':publisher' => $_POST['publisher'],
            ':year' => $_POST['year'],
            ':category' => $_POST['category'],
            ':bookid' => $bookid
        ]);
        
        $message = "Book updated successfully!";
    } catch (PDOException $e) {
        $error = "Error updating book: " . $e->getMessage();
    }
}

// Handle delete request
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete'])) {
    try {
        $sql = "DELETE FROM books WHERE bookid = :bookid";
        $stmt = $conn->prepare($sql);
        $stmt->execute([':bookid' => $bookid]);
        
        header('Location: list.php?deleted=1');
        exit();
    } catch (PDOException $e) {
        $error = "Error deleting book: " . $e->getMessage();
    }
}

// Fetch book details
try {
    $sql = "SELECT * FROM books WHERE bookid = :bookid";
    $stmt = $conn->prepare($sql);
    $stmt->execute([':bookid' => $bookid]);
    $book = $stmt->fetch();
    
    if (!$book) {
        header('Location: list.php');
        exit();
    }
} catch (PDOException $e) {
    die("Error fetching book: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Book - <?php echo htmlspecialchars($book['title']); ?></title>
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
            max-width: 800px;
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
            font-size: 2em;
            margin-bottom: 10px;
        }

        .back-btn {
            display: inline-block;
            color: white;
            text-decoration: none;
            padding: 8px 20px;
            background: rgba(255,255,255,0.2);
            border-radius: 20px;
            margin-top: 10px;
            transition: background 0.3s ease;
        }

        .back-btn:hover {
            background: rgba(255,255,255,0.3);
        }

        .content {
            padding: 40px;
        }

        .message {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            font-weight: 500;
        }

        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1em;
            font-family: inherit;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
        }

        .form-group input[readonly] {
            background: #f8f9fa;
            color: #666;
            cursor: not-allowed;
        }

        .button-group {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn {
            flex: 1;
            padding: 15px;
            border: none;
            border-radius: 8px;
            font-size: 1em;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-update {
            background: #667eea;
            color: white;
        }

        .btn-update:hover {
            background: #5568d3;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .btn-delete {
            background: #dc3545;
            color: white;
        }

        .btn-delete:hover {
            background: #c82333;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.4);
        }

        .delete-confirm {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .delete-confirm.show {
            display: flex;
        }

        .confirm-dialog {
            background: white;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            max-width: 400px;
        }

        .confirm-dialog h3 {
            margin-bottom: 15px;
            color: #dc3545;
        }

        .confirm-dialog p {
            margin-bottom: 20px;
            color: #666;
        }

        .confirm-buttons {
            display: flex;
            gap: 10px;
        }

        .confirm-buttons button {
            flex: 1;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>✏️ Edit Book Details</h1>
            <a href="list.php" class="back-btn">← Back to List</a>
        </div>

        <div class="content">
            <?php if ($message): ?>
                <div class="message success"><?php echo $message; ?></div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="message error"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="form-group">
                    <label for="bookid">Book ID</label>
                    <input type="text" id="bookid" name="bookid" value="<?php echo htmlspecialchars($book['bookid']); ?>" readonly>
                </div>

                <div class="form-group">
                    <label for="title">Title *</label>
                    <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($book['title']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="author">Author *</label>
                    <input type="text" id="author" name="author" value="<?php echo htmlspecialchars($book['author']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="isbn">ISBN</label>
                    <input type="text" id="isbn" name="isbn" value="<?php echo htmlspecialchars($book['isbn']); ?>">
                </div>

                <div class="form-group">
                    <label for="publisher">Publisher</label>
                    <input type="text" id="publisher" name="publisher" value="<?php echo htmlspecialchars($book['publisher']); ?>">
                </div>

                <div class="form-group">
                    <label for="year">Publication Year</label>
                    <input type="number" id="year" name="year" value="<?php echo htmlspecialchars($book['year']); ?>" min="1000" max="2100">
                </div>

                <div class="form-group">
                    <label for="category">Category</label>
                    <input type="text" id="category" name="category" value="<?php echo htmlspecialchars($book['category']); ?>">
                </div>

                <div class="button-group">
                    <button type="submit" name="update" class="btn btn-update">💾 Update Book</button>
                    <button type="button" class="btn btn-delete" onclick="showDeleteConfirm()">🗑️ Delete Book</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Confirmation Dialog -->
    <div id="deleteConfirm" class="delete-confirm">
        <div class="confirm-dialog">
            <h3>⚠️ Confirm Delete</h3>
            <p>Are you sure you want to delete "<strong><?php echo htmlspecialchars($book['title']); ?></strong>"?</p>
            <p style="font-size: 0.9em; color: #dc3545;">This action cannot be undone!</p>
            <form method="POST" action="">
                <div class="confirm-buttons">
                    <button type="button" class="btn btn-update" onclick="hideDeleteConfirm()">Cancel</button>
                    <button type="submit" name="delete" class="btn btn-delete">Delete</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showDeleteConfirm() {
            document.getElementById('deleteConfirm').classList.add('show');
        }

        function hideDeleteConfirm() {
            document.getElementById('deleteConfirm').classList.remove('show');
        }
    </script>

<?php
// Close connection (PDO closes automatically, but can be explicit)
$conn = null;
?>
</body>
</html>
