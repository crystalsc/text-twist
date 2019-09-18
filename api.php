<?php

        $verb = $_SERVER["REQUEST_METHOD"];
        
        if ($verb == "GET"){
            $dbhandle = new PDO("sqlite:scrabble.sqlite") or die("Failed to open DB");
            if (!$dbhandle) die ($error);
            if (isset($_GET['mode'])) {
                echo $_GET['mode'];
                if ($_GET['mode']=="HARD") {
                    $query = "SELECT rack, max(weight), words where weight > 10 FROM racks order by random() limit 1";
                }
                else if ($_GET['mode']=="MED") {
                    $query = "SELECT rack, weight, words where weight > 5 and weight <= 10 FROM racks order by random() limit 1";
                } else {
                    $query = "SELECT rack, weight, words where weight <= 5 FROM racks order by random() limit 1";
                }
            } else {
                $query = "SELECT rack, weight, words where weight <= 5 FROM racks order by random() limit 1";
            }
            $query = "SELECT rack, weight, words FROM racks order by random() limit 1";
            $statement = $dbhandle->prepare($query);
            $statement->execute();
            $results = $statement->fetchAll(PDO::FETCH_ASSOC);
            header('HTTP/1.1 200 OK');
            header('Content-Type: application/json');
            echo json_encode($results);
        } else if ($verb == "POST"){
            $author = "anonymous";
            $content = "secret message";
            if (isset($_POST["author"])){
                $author = $_POST["author"];
            }
            if (isset($_POST["content"])){
                $content = $_POST["content"];
            }
            echo "$author: $content";
        } else {
            echo "USAGE GET or POST";
        }

?>