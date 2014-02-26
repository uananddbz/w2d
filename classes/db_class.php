<?php
class db {

private $host; 
private $user;
private $pass;
private $name;
private $con;

//auto run function
function __construct($host,$user,$pass,$name) {
$this->host=$host;
$this->user=$user;
$this->pass=$pass;
$this->name=$name;
	}
//auto run function-/>

//connect to database

function connect() {

if (!$this->con)
{
	$q = mysql_connect($this->host, $this->user, $this->pass);
$sel=mysql_select_db($this->name,$q);

if ($sel)
{$this->con=true;}
}

}
//connect to database -/>

//select from database

function select($table,$where=null,$select='*') {
$this->connect();

$where=($where!=null?'WHERE '.$where:null);

$row=array();
$result = mysql_query("SELECT $select FROM $table $where");

while($r = mysql_fetch_assoc($result))
  {
array_push($row,$r);
  }
  return $row;

}
//select from database -/>

//insert to database

function insert($table,$data) {
$this->connect();

//if data is array
if (is_array($data))
{
//columns
$key=array_keys($data);
$column=implode(',',$key);

//values
$v=array();

for ($i=0; $i<count($data); $i++)
{
array_push($v,"'".$data[$key[$i]]."'");
}

$value=implode(',',$v);

//insert to db
$q="INSERT INTO $table ($column) VALUES ($value)";
}

//if data is string
else
{
$q="INSERT INTO $table $data";
}

if (mysql_query($q))
{return true;}
else
{return false;}

}
//insert to database -/>


//update to database
function update($table,$where=null,$data) {

//check if where is defined
if ($where!=null)
{
$this->connect();


//if data is array
if (is_array($data))
{

//columns
$key=array_keys($data);

//values
$v=array();

for ($i=0; $i<count($data); $i++)
{
array_push($v,$key[$i]."='".$data[$key[$i]]."'");
}
$value=implode(',',$v);


//insert to db
$q="UPDATE $table SET $value WHERE $where";
}

//if data is string
else
{
$q="UPDATE $table SET $data WHERE $where";
}

if (mysql_query($q))
{return true;}
else
{return false;}

}
else
{return false;}

}
//update to database -/>



//delete from database
function delete($table,$where=null) {
$this->connect();

if ($where!=null)
{
$q = "DELETE FROM $table WHERE $where";

if (mysql_query($q))
{return true;}
else
{return false;}
}

}
//delete from database -/>

}
?>