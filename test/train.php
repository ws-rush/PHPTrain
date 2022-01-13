 
<?php
$dsn = 'mysql:host=localhost;dbname=mahmoud-cars';
$username = 'root';
$password = '';

try {
	$connection= new PDO($dsn, $username, $password);
}
catch(PDOException $e) {
    $error_message= $e->getMessage();
    echo ($error_message);
}


// add to database
function add($table, $columns) {
	global $connection;

	// $sql = "INSERT INTO account (fff, fff, fff) VALUES (:fff, :fff, :fff)"
	$sql = "INSERT INTO $table ";
	$column_names = array_keys($columns);
	$last_column = end($column_names);
	$sql .= "(";
	foreach($column_names as $column_name) {
		if ($column_name == $last_column)
			$sql .= "$column_name) VALUES (";
		else
			$sql .= "$column_name, ";
	}
	foreach($column_names as $column_name) {
		if ($column_name == $last_column)
			$sql .= ":$column_name)";
		else
			$sql .= ":$column_name, ";
	}

	$statement = $connection->prepare($sql);

	//$data = [':user_nam' => $user_nam, ':email' => $email, ':pass' => $pass];
	$data = array();
	foreach ($columns as $column => $value) {
		$data[":$column"] = $value;
	}

	if ($statement->execute($data))
		return true;
	return false;
}

// get from database
function get($table, $columns=[]) {
	global $connection;

	// $sql = "`SELECT * FROM table` `SELECT fff, fff, fff FROM table`"
	$sql = "SELECT ";
	if (empty($columns)) {
		$sql .= "* ";
	} else {
		$last_column = end($columns);
		foreach($columns as $column) {
			if ($column == $last_column)
				$sql .= "$column";
			else
				$sql .= "$column, ";
		}
	}
	$sql .= " FROM $table";

	$statement = $connection->prepare($sql);

	$statement->execute();
	return $statement;
}

// update database
function update($table, $columns, $critiria) {
	global $connection;

	//id=:id';
	$sql = "UPDATE $table SET ";

	$column_names = array_keys($columns);
	$last_column = end($column_names);
	foreach($column_names as $column_name) {
		if ($column_name == $last_column)
			$sql .= "$column_name=:$column_name WHERE ";
		else
			$sql .= "$column_name=:$column_name, ";
	}

	$column_names = array_keys($critiria);
	$column = first($column_names);
	$sql .= "$column = :$column";

	$data = array();
	foreach ($columns as $column => $value) {
		$data[":$column"] = $value;
	}
	$data = [":$column" => $critiria[$column]];

	$statement = $connection->prepare($sql);
	if ($statement->execute($data))
		return true;
	return false;
}

// delete from database
function delete($table, $critiria) {
	global $connection;

	$column_names = array_keys($critiria);
	$column = first($column_names);
	$sql = "DELETE FROM $table WHERE ";
	$sql .= "$column = :$column";
	$statement = $connection->prepare($sql);
	$data = [":$column" => $critiria[$column]];

	if ($statement->execute($data))
		return true;
	return false;
}
?>
