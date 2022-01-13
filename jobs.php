<?php

require_once 'libs/PHPTrain.php';

class Jobs extends Controller
{
    function get($data)
    {
        $search = $data["search"];
        $jobs_tb = new DB("jobs", "title", 10, "equal");
        $jobs = $jobs_tb->getOne($search);
        include "views/jobs.php";
    }
}

$jobs = new Jobs("web");
$jobs->run();
