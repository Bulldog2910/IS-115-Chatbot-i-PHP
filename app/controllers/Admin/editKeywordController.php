<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/../../config/dbOOP.php';
require_once __DIR__ . '/../../models/admin/editKeywordModel.php';
$conn->select_db('FAQUiaChatbot');

$err = [];
$log = [];

$editKeywordModel = new editkeyword($_POST['identificatorId'], $_POST['identificatorValue']);
$id = $editKeywordModel->keyword;
$keyword = $editKeywordModel->keywordId;

$stmt = $conn->prepare('SELECT * FROM keyWords WHERE keyword = ?');
$stmt->bind_param('s', $keyword);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

if($result->num_rows !== 0 ){
    $err['DB-01'] = 'Keyword allready exist with Keyid: ' . $row['keywordId'] ;
}else{
    $stmt = $conn->prepare('UPDATE keyWords SET keyword = ? WHERE keywordId = ?');
    $stmt->bind_param('si', $keyword, $id);
    if($stmt->execute()){
        $log[] = 'DB: updated correctly';
    } else{
        $err['DB-02'] = 'Error during update of keyword: ' . $stmt->error;
    }
}

$conn->close();
if(!empty($err)){
    foreach($err as $errorid => $errormessage){
    echo $errorid . ": " . $errormessage;
}
}

?>