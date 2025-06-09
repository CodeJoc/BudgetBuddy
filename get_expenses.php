<?php
include 'db.php';

$result = $conn->query("SELECT * FROM expenses ORDER BY created_at DESC");

if ($result->num_rows > 0) {
    echo '<ul class="list-group">';
    while ($row = $result->fetch_assoc()) {
        echo '<li class="list-group-item d-flex justify-content-between align-items-center">';
        echo htmlspecialchars($row['description']) . ' (' . $row['category'] . ')';
        echo '<span class="badge bg-primary rounded-pill">₹' . $row['amount'] . '</span>';
        echo '</li>';
    }
    echo '</ul>';
} else {
    echo '<p>No expenses recorded yet.</p>';
}
?>
