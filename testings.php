<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="scripts.js"></script>
</head>

<body>

    <h1 id="h1" onclick='DeleteThread("h1")'>hello</h1>

</body>

</html>

<?php

function rand_1()
{
    $today = date("Y-m-d");
    echo $today;
    include_once "db_connection.php";

    $connection = connectToDB("website1");
    $sql = "SELECT thread_text FROM thread";
    $result = mysqli_query($connection, $sql);
    $db = mysqli_fetch_all($result);
    var_dump($db[1][0]);

    include_once "searchDB.php";
    $database = getThreads();
    $idx = 0;
    while ($idx < sizeof($database)) {
        echo "[$idx]" . $database[$idx][0] . "<br>";
        $idx++;
    }
}

function f2($thread_id)
{
    include_once "db_connection.php";
    $connection = connectToDB("website1");

    $sql = "SELECT user_id FROM thread WHERE thread_id = '$thread_id'";
    $result = mysqli_query($connection, $sql);
    $user_id = mysqli_fetch_all($result);
    $user_id_converted = $user_id[0][0];

    $sql = "SELECT user_name FROM user WHERE user_id = '$user_id_converted' ";
    $result = mysqli_query($connection, $sql);
    $user_name = mysqli_fetch_all($result);
    $user_name_converted = $user_name[0][0];

    mysqli_close($connection);
    return $user_name_converted;
}

function getUserID($user_name)
{
    include_once "db_connection.php";
    $connection = connectToDB("website1");

    $sql = "SELECT user_id FROM user WHERE user_name = '$user_name'";
    $result = mysqli_query($connection, $sql);
    $fetchedResult = mysqli_fetch_all($result);

    mysqli_close($connection);
    var_dump($fetchedResult[0][0]);
}

//INSERT INTO `thread` (`thread_id`, `user_id`, `thread_text`, `thread_date`) VALUES (NULL, '3', 'sdas', '2023-11-02')

function getThreads($thread_id)
{
    include_once "db_connection.php";
    $connection = connectToDB("website1");

    $sql = "SELECT * FROM thread WHERE thread_id = '$thread_id'";
    $result = mysqli_query($connection, $sql);
    $db = mysqli_fetch_all($result, MYSQLI_ASSOC);

    $info["thread_id"] = $db[0]['thread_id'];
    $info["user_id"] = $db[0]['user_id'];
    $info["thread_text"] = $db[0]['thread_text'];
    $info["thread_date"] = $db[0]['thread_date'];

    mysqli_close($connection);

    return $info;
}

function insertUser($us, $pw)
{
    include_once "db_connection.php";
    $connection = connectToDB("website1");
    $today = date("Y-m-d");

    $pwHashed = password_hash($pw, PASSWORD_BCRYPT);

    $sql = "INSERT INTO user (user_id, user_name, user_password, user_reg_date) VALUES (NULL, '$us', '$pwHashed','$today')";
    mysqli_query($connection, $sql);

    mysqli_close($connection);

    //var_dump(mysqli_store_result($connection,MYSQLI_STORE_RESULT_COPY_DATA));
    //echo $connection->error;
}

function getUserData($username)
{
    include_once "db_connection.php";
    $connection = connectToDB("website1");

    $sql = "SELECT * FROM user WHERE user_name = '$username'";
    $result = mysqli_query($connection, $sql);
    $fetchedResult = mysqli_fetch_assoc($result);

    /*echo '<pre>';
    print_r($fetchedResult);
    echo $fetchedResult['user_id'];
    echo '</pre>';*/

    mysqli_close($connection);
    return $fetchedResult;
}

#echo '<span id="span"class="p-thread"  style="cursor: pointer; text-decoration: underline;" onclick="DeleteThread("span")> DELETE </span>';
