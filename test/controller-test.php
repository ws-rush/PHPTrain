<?php

require_once '../libs/PHPTrain.php';

class ControllerTest extends Controller
{
    function get($data)
    {
        $name = (isset($data['name']) ? $data["name"] : "");
        echo "hello $name <br>";
        echo "
            <form method='post' action='controller-test.php' enctype='multipart/form-data'>
                <input type='hidden' name='_method value='put'>
                <input type='text' name='name'>
                <input type='file' name='file[]' id='fil' multiple>
                <input type='submit' value='send'>
            </form>
        ";
    }

    function post($data)
    {
        $name = (isset($data['name']) ? $data["name"] : "");
        echo "hello $name <br>";
        print_r(store_files($data['file'], '../files/', true));
        //$file_name = $data["file1"]["name"];
        //echo "$file_name <br>";
        echo "<a href='controller-test.php'> previous </a>";
    }
}

$test = new ControllerTest("web");
$test->run();
