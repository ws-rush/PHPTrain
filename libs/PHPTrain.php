<?php

// import config
$config = json_decode(file_get_contents(__DIR__ . "/config.json"), true);

######################################## snippets ################################################
function err($num)
{
    global $config;

    $page = $config["errors"][$num][0];
    $messgae = $config["errors"][$num][1];
    if (isset($message))
        $_SESSION['REDIRECTED_MESSAGE'] = $message;

    header("Location: $page");
    exit();
}

function get_message()
{
    $message = $_SESSION['REDIRECTED_MESSAGE'];
    $_SESSION['REDIRECTED_MESSAGE'] = "";
    return $message;
}

function store_files($files, $dir, $keep_tmp_name = true)
{
    $names = [];
    $name = ($keep_tmp_name) ? "tmp_name" : "name";

    if (!file_exists($dir))
        throw new Exception("$dir is not exist");

    if (!is_array($files["name"])) {
        if (move_uploaded_file($files["tmp_name"], $dir . basename($files[$name])))
            $names[0] = $files[$name];
    }

    $countfiles = count($files['name']);

    for ($i = 0; $i < $countfiles; $i++) {
        if (move_uploaded_file($files["tmp_name"][$i], $dir . basename($files[$name][$i])))
            $names[$i] = $files[$name][$i];
    }

    return $names;
}

######################################## snippets end ############################################

###################################### validate class ######################################################
class Validate
{
    function isEmail($text)
    {
        // some logic
        return true;
    }

    function isPhone($number)
    {
        // some logic
        return true;
    }
}

###################################### validate class end ###################################################

###################################### controller class #####################################################

class Controller
{

    private $privilages;

    function __construct($type, $privilages = ["all" => null, "get" => null, "post" => null, "put" => null, "delete" => null])
    {
        if ($type == "web") {
            $this->privilages = $privilages;
        } elseif ($type = "api")
            header('Content-Type: application/json');
        else
            throw new Exception("you didnt specify your application type correctly");
    }

    function get($_Data)
    {
        echo "this is get from controller";
    }

    function post($_Data)
    {
        echo "this is post from controller";
    }

    function put($_Data)
    {
        echo "this is put from controller";
    }

    function delete($_Data)
    {
        echo "this is delete from controller";
    }

    function auth($method)
    {
        $user = $this->privilages[$method];

        if (!$user)
            return 0;

        if (empty($_SESSION['user'][$user->get_role()]))
            err("304");
    }

    function run()
    {
        $this->auth('all');


        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->auth('get');
            $this->get($_GET);
        } else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->auth('post');
            $this->post(array_merge($_POST, $_FILES));
        } else if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            $this->auth('put');
            parse_str(file_get_contents("php://input"), $_PUT);
            $this->put($_PUT);
        } else if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            $this->auth('delete');
            parse_str(file_get_contents("php://input"), $_DELETE);
            $this->delete($_DELETE);
        }
    }
}

############################################ controler class end ##############################################

############################################ Model class #######################################################

// init database
$host = $config['db']['host'];
$dbname = $config['db']['dbname'];
$user = $config['db']['user'];
$pass = $config['db']['password'];

// establish connection
$opts = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
try {
    $connection = new PDO("mysql:host=$host;dbname=$dbname;chaset=utf8", $user, $pass, $opts);
} catch (PDOException $e) {
    exit($e->getMessage());
}


##################################### new API #########################

/* 
    Explain:
    1. in this method we depend on feauters of database to process sql statments
    2. every object will present table or (view) and put undeline for view cause the main idea here
        is to avoid complex tables structures by make view for them.
    3. all work on insert or get any data for table depend on one column what i named $primaryKey,
        in some tables like news table (if we made new website) may be we need to work with table by ID column
        or by article_name column, for this reason I recomand to make two objects for same table and just change
        the primary key, this should look like:
        $news_ID = new DBRush("news", "ID");
        $news_names = new DBRush("news", "article_name");
    4. finally I know when simply sql statments by this way doesnt fit for all use cases,
        (but I belive it fit for most use cases), although we can extend DBRush class to build specified
        classes with more specified functions for your use case

    TODO: add complex field $columns to DBRush, this field should contain array for all columns with thier condations
        to help php determine if data is valid before excute query
        until now I will depend on SQL constrains, but with this idea we reduce time of excution and reduce
        resources usage if implemented, will put validate class sructure under DBRush
*/

class DB
{
    // main fields
    private $table;
    private $primaryKey;

    // helper fields
    private $rows_number; // specify how many rows get every time with getAll function


    function __construct($table, $primaryKey, $rows_number)
    {
        $this->table = $table;
        $this->primaryKey = $primaryKey;
        $this->rows_number = $rows_number;
    }

    function get($blk = 1)
    {
        global $connection;
        $blk--;
        $blk *= $this->rows_number;
        $sql = "SELECT * from $this->table ";

        if ($blk != 0)
            $sql .= "LIMIT $blk, $this->rows_number";

        $q = $connection->prepare($sql);
        if (empty($condation))
            $q->execute();
        else
            $q->execute();
        return $q->fetchall(PDO::FETCH_ASSOC);
    }

    function search($search, $blk = 0)
    {
        if (empty($search))
            throw new Exception("search value must not be empty");

        global $connection;
        $sql = "SELECT * FROM $this->table WHERE $this->primaryKey LIKE :value ";

        if ($blk != 0) {
            $blk--;
            $blk *= $this->rows_number;
            $sql .= "LIMIT $blk, $this->rows_number";
        }

        $q = $connection->prepare($sql);
        $q->execute(["value" => "%$search%"]);

        return $q->fetchall(PDO::FETCH_ASSOC);
    }

    function getOne($value)
    {
        global $connection;
        $sql = "SELECT * from $this->table WHERE $this->primaryKey = :value";
        $q = $connection->prepare($sql);
        $q->execute(["value" => $value]);
        return $q->fetchall(PDO::FETCH_ASSOC);
    }

    function post($data)
    {
        global $connection;

        // generate columns and values
        $keys = "";
        $holders = "";
        foreach ($data as $key => $value) {
            if ($key === array_key_last($data)) {
                $keys .= "$key ";
                $holders .= ":$key ";
                break;
            }

            $keys .= "$key , ";
            $holders .= ":$key , ";
        }

        // insert statment
        $sql = "INSERT INTO $this->table ($keys) VALUES ($holders)";

        $q = $connection->prepare($sql);
        $q->execute($data);

        if ($q->rowcount() > 0)
            return true;
        return false;
    }

    function update($value, $data)
    {
        global $connection;

        // generate set statment
        $updated = "";
        foreach (array_keys($data) as $key) {
            if ($key === array_key_last($data)) {
                $updated .= "$key = :$key ";
                break;
            }
            $updated .= "$key = :$key , ";
        }

        $sql = "UPDATE $this->table SET $updated WHERE $this->primaryKey = :value";

        $q = $connection->prepare($sql);

        $data["value"] = $value;
        $q->execute($data);

        if ($q->rowcount() > 0)
            return true;
        return false;
    }

    function delete($value)
    {
        global $connection;

        $sql = "DELETE FROM $this->table WHERE $this->primaryKey = :value";
        $q = $connection->prepare($sql);
        $q->execute(["value" => $value]);

        if ($q->rowcount() > 0)
            return true;
        return false;
    }
}

class User
{
    // assign names of columns
    private $table;
    private $id; // maybe ID column or name column or eamil column
    private $pass;
    private $active;

    function __construct($table, $id, $pass, $active)
    {
        $this->table = $table;
        $this->id = $id;
        $this->pass = $pass;
        $this->active = $active;
    }

    function get_role()
    {
        return "$this->table-$this->active";
    }

    function login($id, $pass, $page)
    {
        global $connection;
        $sql = "SELECT * from $this->table WHERE $this->id = :value";
        $q = $connection->prepare($sql);
        $q->execute(["value" => $id]);
        $user_data = $q->fetchall(PDO::FETCH_ASSOC);

        if (empty($user_data))
            throw new Exception("ID is not correct");

        if (!password_verify($pass, $user_data[$this->pass]))
            throw new Exception("password is not correct");

        session_start();

        $_SESSION["user"] = [];
        $_SESSION["user"]['id'] = $user_data[$this->id];
        $_SESSION["user"][$this->get_role()] = $user_data[$this->active];

        header("Location: $page");
        exit();
    }

    function create($id, $password, $data)
    {
        global $connection;
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $sql = "INSERT INTO $this->table (ID, Passw) VALUES (:id, :pass)";

        $q = $connection->prepare($sql);
        $q->execute(["id" => $id, "pass" => $hash]);

        if ($q->rowcount() > 0)
            return true;
        return false;
    }

    function logout($page)
    {
        session_unset();
        session_destroy();

        header("Location: $page");
        exit();
    }
}

########################################### Model class end ####################################################