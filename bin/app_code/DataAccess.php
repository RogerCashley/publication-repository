<?php

class DataAccess
{
  public $connection_string;

  public $hostname;
  public $username;
  public $password;
  public $database;
  public $port;

  public $mysqli;

  function __construct()
  {
    $this->process_mysqli();
  }

  private function process_mysqli()
  {
    $json = file_get_contents('bin/build_profile.json');
    $config = json_decode($json, true);

    $dev_environment = $config['DevelopmentEnvironment'];
    $conn_config = $config['ConnectionStrings'][$dev_environment];

    $this->hostname = $conn_config['hostname'];
    $this->username = $conn_config['username'];
    $this->password = $conn_config['password'];
    $this->database = $conn_config['database'];

    $this->mysqli = new mysqli($this->hostname, $this->username, $this->password, $this->database, $this->port);
    $this->mysqli->set_charset("utf8mb4");

    // Check connection
    if ($this->mysqli->connect_error) {
      die("Connection failed: " . $this->mysqli->connect_error);
    }
  }

  public function returnAsString($query, $parameters = null)
  {
    $returnValue = null;
    
    if ($query == null || trim($query) == '') {
      return null;
    }

    if ($this->mysqli->connect_error) {
      die("Connection failed: " . $this->mysqli->connect_error);
    }

    try {
      $statement = $this->mysqli->prepare($query);
      $statement->execute($parameters);

      $result = $statement->get_result();
      $assoc = $result->fetch_row();

      $returnValue = isset($assoc) ? strval($assoc[0]) : null;
      
      $result->close();
      $statement->close();
    } catch (\Throwable $e) {
      echo "<script>console.log($e)</script>";
    }
    
    return $returnValue;
  }

  public function returnAsInt($query, $parameters = null)
  {
    $returnValue = null;

    if ($query == null || trim($query) == '') {
      return null;
    }

    if ($this->mysqli->connect_error) {
      die("Connection failed: " . $this->mysqli->connect_error);
    }

    try {
      $statement = $this->mysqli->prepare($query);
      $statement->execute($parameters);

      $result = $statement->get_result();
      $assoc = $result->fetch_row();

      $returnValue = isset($assoc) ? (int)($assoc[0]) : null;
      
      $result->close();
      $statement->close();
    } catch (\Throwable $e) {
      echo "<script>console.log($e)</script>";
    }
    
    return $returnValue;
  }

  public function returnAsFloat($query, $parameters = null)
  {
    $returnValue = null;
    
    if ($query == null || trim($query) == '') {
      return null;
    }

    if ($this->mysqli->connect_error) {
      die("Connection failed: " . $this->mysqli->connect_error);
    }

    try {
      $statement = $this->mysqli->prepare($query);
      $statement->execute($parameters);

      $result = $statement->get_result();
      $assoc = $result->fetch_row();

      $returnValue = isset($assoc) ? (float)($assoc[0]) : null;
      
      $result->close();
      $statement->close();
    } catch (\Throwable $e) {
      echo "<script>console.log($e)</script>";
    }
    
    return $returnValue;
  }

  public function returnAsObject($query, $parameters = null)
  {
    $returnValue = null;

    if ($query == null || trim($query) == '') {
      return null;
    }

    if ($this->mysqli->connect_error) {
      die("Connection failed: " . $this->mysqli->connect_error);
    }

    try {
      $statement = $this->mysqli->prepare($query);
      $statement->execute($parameters);

      $result = $statement->get_result();
      $returnValue = $result->fetch_assoc();

      $result->close();
      $statement->close();
    } catch (\Throwable $e) {
      echo "<script>console.log($e)</script>";
    }
    
    return $returnValue;
  }

  public function returnAsList($query, $parameters = null)
  {
    $returnValue = null;

    if ($query == null || trim($query) == '') {
      return null;
    }

    if ($this->mysqli->connect_error) {
      die("Connection failed: " . $this->mysqli->connect_error);
    }

    try {
      $statement = $this->mysqli->prepare($query);
      $statement->execute($parameters);

      $result = $statement->get_result();
      $returnValue = $result->fetch_all(MYSQLI_ASSOC);

      $result->close();
      $statement->close();
    } catch (\Throwable $e) {
      echo "<script>console.log($e)</script>";
    }

    return $returnValue;
  }

  function refValues($arr)
  {
    if (strnatcmp(phpversion(), '5.3') >= 0) //Reference is required for PHP 5.3+
    {
      $refs = array();
      foreach ($arr as $key => $value)
        $refs[$key] = &$arr[$key];
      return $refs;
    }
    return $arr;
  }

  function executeNonQuery($query, $params)
  {
    if ($this->mysqli->connect_error) {
      die("Connection failed: " . $this->mysqli->connect_error);
    }

    $stmt = $this->mysqli->prepare($query);
    if (!$stmt) {
      die("Error preparing statement: " . $this->mysqli->error);
    }

    $types = "";
    foreach ($params as $param) {
      if (is_int($param)) {
        $types .= "i";
      } elseif (is_float($param)) {
        $types .= "d";
      } elseif (is_string($param)) {
        $types .= "s";
      } else {
        $types .= "b";
      }
    }

    array_unshift($params, $types);
    call_user_func_array(array($stmt, 'bind_param'), $this->refValues($params));

    if (!$stmt->execute()) {
      die("Error executing statement: " . $stmt->error);
    }

    $stmt->close();
  }
}
