<?php
require '../app/Mage.php';
Mage::app();

// Get order details between 2 dates
// Date range
$fromDate='2016-3-5 00:00:00';
$toDate='2017-10-10 00:00:00';

$order = Mage::getModel('sales/order')->getCollection()
    ->addAttributeToFilter('created_at', array('from' => $fromDate , 'to' => $toDate ));

$order->getSelect()
    ->reset(Zend_Db_Select::COLUMNS) //remove existings selects
    ->columns(array('grand_total' => new Zend_Db_Expr('SUM(grand_total)'))) //add expresion to sum the grand_total
    ->columns(array('count' => new Zend_Db_Expr('COUNT(entity_id)'))) //add expression to count the orders
    ->columns(array('shipping_total' => new Zend_Db_Expr('SUM(shipping_amount+shipping_tax_amount)'))); //add expression to calculate the shipping costs

$data = $order->getFirstItem(); //because this is a collection, we need just the first item.

echo "Grand Total " . $data['grand_total']."<br>";
echo "Order Count " . $data['count']."<br>";
//echo "Shipping Total" . $data['shipping_total']."<br>";


?>
