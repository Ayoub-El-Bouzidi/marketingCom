<?php
require_once 'config/connect.php';

if (isset($_POST['command']) && !empty($_POST['phone_number'])) {
    if (!empty($_POST['user_name']) || !strlen($_POST['user_name']) < 5) {
        // if phone number pushed means new user so this code creates new user
        $sql = 'SELECT user_phone FROM user WHERE user_phone = ' . $_POST['phone_number'];
        $stmt = $conn->prepare($sql);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if (empty($result["user_phone"])) {
            if (isset($_POST['phone_number'])) {
                if (empty($_POST['phone_number']) || strlen($_POST['phone_number']) < 10 || strlen($_POST['phone_number']) > 17) {
                    die(json_encode("numberinvald"));
                }

                $sql = 'INSERT INTO user (user_id, user_name, user_phone) VALUES (NULL, " ' . $_POST['user_name'] . '", "' . $_POST['phone_number'] . '")';
                $stmt = $conn->prepare($sql);
                $stmt->execute();
            }
        }
        echo json_encode('verified');
    } else {
        die(json_encode("nameinvalid"));
    }
} else {
    echo json_encode("phoneempty");
}
