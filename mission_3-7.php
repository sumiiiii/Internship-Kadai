<?php
$pdo = new PDO("データベース名;ホスト名",'ユーザー名','パスワード');//接続
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//エラーを表示させる
$stmt = $pdo->query('SET NAMES utf8');//文字化け防止

ini_set('display_errors', 1); //エラーを表示させる
error_reporting(E_ALL & ~E_NOTICE);//エラーを表示させる
?>


<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<title>🦉フクロウ掲示板ログインフォーム🦉</title>
</head>
<body>

<h1>🦉フクロウ掲示板🦉</h1>
<form action="mission_3-7.php" method="post">

<h4>🦉ログインをしてください</h4>
<p><label>お名前
<input type="text" maxlength="255" placeholder="お名前を入力" name="name">
</label></p>
<p><label>パスワード
<input type="text" maxlength="255" placeholder="パスワードを入力" name="pass">
</label></p>
<input type="submit" name ="login" value ="ログイン">
</form>


<?php
session_start();

$sql = 'SELECT * FROM test3;';
$results = $pdo->query($sql);

if(!empty($_POST['login'])){
	foreach($results as $row){
		if($row['flag'] == 1 && $row['name'] == $_POST['name'] && $row['password'] == $_POST['pass'] ){
			$_SESSION['name'] = $_POST['name'];
			$_SESSION['pass'] = $_POST['pass'];
			$_SESSION['id'] = $row['id'];
			header("location: mission_3-8.php");
		}else if(
			$row['name'] != $_POST['name'] ||
			$row['password'] != $_POST['pass'] ||
			($row['name'] != $_POST['name'] && $row['password'] != $_POST['pass']) ||
			(empty($_POST['name']) && empty($_POST['pass'])) || $row['flag'] == 0){
			$a ='🦉IDもしくはパスワードが違います!';
		}
	}
	echo nl2br("\n");
	echo $a;
}
?>

</body>
</html>