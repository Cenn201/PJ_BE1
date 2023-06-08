<?php
    function total_price($cart){
        $total = 0;
        foreach( $cart as $item){
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }

    function total_item($cart){
        $total = 0;
        foreach( $cart as $item){
            $total += $item['quantity'];
        }
        return $total;
    }
?>