RB(pi)
=====

Welcome to the GitHub project page of __RB(pi)__.

RB(pi) gives you a nice home page to your apache/lighttp/ngnix server, and change the default rendering of the file browser.

__Index page__

![Screen](https://raw.github.com/Thiktak/RBPi/master/doc/screen1.jpg)

Installation
------------

### 1. Clone repository

``git clone git://github.com/Thiktak/RBPi.git``

### 2. Install RB(pi)

```
mv index.php index.old.php
mv .htaccess .htaccess.old
cp RBPI/install/* .
cp RBPI/install/.htaccess .htaccess
```

### 3. Edit your server

#### Apache

Edit `httpd.conf` or any `.htaccess` 

``DirectoryIndex index.php index.html /index.php``

#### Lighttpd 

Edit `nginx.conf`

``index-file.names += ( "index.php", "index.php", "/index.php")``

#### Ngnix

Edit `nginx.conf`

``index  index.php index.html /index.php``

Personalize files & directories
===============================
You can create a file
Create optional files to persolnalize files and directories thanks to `.options` file