<?php
$conn = new mysqli("localhost", "root", "", "task-manager");
if ($conn->connect_error) {
 die("Connection failed: " . $conn->connect_error);
}
