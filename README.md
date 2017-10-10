# Ci-Sncf
Ci-Sncf is a php and CodeIgniter (3.x) library to use the SNCF's Open-data.
As Sncf use Navitia, you can alos use this library as an exemple to how to interact wit Navitia.

## Requirements
- PHP 5.4.0 or later (5.6 or later is recommended)
- [CodeIgniter 3](https://www.codeigniter.com/)
- [Composer](https://getcomposer.org/)
- [Navitia Component](https://github.com/CanalTP/NavitiaComponent)

## Installation
Using composer :

```sh
/application$ composer require "canaltp/navitia":"~1.2"
```
In your CodeIgniter `/application/config/config.php` file, set `$config['composer_autoload']` to `TRUE`. [Read more](https://www.codeigniter.com/user_guide/general/autoloader.html).

Copy the files from this package to the corresponding folder in your application folder. For example, copy config/sncf.php to application/config/sncf.php

Edit your `sncf.php` config file in `/application/config/sncf.php` with your Sncf account  details.

Autoload the library in `application/config/autoload.php` or load it in needed controllers with `$this->load->library('sncf');`.


## Usage
In the package you will find simple example usage code in the controllers and views folders.
