<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<title>🦉本登録完了🦉</title>
</head>
<body>

<h1>🦉フクロウ掲示板本登録完了🦉</h1>
<p>※本登録が完了致しました。下記からログインをしてください。</p>
<a href="http://co-400.it.99sv-coco.com/mission_3-7.php">ログインはこちら</a>
</form>

<?php

$pdo = new PDO("データベース名;ホスト名",'ユーザー名','パスワード');//接続
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//エラーを表示させる
$stmt = $pdo->query('SET NAMES utf8');//文字化け防止

$sql = 'SELECT * FROM test3;';
$results = $pdo->query($sql);

foreach($results as $row){
	if($row['id'] == $_GET['urltoken']){
		$sql = "UPDATE test3 set flag= '1' where id ='".$_GET['urltoken']."';";
		$stmt = $pdo->query($sql);
	}
}

?>

</body>
</html>