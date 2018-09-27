<?php
//初期設定
session_start();
include("function.php");

if(!isset($_POST["lid"]) || !isset($_POST["lpw"])){
    header("Location: ../login.php?alert=1");
    exit();
}else if( $_POST["lid"] == "" || $_POST["lpw"] == ""){
    header("Location: ../login.php?alert=2");
    exit();
}
//数値の読み取り
$lid = $_POST["lid"];
$lpw = $_POST["lpw"];

//データベース接続
$pdo = db_connect();

//SQLの指定
$sql = "SELECT * 
        FROM gs_librualy_controle
        WHERE u_id=:lid
        AND u_pw=:lpw";

//SQLの実行
$stmt = $pdo -> prepare($sql);
$stmt -> bindValue(":lid", $lid, PDO::PARAM_STR);
$stmt -> bindValue(":lpw", $lpw, PDO::PARAM_STR);
$status = $stmt -> execute();

//SQL実行検証
if($status == false){
    $error = $stmt -> erroInfo;
    exit("SQL関連が間違っています".$error);
}

//データ取得
$val = $stmt -> fetch();

//取得データ参照
if($val["id"] != ""){
    $_SESSION["ssid"] = session_id();
    $_SESSION["u_name"] = $val["u_name"];
    $_SESSION["u_id"] = $val["u_id"];
    header("Location: ../look.php?login=1");
}else{
    //認証失敗
    header("LOcation: ../login.php?alert=3");
}

?>