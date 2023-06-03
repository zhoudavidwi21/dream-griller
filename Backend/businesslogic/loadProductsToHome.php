<?php
    require_once('../db/dbaccess.php');

    $griller = $_POST["categorie"];                                           //product categorie and user input are passed
    $input = $_POST["input"];

    $db_obj = new mysqli($host, $dbUser, $dbPassword, $database);
    $sql = "SELECT * FROM `products` WHERE `name` LIKE '%$input%' AND $griller = 1";           
    $result = $db_obj->query($sql);

    $output = '';                                                                      

    while ($row = $result->fetch_array()){

        $output .= '
            <div class="col-md-4 mb-5">
                <div class="card h-100" id="item-'.$row["id"].'">
                    <div class="card-body">
                        <a><h2 id="title'.$row["id"].'" class="card-title">'.$row["name"].'</h2></a>
                        <img id="pic0" class="img-fluid rounded mb-4 mb-lg-0" src="https://dummyimage.com/200x200/dee2e6/6c757d.png">
                        <p id="text'.$row["id"].'" class="card-text">'.$row["description"].'</p>
                        <span class="price fs-4">'.$row["price"].' €</span>
                    </div>
                    <div class="card-footer">
                        <a id="prodcart'.$row["id"].'" class="btn btn-sonstige btn-sm">In den Einkaufswagen</a>
                    </div>
                </div>
            </div>
        ';                      //append formatted div-blocks related to amount of products (depending on griller categorie)
    }

    $data = array(
        'products' => $output
    );
    
    echo json_encode($data);    //json format is sent to FE
    
?>