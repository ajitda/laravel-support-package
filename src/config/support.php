<?php

return [
    // Define the layout page that you want to show in your support page
    'layout'=> 'layouts.app', //example layouts.frontLayout.front_design
    'ajax_response'=> false,
    // Define a support path prefix for your application
    'support_path_prefix'=>'support',
    'support_admin'=>'admin', // column in users table for support_admin
    'support_admin_middleware'=>'admin',
    'support_admin_email' => ['youremail@gmail.com'],
];