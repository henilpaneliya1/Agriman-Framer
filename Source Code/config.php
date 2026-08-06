<?php
$config = [
    'DB_HOST' => getenv('DB_HOST') ?: 'localhost',
    'DB_USER' => getenv('DB_USER') ?: 'root',
    'DB_PASS' => getenv('DB_PASS') ?: '',
    'DB_NAME' => getenv('DB_NAME') ?: 'agrimanpro',

    'MAILER_SERVER' => 'ded723.hostwindsdns.com',
    'MAILER_LOGINID' => 'agri@projectmailer.xyz',
    'MAILER_PASSWORD' => 'S9JPDXdAtBdJ',
    'MAILER_PORT' => '465',

    'PROJECT_TITLE' => 'Agriman',
    'PROJECT_TAGLINE' => 'Agriculture Management System',

    'CURRENCY_SYMBOL' => '₹',

    'ADDRESS' => ['Nikol Ahmedabad-382350'],
    'PHONE' => ['+99-9977058921'],
    'EMAIL' => ['info@agriman.com'],
    'WEB_ADDRESS' => 'www.agriman.com',
    'LOCATION_MAP' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d127482.6881405034!2d101.6169488902334!3d3.138503559663121!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc49c701efeae7%3A0xf4d98e5b2f1c287d!2sKuala%20Lumpur%2C%20Federal%20Territory%20of%20Kuala%20Lumpur%2C%20Malaysia!5e0!3m2!1sen!2sin!4v1589645210749!5m2!1sen!2sin',
    'ENQUIRY_MAIL' => 'info@agriman.com',
    'NO_REPLY_MAIL' => 'info@agriman.com',

    'SOCIAL_TWITTER' => '#',
    'SOCIAL_FACEBOOK' => '#',
    'SOCIAL_INSTAGRAM' => '#',
    'SOCIAL_SKYPE' => '#',
    'SOCIAL_LINKEDIN' => '#',
    'SOCIAL_YOUTUBE' => '#',

    'DEVELOPERS' => ['Rajesh','Shiva prasad'],
    
];
?>