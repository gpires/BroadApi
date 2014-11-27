BroadApi
========

![broadapi](http://i.imgur.com/oESIhvL.png:medium)


Requirements
--------------------
* PHP >= 5.3.0
* MySQL
* Transmission >= 2.52

Installation
--------------------
* Copy the content
* Create a database
* Upload structure
* Edit 'config.php'
* Add a cronjob (* * * * * php /var/www/broadapi/cron.php > /dev/null 2>&1)
* Profit!


Implemented Features
--------------------
* Torrent added automaticaly using database list and Broadcasthe.net API
* View Transmission stats including current upload and download speed.
* Starting torrent by URL
* Manage Series
* Logs viewer
* Pushbullet API integration

Todo
--------------------
* Edit and Delete rows from table
* Authentication
* File Manager


Used scripts
--------------------

PHP Transmission-Class
(https://github.com/brycied00d/PHP-Transmission-Class)

JSON-RPC PHP
(http://jsonrpcphp.org/)

PushBullet for PHP
(https://github.com/ivkos/PushBullet-for-PHP)

Pagination by Oscar Oluoch
(https://github.com/antoroko/savannahphptuts/)
