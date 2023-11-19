<?php
session_start();
include "connect.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];
    $password = $_POST["password"];

    $query = "SELECT email, password FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        $storedPassword = $row["password"];

        if (password_verify($password, $storedPassword)) {
            $_SESSION["email"] = $email;
            
            // Add role-based redirection here
            $query = "SELECT role FROM users WHERE email = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $row = $result->fetch_assoc();
                $userRole = $row["role"];
                if ($userRole == "Admin") {
                    header("Location: admin.php"); 
                } else {
                    header("Location: welcome.php"); 
                }
                exit();
            }
        } else {
            
            header("Location: login.php?error=Incorrect password");
            exit();
        }
    } else {
        header("Location: login.php?error=User not found");
        exit();
    }
}

?>
