<?php

class OrderRepository{

    public static function getOrderById($id){
          $db=DB::connect();
        $query="SELECT * FROM order WHERE id=$id";
        $result=$db->query($query);
        $order=$result->fetch_assoc();
        return new Order($order['id'], $order['buyerid'], $order['total_order'], $order['order_date'], $order['status'] );
 
    }
}