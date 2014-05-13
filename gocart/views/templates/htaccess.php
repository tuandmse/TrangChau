AddType image/svg+xml svg svgz
AddEncoding gzip svgz
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ /<?php echo $subfolder;?>index.php/$1 [L]
</IfModule>