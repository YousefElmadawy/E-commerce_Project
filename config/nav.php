<?php

return [
    [
        'icon' => 'nav-icon fas fa-tachometer-alt',
        'route' => 'dashboard',
        'title' => 'Dashboard',
        'active'=>'dashboard'
    ],
    [
        'icon' => 'fas fa-person-booth nav-icon',
        'route' => 'categories.index',
        'title' => 'Categories',
        'badge' => 'new',
        'active'=>'categories.*'
    ],
    [
        'icon' => 'fas fa-cart-plus nav-icon',
        'route' => 'products.index',
        'title' => 'Products',
        'active'=>'products.*'
    ],
    [
        'icon' => 'fas fa-receipt nav-icon',
        'route' => 'categories.index',
        'title' => 'Orders',
        'active'=>'orders.*'
    ],
    [ 
        'icon' => 'fas fa-shirt nav-icon ',
        'route' => 'categories.index',
        'title' => 'Orders',
        'active'=>'orders.*'
    ],
    [
        'icon' => 'fas fa-store-alt nav-icon',
        'route' => 'categories.index',
        'title' => 'Orders',
        'active'=>'orders.*'
    ],

];
