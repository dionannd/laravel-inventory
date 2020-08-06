<?php

return array(


    'pdf' => array(
        'enabled' => true,
        'binary'  => env('SNAPPY_BIN', '"C:\Program Files\wkhtmltopdf\bin\wkhtmltopdf"'),
        // 'binary'  => env('SNAPPY_BIN', '"/usr/local/bin/wkhtmltopdf"'),
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),
    'image' => array(
        'enabled' => true,
        'binary'  => '"C:\Program Files\wkhtmltopdf\bin\wkhtmltopdf"',
        // 'binary'  => '"/usr/local/bin/wkhtmltoimage"',
        'timeout' => false,
        'options' => array(),
        'env'     => array(),
    ),


);
