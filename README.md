# [main / devnull.gerekper](https://github.com/gerekper/gerekper-main) #

## What is it ##
Main    - Main module of gerekper

## Installation ##

#### Manual Installation ####
Some advanced users might prefer to use manually install the plugin. This can be done using the command line. CD into your OctoberCMS project folder and paste these commands. It will execute one after another:
```
cd plugins
mkdir -p devnull/gerekper && cd $_
git clone https://github.com/gerekper/gerekper-main ./
composer update

cd themes
mkdir -p gerekper && cd $_
git clone https://github.com/gerekper/gerekper ./

```
Logout from your backend and login again. This will create the necessary tables for the plugin to work. You have now installed Devnull.gerekper! Enjoy!!!


| Function              | Public    | Admin     | Create    | Update    | Delete    | NotCreated
| :------------         |:------:   | :------:  | :------:  | :------:  | :------:  | :------:
| Main                  | :o:       | :o:       | :o:       | :o:       | :o:       | :o:
| Breadcrumbs           | :o:       | :x:       | :x:       | :x:       | :x:       | :x:
| Meta SEO              | :o:       | :x:       | :x:       | :x:       | :x:       | :x:
| Robots:Robots.txt     | :x:       | :x:       | :x:       | :x:       | :x:       | :o:
| Robots:Humans.txt     | :x:       | :x:       | :x:       | :x:       | :x:       | :o:
| Robots:RobotLogs      | :x:       | :x:       | :x:       | :x:       | :x:       | :o:
| Robots:Agents         | :x:       | :x:       | :x:       | :x:       | :x:       | :o:
| Robots:Traps          | :x:       | :x:       | :x:       | :x:       | :x:       | :o:

## Todo ##
- Robot Traps
- Optimization of code
- Agents Scrapping using simple scrapping technology based on html  
    1. http://www.user-agents.org/index.shtml
    2. http://www.useragentstring.com/pages/useragentstring.php

## Thanks ##

* [Alexey Bobkov and Samuel Georges](http://octobercms.com) for OctoberCMS.
* [Scott Bedard](https://github.com/scottbedard) for HasMany Widget.
* [Saifur Rahman Mohsin](https://github.com/SaifurRahmanMohsin/) for Txt Generator.
* [James Healey](https://github.com/jayhealey) for Robots class/Service Provider.