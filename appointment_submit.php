<?php
require_once __DIR__.'/includes/config.php';
header('Content-Type: application/json');

$required = ['full_name','phone','service','preferred_date','preferred_time'];
foreach($required as $r){
  if(empty($_POST[$r])){
    echo json_encode(['ok'=>false,'error'=>"Field $r wajib diisi."]);
    exit;
  }
}
$data = [
  'created_at'=>date('c'),
  'full_name'=>trim($_POST['full_name']??''),
  'phone'=>trim($_POST['phone']??''),
  'email'=>trim($_POST['email']??''),
  'service'=>trim($_POST['service']??''),
  'preferred_date'=>trim($_POST['preferred_date']??''),
  'preferred_time'=>trim($_POST['preferred_time']??''),
  'notes'=>trim($_POST['notes']??''),
];

try{
  $pdo = db();
  $stmt = $pdo->prepare('INSERT INTO appointments (created_at,full_name,phone,email,service,preferred_date,preferred_time,notes) VALUES (?,?,?,?,?,?,?,?)');
  $stmt->execute([$data['created_at'],$data['full_name'],$data['phone'],$data['email'],$data['service'],$data['preferred_date'],$data['preferred_time'],$data['notes']]);
  echo json_encode(['ok'=>true]);
}catch(Exception $e){
  http_response_code(500);
  echo json_encode(['ok'=>false,'error'=>'Database error']);
}
