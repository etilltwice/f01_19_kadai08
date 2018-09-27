<?php
//初期設定
session_start();
include("system/function.php");
loginCheck();

//データベース接続
$pdo = db_connect();

//登録SQL作成
$sql ="SELECT * 
       FROM gs_bm_table
       WHERE user_id=:u_id";

//データ読み込み
$stmt = $pdo -> prepare($sql);
$stmt->bindValue(":u_id", $_SESSION["u_id"], PDO::PARAM_INT);
$status = $stmt -> execute();

if($status == false){
    $error = $stmt -> errorInfo();
    exit("SQL構文が間違っています:".$error[2]);
}
//この先からhtml
?>


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div>
        <h1 style="background-color:green; color:white;">花台図書館</h1>
        <a href="user.php"><?=$_SESSION["u_name"] ?></a>
    </div>
    <div>
        <button onclick="jump('bookinsert.php')">新規登録</button>
        <button onclick="jump('system/logout.php')">ログアウト</button>
        <button>検索</button>
        <button>ランキング</button>
    </div>
    <div>
        <h2>あなたがブックマークした本の一覧</h1>
    </div>
    <div>
        <table style="boder:solid;">
        <?php  while($result = $stmt -> fetch(PDO::FETCH_ASSOC)): ?>
        <tr>
            <td class="id"><?=$result["id"] ?></td>
            <td class="name"><?=$result["name"] ?></td>
            <td><a href=<?=$result["URL"] ?>>urlへ</a></td>
            <td><button type="button" onclick="jump('change.php?id=<?=$result['id'] ?>')">編集</button></td>
            <td><button type="button" onclick="jump('system/delete.php?id=<?=$result['id'] ?>&target=book&come=../look.php&go=../look.php')">消去</button>
        </tr>
        <?php endwhile ?>
        </table>
    </div>

    <script>
        function jump(link){
            location.replace(link);
        }


    
    </script>
</body>
</html>