<?php
    if (isset($_POST['id_Beneficiaire'])) {
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "bankup";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        $sql = "DELETE FROM beneficiaire WHERE beneficiaire.id_Beneficiaire = '".$_POST['id_Beneficiaire']."'";

        if ($conn->query($sql) === TRUE) { 
            header('Location: espace_Admin.php');
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    $conn->close();
    } else {
        header('Location: espace_Admin.php');
    }

?>