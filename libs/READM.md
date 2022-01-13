# PHPTrain

it is atiny php library for learning build websites in simplest way, it isnt have complete tests and proffesinal build, it is built for learning purpuse.

## Plan Website

first step to build any web site is to plan it, the simplest way is:

1. prepare ER diagram for database, and build databse structure, if you have complex table focus on use Views in SQl
2. plan URLs tree for your website (I will name every URL as `endpoint`), this step depends on type of your website, a restfull API or website, this example for normal website tree:
   - index (endpoint)
   - articles (endpoint)
   - admin/
     - users (endpoint)
     - articles (endpoint)
3. plan for output of your URLs tree, if it is an API it will be json data structure format for every url, but if normal website it will be a design

> if you plan to make your web has an api interface the best practice is to seprate it in diffrent folder like:

    - index
    - articles
    - admin/
        - users
        - articles
    - api/
        - v1/
            - here the structure of api URLs as v1 for example
        - v2/
            - here the structure of api URLs as v1 for example

## Build Endpoints

for every endpoint make a `.php` file, this file should have a subclass from `Controller` to build endpoint, the next example explain how to build endpoint for articles

```php
<?php
// call php rush library
require_once '../libs/PHPTrain.php';

class Articles extends Controller {
    // see 1
    function get($Data){
        echo "hello in articles page <br>";
    }

    function post($Data) {
        echo "hello in articles page, from POST request <br>";
    }
}

// see 2
$articles = new Articles("web");
$articles->run();
?>
```

1. we have 4 types of functions in class `get`, `post`, `put`, `delete`, write one or more. the code inside every function will call with fit request, if user request was in GET the function `get` will excute.
   the data wich sent with request stored in `$Data` from `get($Data)` if they found, practically you caan name it as you want like `get($params)` or any thing, no need any more for `$_GET`, `$_POST`, `$_FILES`, all sent data will stored as key-value in your function argument.

2. after write your endpoint class make object from it and, invoke `run` method.
   construct object with `"web"` or `"api"`, it depend on what you planned for your endpoint, here is explain for them: - `"web"` manage sessions automaticly without need to `session_start()` and any echo statment will show as HTML in browser - `"api"` no sessions, echo output will be plain text for use with json
   > in next lines every one will be explained more, now just prepare for your endpoint and recieve sent data

## validate and filter data

> you can go over this, if your endpoint doesnt need to recive and process data
> after build your endpoint, you can recieve data in variable `$Dtat` and process them, the process may be one of the following:

    - validate data
    - filter data, as hash passwords, or remove spaces ...

I will write class to validate and filter data eaisly and logicly, until that handle this hard mission with php built functions.

## Work with DB

TODO: explain `DB` class

## Show Result

## Build Regiester System

$hashed_password = password_hash($password, PASSWORD_DEFAULT);
password_verify($password, $hashed_password);
