<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $desc = $_POST['description'];
    $amount = $_POST['amount'];
    $category = $_POST['category'];

    $stmt = $conn->prepare("INSERT INTO expenses (description, amount, category) VALUES (?, ?, ?)");
    $stmt->bind_param("sds", $desc, $amount, $category);
    $stmt->execute();

    // Fetch all data
    $result = $conn->query("SELECT * FROM expenses ORDER BY created_at DESC");
    $data = [];
    $xml = new SimpleXMLElement('<expenses/>');

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;

        $expense = $xml->addChild('expense');
        $expense->addChild('description', $row['description']);
        $expense->addChild('amount', $row['amount']);
        $expense->addChild('category', $row['category']);
        $expense->addChild('created_at', $row['created_at']);
    }

    file_put_contents('expenses.json', json_encode($data, JSON_PRETTY_PRINT));
    file_put_contents('expenses.xml', $xml->asXML());

    header("Location: index.html");
    exit();
}
?>
