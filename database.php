<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $mobno = isset($_POST['mobno']) ? $_POST['mobno'] : '';
    $subject = isset($_POST['subject']) ? $_POST['subject'] : '';
    $message = isset($_POST['message']) ? $_POST['message'] : '';

    if (!empty($name) && !empty($email) && !empty($mobno) && !empty($subject) && !empty($message)) {
        $conn = new mysqli("localhost", "root", "", "clientdb");

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $stmt = $conn->prepare("INSERT INTO users (Name, Email, `Mobile No.`, Subject, Message) VALUES (?, ?, ?, ?, ?)");
        if ($stmt === false) {
            die("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("sssss", $name, $email, $mobno, $subject, $message);

        if ($stmt->execute()) {
            echo "Thank you for contacting us. We'll get back to you as soon as possible. You may return to the previous page";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Please fill in all fields.";
    }
} else {
    echo "Form not submitted properly.";
}
?>
