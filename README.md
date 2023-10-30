<h1>TeleLink</h1>

**Version:**
<span>1.0.0</span>

<p>Link shortening system (PHP) pure php project with custom micro framework.</p>

[![Latest Stable Version](http://poser.pugx.org/irpcpro/tele-link/v)](https://packagist.org/packages/irpcpro/tele-link)
[![Total Downloads](http://poser.pugx.org/irpcpro/tele-link/downloads)](https://packagist.org/packages/irpcpro/tele-link)
[![License](http://poser.pugx.org/irpcpro/tele-link/license)](https://packagist.org/packages/irpcpro/tele-link)
[![PHP Version Require](http://poser.pugx.org/irpcpro/tele-link/require/php)](https://packagist.org/packages/irpcpro/tele-link)
----

<h2>Installation</h2>

Install this project via Composer:
```
composer create-project irpcpro/tele-link
```

<h6>Requires:</h6>

<ul>
    <li>php: "^7.4",</li>
    <li>vitodtagliente/pure-routing: "^1.0",</li>
    <li>rych/phpass: "^2.0",</li>
    <li>firebase/php-jwt: "^6.3",</li>
    <li>ext-json: "*",</li>
    <li>ext-mysqli: "*"</li>
</ul>

<h2>Database Configuration</h2>

for set your database configuration, edit `config/app-config.php`

<br/>

<h2>Create Default Database Tables</h2>

Run this script to create database tables
```
~ composer run-script sql-creator
```

<br/>

<h2>Run Application</h2>

For run application, just need to run server on `.\public\`
```
~ cd .\public\
~ php -S localhost:8080
```
Or run server on `.\public\` directory.

<br/>

<h2>Routes</h2>

<h6>- Login [POST]:</h6>

```
{{host}}/api/v1/user/login
```
```
{
    "username": "admin",
    "password": "123"
}
```

<br>

<h6>- Create Link [POST]</h6>

:warning: <small>need authorization</small>
```
{{host}}/api/v1/shortener/create
```
```
{
    "link": "https://facebook.com"
}
```

<br>

<h6>- Get All Links [GET]</h6>

:warning: <small>need authorization</small>
```
{{host}}/api/v1/shortener/get-all?limit=10
```

<br>

<h6>- Delete Links [DELETE]</h6>

:warning: <small>need authorization</small>
```
{{host}}/api/v1/shortener/delete/{link_id}
```

<br>

<h6>- Edit Links [EDIT]</h6>

:warning: <small>need authorization</small>
```
{{host}}/api/v1/shortener/edit
```
```
{
    "link_id": 5,
    "link": "http://google-new.com"
}
```
