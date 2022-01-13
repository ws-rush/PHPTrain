<?php

include '../libs/PHPTrain.php';

$users = new DB("users", "name", 20);

echo "get: " . json_encode($users->get()) . "<br>";
echo "search: " . json_encode($users->search("soso")) . "<br>";
echo "getOne: " . json_encode($users->getOne("soso")) . "<br>";
echo "post: " . $users->post(["name" => "hassan", "age" => 14]) . "<br>";
echo "update: " . $users->update("hassan", ["name" => "soso", "age" => 30]) . "<br>";
echo "delete: " . $users->delete("hassan") . "<br>";
