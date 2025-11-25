<? require_once "includes/db.inc.php"; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>List</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 13px;
        }

        table,
        th,
        td {
            border: 1px solid #808080;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 4px;
            text-align: left;
        }

        a {
            color: black;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
            color: blue;
        }
    </style>
    <script>
        function handleClick(bookid) {
            document.querySelector('#bookid').value = bookid;
            document.querySelector('#opr').value = 'edit';
            document.querySelector('form').submit();
        }
    </script>
</head>

<body>
    <pre><? isset($_POST['bookid']) ? print_r($_POST) : '' ?></pre>

    <?
    $opr = $_POST['opr'] ?? 'list';
    
    if ($opr === 'edit') {


        $query = "SELECT * FROM books WHERE bookid = :bookid";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':bookid', $_POST['bookid']);
        $stmt->execute();
        $book = $stmt->fetch();


        if ($book) {
            ?>
            <h2>Edit Book ID <?= $book['bookid'] ?></h2>
            <form method="post" >
                <input type="hidden" name="bookid" value="<?= $book['bookid'] ?>">
                <label>Title:</label><br>
                <textarea name="title"><?= htmlspecialchars($book['title']) ?></textarea><br><br>
                <input type="text" name="opr" id="opr">
                <input type="submit" value="Save Changes">
            </form>
        <? }
    } ?>

    <?
    if ($opr === 'list') {
    
    
    $rows = $conn->query("SELECT * FROM books LIMIT 10")->fetchAll();
    ?>
    <form method="post">
        <input type="text" name="bookid" id="bookid" placeholder="Book ID">
        <input type="text" name="opr" id="opr">
    </form>
    <h1>List</h1>
    <table>
        <thead>
            <tr>
                <th>Book ID</th>
                <th>Title</th>
            </tr>
        </thead>
        <tbody>
            <?
            foreach ($rows as $row) { ?>
                <tr>
                    <td><?= $row['bookid'] ?></td>
                    <td>
                        <a href="#" onclick="handleClick(<?= $row['bookid'] ?>)">
                            <?= $row['title'] ?>
                        </a>
                    </td>

                </tr>
            <? }
            ?>
        </tbody>
    </table>
    <? } ?>
</body>

</html>