<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<title>🦉メール確認画面🦉</title>
</head>
<body>

<h1>🦉メール確認画面🦉</h1>
<form action="mission_3-9.php" method="post">

<?php
$pdo = new PDO("データベース名;ホスト名",'ユーザー名','パスワード');//接続
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//エラーを表示させる
$stmt = $pdo->query('SET NAMES utf8');//文字化け防止

$name = $_POST['name'];
$pass = $_POST['pass'];
$mail = $_POST['mail'];

if(!empty($_POST['touroku'])){
	if(!empty($name) && !empty($pass) && !empty($mail)){
		$sql = $pdo->prepare("INSERT INTO test3 (name,id,password,mail) VALUES(:name,:id,:password,:mail)");
		$sql->bindParam(':name',$name,PDO::PARAM_STR);
		$sql->bindParam(':id',$id,PDO::PARAM_STR);
		$sql->bindParam(':password',$pass,PDO::PARAM_STR);
		$sql->bindParam(':mail',$mail,PDO::PARAM_STR);
		$id = uniqid();//仮ID作成
		$sql->execute();
	}else if(empty($name) && empty($pass) && empty($mail)){
		echo '🦉必要事項をご記入ください';
		echo nl2br("\n");
		echo nl2br("\n");
	}else if (strlen($pass) > 0  && strlen($mail) > 0) {//パスワードとコメントのみ
		echo '🦉お名前が未入力です'; 
		echo nl2br("\n");
		echo nl2br("\n");
	}else if (strlen($name) > 0 && strlen($mail) > 0) {//名前とメアドのみ
		echo '🦉パスワードが未入力です'; 
		echo nl2br("\n");
		echo nl2br("\n");
	}else if (strlen($name) > 0  && strlen($pass) > 0) {//パスワードと名前のみ
		echo '🦉メールアドレスが未入力です'; 
		echo nl2br("\n");
		echo nl2br("\n");
	}else if(strlen($name) > 0){//名前のみ
		echo '🦉パスワードとメールアドレスが未入力です'; 
		echo nl2br("\n");
		echo nl2br("\n");
	}else if (strlen($mail) > 0) {//メアドのみ
		echo '🦉お名前とパスワードが未入力です'; 
		echo nl2br("\n");
		echo nl2br("\n");
	}
	else　if (strlen($pass) > 0) {//パスのみ
		echo '🦉お名前とメールアドレスが未入力です'; 
		echo nl2br("\n");
		echo nl2br("\n");
	}
}

if(!empty($name) && !empty($pass) && !empty($mail)){
	echo  '※メールをお送りしました。24時間以内にメールに記載されたURLからご登録下さい。';
	echo nl2br("\n");

	$sql = 'SELECT * FROM test3;';
	$results = $pdo->query($sql);

	foreach($results as $row){
	}

	$url = "http://co-400.it.99sv-coco.com/mission_3-9_form.php"."?urltoken=".$row['id'];

	//メール
	mb_language("Japanese");
	mb_internal_encoding("UTF-8");

	$to = $_POST['mail'];//メールの宛先
	$subject = '【フクロウ掲示板】会員登録用URLのお知らせ';
$message = <<< EOF
24時間以内に以下のURLから本登録して下さい。
$url

お名前:$name
パスワード:$pass
EOF;
$headers = 'From: web@hukurou.com' . "\r\n";

mb_send_mail($to, $subject, $message, $headers);
}
?>

<input type="submit" name ="return" value ="戻る">
</form>

</body>
</html>