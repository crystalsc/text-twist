<?php

function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;
}
        $verb = $_SERVER["REQUEST_METHOD"];
        
        if ($verb == "GET"){
            $dbhandle = new PDO("sqlite:scrabble.sqlite") or die("Failed to open DB");
            if (!$dbhandle) die ($error);
            if (isset($_GET['mode'])) {
                if ($_GET['mode']=="Hard") {
                    $query = "SELECT rack, weight, words FROM racks where weight > 30 order by random() limit 1";
                }
                else if ($_GET['mode']=="Medium") {
                    $query = "SELECT rack, weight, words FROM racks where weight > 15 and weight <= 30 order by random() limit 1";
                } else {
                    $query = "SELECT rack, weight, words FROM racks where weight <= 15 order by random() limit 1";
                }
            } else {
                $query = "SELECT rack, weight, words FROM racks where weight <= 15 order by random() limit 1";
            }
            // $query = "CREATE TABLE results (
            //     date_submitted TEXT PRIMARY KEY,
            //     user TEXT NOT NULL,
            //     score INTEGER NOT NULL
            // )";
            // $query = "SELECT rack, weight, words FROM racks where weight > 30 order by random() limit 1";
            $statement = $dbhandle->prepare($query);
            $statement->execute();
            $results = $statement->fetchAll(PDO::FETCH_ASSOC);
            header('HTTP/1.1 200 OK');
            header('Content-Type: application/json');
            echo json_encode($results);
        } else if ($verb == "POST"){
            $user = "anonymous";
            $score = 0;
            $date = 10;
            // if (isset($_POST["user"])){
            //     $user = $_POST["user"];
            // }
            // if (isset($_POST["score"])){
            //     $score = $_POST["score"];
            // }
            // if (isset($_POST["date"])){
            //     $date = $_POST["date"];
            // }
            //$query = "INSERT INTO results (user,score,date_submitted) VALUES(" + $user +"," + $score + "," +$date + ")";
            $query = "insert into results (user,score,date_submitted) values(" . $user . "," . $score + "," . $date . ")";
            echo $query;
            echo $user;
            echo "insert into results (user,score,date_submitted) values("+ $user + "," + $score + "," + $date + ")";
            // $statement = $dbhandle->prepare($query);
            // $statement->execute();
            // $results = $statement->fetchAll(PDO::FETCH_ASSOC);
            // header('HTTP/1.1 200 OK');
            // header('Content-Type: application/json');
            // echo json_encode($results);
        } else {
            echo "USAGE GET or POST";
        }
?>