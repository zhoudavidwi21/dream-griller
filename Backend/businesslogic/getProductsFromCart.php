<?php
    require_once('../db/dbaccess.php');

    $total = 0;
    $count = 0;

    $db_obj = new mysqli($host, $dbUser, $dbPassword, $database);           //joining two tables as multiple information is required
    $sql = "SELECT ci.quantity, ci.id as item_id, pr.price, pr.name
            FROM `cartitems` ci
            INNER JOIN `products` pr
            ON ci.product_id = pr.id";
    
    $result = $db_obj->query($sql);

    $output = '
    <div class="table-responsive" id="order_table">
        <table class="table table-bordered table-striped">
            <tr>  
                <th>Name</th>  
                <th>Anzahl</th>  
                <th>Preis</th>  
                <th>Gesamt</th>  
                <th></th>  
            </tr>
    ';                                                                      //structure of shopping cart content is built (table)

    while ($row = $result->fetch_array()){

        $totalProduct = $row["price"] * $row["quantity"];

        $output .= '
        <tr>
            <td>'.$row["name"].'</td>
            <td>'.$row["quantity"].' Stück<br>
                <button id="btnQuantAdd'. $row["item_id"].'">+</button>
                <button id="btnQuantSub'. $row["item_id"].'">-</button>
            </td>
            <td>'.$row["price"].' €</td>
            <td>'.$totalProduct.' €</td>
            <td><button class="btn btn-danger btn-xs delete" id="removeProduct'. $row["item_id"].'">Entf.</button></td>
        </tr>
        ';                                                                  //values of DB are inserted

        $count += 1;                                                        //Count of products in cart
        $total += $totalProduct;                                            //Count of total cost
    }

    $output .= '</table></div>';

    $data = array(
        'tabledata' => $output,
        'total' => $total,                      //array is created and gets json encoded, information is sent to the frontend
        'count' => $count
    );
    
    echo json_encode($data); 
          

    
?>