<?php

session_start();

if (isset($_POST['submit'])) {

    include 'dbh.inc.php';

    $sid = mysqli_real_escape_string($conn, $_POST['sid']);

    $_SESSION['stid'] = $sid;

    if (empty($sid)) {
        header("Location: ../index.php?check=empty");
        exit();
    } else {
        $sql = "SELECT * FROM student WHERE sid='$sid';";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck < 1) {
            header("Location: ../index.php?check=error");
            exit();
        } else {
            $row = mysqli_fetch_assoc($result);

            $_SESSION['sname'] = $row['name'];
            $did = $row['degreeid'];

            $sql2 = "SELECT * FROM degree WHERE degreeid='$did';";
            $result = mysqli_query($conn, $sql2);
            $resultCheck = mysqli_num_rows($result);

            if ($resultCheck < 1) {
                header("Location: ../index.php?check=error");
                exit();
            } else {
                $row1 = mysqli_fetch_assoc($result);

                $_SESSION['dname'] = $row1['name'];



                header("Location: ../eligibility.php?check=success");
                exit();
            }

           
        }
    }

} else {
    header("Location: ../index.php?check=error");
    exit();
}

