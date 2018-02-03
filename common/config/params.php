<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@thethaohangngay.com.vn',
    'noreplyEmail' => 'noreply@thethaohangngay.com.vn',

    'user.passwordResetTokenExpire' => 3600,
    'user.activationTokenExpire' => 3600 * 24 * 7,

    'fb_app_id' => '351371765229367',
    'gcse_cx' => '018283733847891945836:djbi1lhdauc',
    'ga_id' => 'UA-91357753-1',

    'recaptcha.secret_key' => '',
    'recaptcha.site_key' => '',
    
    'backend_url' => '//spacev.vn/backend',
    'frontend_url' => '//spacev.vn',
    'images_url' => '//spacev.vn/images',
    'uploads_url' => '//spacev.vn/backend/uploads',
    
    'backend_folder' => dirname(dirname(__DIR__)) . '/backend/web',
    'frontend_folder' => dirname(dirname(__DIR__)) . '/frontend/web',
    'images_folder' => dirname(dirname(__DIR__)) . '/frontend/web/images',
    'uploads_folder' => dirname(dirname(__DIR__)) . '/backend/web/uploads',
    
    'default_image' => '',
    
    'aspect_ratios' => [
    ],
    
    'enable_cache' => false,
    'cache_duration' => 3600,
    'telegram_db' => [
        'host'     => '192.168.11.16',
        'user'     => 'huynq',
        'password' => 'sdf30KD)#ejr',
        'database' => 'telegram',
    ]
];
