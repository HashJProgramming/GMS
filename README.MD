## GMS - Gym Membership System
![Alt text](screenshots/image.png)

## Installation & Setup
### XAMPP
- Download XAMPP from [here](https://www.apachefriends.org/download.html)
- Install XAMPP
- Clone this repository to your `xampp/htdocs` folder
- `git clone https://github.com/HashJProgramming/GMS`
- Open XAMPP Control Panel
- Start Apache and MySQL
- Open your browser and go to `localhost/GMS`
- Enjoy!

Here you can change the `xampp/htdocs/index.php` to redirect to the `GMS` folder.
```php
    <?php
        if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
            $uri = 'https://';
        } else {
            $uri = 'http://';
        }
        $uri .= $_SERVER['HTTP_HOST'];
        header('Location: '.$uri.'/GMS/');
        exit;
    ?>
```

## XAMPP Specifications

| Tool            | Version                             |
|-----------------|-------------------------------------|
| Database Server | 10.4.28-MariaDB - mariadb.org binary distribution |
| Web Server      | Apache/2.4.56 (Win64) OpenSSL/1.1.1t PHP/8.2.4 |
| Database Client | libmysql - mysqlnd 8.2.4             |
| PHP             | 8.2.4                               |
| phpMyAdmin      | 5.2.1 (up to date)                   |

## Administrator Credentials
| Username | Password |
|----------|----------|
| admin    | admin    |

## LICENSE
```               
                                                MIT License

                                    Copyright (c) 2023 MuhaimenZXC

                Permission is hereby granted, free of charge, to any person obtaining a copy
                of this software and associated documentation files (the "Software"), to deal
                in the Software without restriction, including without limitation the rights
                to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
                copies of the Software, and to permit persons to whom the Software is
                furnished to do so, subject to the following conditions:

                The above copyright notice and this permission notice shall be included in all
                copies or substantial portions of the Software.

                THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
                IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
                FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
                AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
                LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
                OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
                SOFTWARE.
```