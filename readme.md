RB(pi)
=====

Welcome to the GitHub project page of __RB(pi)__.

RB(pi) gives you a nice home page to your apache/lighttp/ngnix server, and change the default rendering of the file browser.

__Index page__

![Screen](https://raw.github.com/Thiktak/RBPi/master/doc/screen1.jpg)
![Screen](https://raw.github.com/Thiktak/RBPi/master/doc/screen2.png)

* __List__ files & directories
* __Personalize__ icon, display (hidden or not), description
* __Automatically applied to all subfolders__
* Keyboard navigation
* Auto display README.md file


@Todo :

* Compress & optimize CSS
* Add principal home page navigation (personnal links)
* Add icons (type)

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

Edit __httpd.conf__ or any __.htaccess__

``DirectoryIndex index.php index.html /index.php``

#### Lighttpd 

Edit __lighttpd.conf__

``index-file.names += ( "index.php", "index.php", "/index.php")``

#### Ngnix

Edit __nginx.conf__

``index  index.php index.html /index.php``

Personalize files & directories
===============================
You can create a file
Create optional files to persolnalize files and directories thanks to `.options` file