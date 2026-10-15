<?php

if (isset($_GET['details'])) {
    $id = $_GET['details'];
    $order = OrderRepository::getOrderById($id);
    $orderLines = OrderLineRepository::getOrderLinesByOrderId($id);

    require_once("views/orderDetailsView.phtml");
    exit;
}