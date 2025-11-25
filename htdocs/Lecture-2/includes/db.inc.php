<? 
    define('DBHOST', 'mysql');
    define('DBUSER', 'root');
    define('DBPASS', 'root');
    define('DBNAME', 'lms');

    $dsn = 'mysql:host=' . DBHOST . ';dbname=' . DBNAME . ';charset=utf8mb4';
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        $conn = new PDO($dsn, DBUSER, DBPASS, $options);
    } catch (PDOException $e) {
        die('Connection Failed: ' . $e->getMessage());
    }
?>