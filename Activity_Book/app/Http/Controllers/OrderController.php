<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{


    public function displayNumber()
    {
        return view('generated-number');
    }


    public function displayCustomer($id = 1, $name = 'Lemuel', $addr = 'Mapandan')
    {
        return view('customer', [
            'id' => $id,
            'name' => $name,
            'addr' => $addr
        ]);
    }

    public function displayItem($itemNo = '1', $name = 'Lemuel', $price = '$10,000')
    {
        return view('item', [
            'itemNo' => $itemNo,
            'name' => $name,
            'price' => $price
        ]);
    }

    public function displayOrder($customerID = 1, $customerName = 'Lemuel', $orderNo = 101, $date = '2/25/2026')
    {
        return view('order', [
            'id' => $customerID,
            'name' => $customerName,
            'no' => $orderNo,
            'date' => $date
        ]);
    }

    public function displayOrderDetails($trans = '303030', $order = '1234', $id = '101', $name = 'iPhone', $price = 30000, $qty = 5)
    {
        return view('order-details', [

            'trans' => $trans,
            'order' => $order,
            'id'  => $id,
            'name'  => $name,
            'price'  => $price,
            'qty' => $qty
        ]);
    }
}
