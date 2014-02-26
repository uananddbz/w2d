<?php include('classes/db_class.php');

$db=new db("localhost",'root','','w2d');

$task=(isset($_POST['task'])?$_POST['task']:null);
$table=(isset($_POST['table'])?$_POST['table']:null);
$where=(isset($_POST['where'])?$_POST['where']:null);
$data=(isset($_POST['data'])?$_POST['data']:null);

$d = date("d",time());
$m = date("m",time());
$y = date("Y",time());


 switch ($task)
{
case 'select':
  echo json_encode($db->select($table,$where));
  break;
  
case 'update':
  echo json_encode($db->update($table,$where,$data));
  break;
  
case 'delete':
  echo json_encode($db->delete($table,$where));
  break;
  
case 'submit':
$data=array();
if ($table=='birthday')
{
$data['name']=(isset($_POST['name'])?$_POST['name']:null);
}
if ($table=='anniversary')
{
$data['mname']=(isset($_POST['mname'])?$_POST['mname']:null);
$data['fname']=(isset($_POST['fname'])?$_POST['fname']:null);
}
$data['dd']=(isset($_POST['dd']) && $_POST['dd']!='d'?$_POST['dd']:null);
$data['mm']=(isset($_POST['mm']) && $_POST['mm']!='m'?$_POST['mm']:null);
$data['yy']=(isset($_POST['yy']) && $_POST['yy']!='y'?$_POST['yy']:'0000');

  echo json_encode($db->insert($table,$data));
  break;
}
?>