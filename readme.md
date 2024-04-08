# Installation Requirements

- PHP 5.4 or Higher
- MySQLi
- GD Library
- Simple XML
- cURL
- mbstring
- allow_url_fopen

Q&A Install: 
1.To upload a new movie, please navigate to the "Movies" or "Series" sections for uploading. Do not upload it to a blog, page, or article. Otherwise, you may encounter slug errors.

2. If crawling is unsuccessful, press F12 to check for errors. If you encounter "This request has been blocked; the content must be served over HTTPS," add "https://" to the website URL.

3. If the homepage doesn't update after crawling, clear all web cache, VPS cache, and any other cache that can be cleared.

4. To edit the footer menu, navigate to: \application\views\theme\missav\footer on the VPS for editing.

5. To adjust the language, go to the Language File on the VPS, copy the "en" file, rename it to "vn," then edit it to Vietnamese. Afterward, add "vn" to the website in the language section.

6. If encountering a 404 error when accessing the website, and using Nginx, add the following URL rewrite rules:
location / {
        try_files $uri $uri/ /index.php?$args;
    }
location ~ \.php$ {
        include fastcgi_params;
        fastcgi_pass unix:/var/run/php/php7.4-fpm.sock; # Ensure this matches your PHP-FPM socket path
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_param HTTP_AUTHORIZATION $http_authorization;
        fastcgi_index index.php;
    }
7. If install command " Looks like this app has already been installed! You can't reinstall it again." go to: /application/config/database.php
'hostname' => 'enter_hostname' in line 79.
    
