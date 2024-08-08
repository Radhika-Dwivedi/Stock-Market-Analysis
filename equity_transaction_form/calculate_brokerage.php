<?php
include '../db.php';

// Get the asset name from the request
$data = json_decode(file_get_contents("php://input"));
$assetName = $data->assetName;

// Query the brokerage rate for the selected asset
$stmt = $conn->prepare("SELECT brokerage_rate FROM brokerage_rates WHERE asset_name = ?");
$stmt->bind_param("s", $assetName);
$stmt->execute();
$stmt->bind_result($brokerageRate);
$stmt->fetch();
$stmt->close();
$conn->close();

// Return the brokerage rate as JSON
echo json_encode(['brokerageRate' => $brokerageRate]);
?>
