<?php
$conn = new mysqli('localhost', 'root', '', 'tgi_db');

// Check connection
if ($conn->connect_error) {
    error_log("Connection failed: " . $conn->connect_error);
    echo "Error connecting to database.";
    exit();
}

// Get data from POST request
$customerName = $conn->real_escape_string($_POST['customerName']);
$total = (float)$_POST['total'];
$discount = (float)$_POST['discount'];
$grandTotal = (float)$_POST['grandTotal'];

// Insert the order into the orders table
$sql = "INSERT INTO orders (ordered_date, orderby, total, discount, grand_total) VALUES (NOW(), '$customerName', $total, $discount, $grandTotal)";

if ($conn->query($sql) === TRUE) {
    $orderId = $conn->insert_id; // Get the last inserted order ID

    // Insert the order items into the order_items table
    $invoiceDetails = json_decode($_POST['invoiceDetails'], true);
    $stmt = $conn->prepare("INSERT INTO order_items (order_id, item_name, quantity, price, amount) VALUES (?, ?, ?, ?, ?)");
    
    foreach ($invoiceDetails as $item) {
        $itemName = $conn->real_escape_string($item['itemName']);
        $quantity = (int)$item['qty'];
        $price = (float)$item['price'];
        $amount = (float)$item['amount'];

        // Bind parameters and execute the statement
        $stmt->bind_param("isidd", $orderId, $itemName, $quantity, $price, $amount);
        $stmt->execute();
    }

    $stmt->close(); // Close the prepared statement
    echo "Order saved successfully!";
} else {
    error_log("Error: " . $sql . "<br>" . $conn->error);
    echo "Error saving order: " . $conn->error;
}

$conn->close();
?>