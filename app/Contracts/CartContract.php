<?php

namespace App\Contracts;

use App\Models\Product;
 

interface CartContract
{
    public function get();
    public function add(Product $product, $quantity = 1);
    public function update(Product $product, $quantity);
    public function delete($id);
    public function empty();
    public function total();
}
