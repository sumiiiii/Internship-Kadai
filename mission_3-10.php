<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<title>🦉アンケート機能🦉</title>
</head>
<body>

<h1>🦉アンケート機能🦉</h1>
<form action="mission_3-10.php" method="post">

<?php

$pdo = new PDO("データベース名;ホスト名",'ユーザー名','パスワード');//接続
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//エラーを表示させる
$stmt = $pdo->query('SET NAMES utf8');//文字化け防止

$anke = $_POST['anke'];
$kai1 = $_POST['kai1'];
$kai2 = $_POST['kai2'];
$kai3 = $_POST['kai3'];

//投稿された内容をDBに保存

if(!empty($_POST['toukou'])){
	if(!empty($anke) && !empty($kai1) && !empty($kai2) && !empty($kai3)){
		$sql = $pdo->prepare("INSERT INTO test4 (anke,kai1,kai2,kai3) VALUES(:anke,:kai1,:kai2,:kai3)");
		$sql->bindParam(':anke',$anke,PDO::PARAM_STR);
		$sql->bindParam(':kai1',$kai1,PDO::PARAM_STR);
		$sql->bindParam(':kai2',$kai2,PDO::PARAM_STR);
		$sql->bindParam(':kai3',$kai3,PDO::PARAM_STR);
		$sql->execute();
	}else if(empty($anke)){
		echo '🦉アンケート内容を入力してください';
	}else if(empty($kai1) || empty($kai2) || empty($kai3)){
		echo '🦉回答を入力してください';
	}
}

?>

<p><label>アンケート内容<br>
<input type="text" maxlength="255" size="80" placeholder="アンケート内容" name="anke">
</label></p>
<p><label>回答1
<input type="text" maxlength="255" placeholder="回答1" name="kai1">
</label></p>
<p><label>回答2
<input type="text" maxlength="255" placeholder="回答2" name="kai2">
</label></p>
<p><label>回答3
<input type="text" maxlength="255" placeholder="回答3" name="kai3">
</label></p>
<input type="submit" name ="toukou" value ="投稿">
</form>
<hr>

<?php

//保存した内容を出力

$sql = 'SELECT * FROM test4 order by num;';
$results = $pdo->query($sql);

foreach($results as $row){
	echo '<form action="mission_3-10_kaitou.php" method="post">';
	echo $row['num'].' ';
	echo $row['anke'].'<br>';
	echo '<input type="radio" name="kai" value="'.$row['kai1'].'">'.$row['kai1'].' ';
	echo '<input type="radio" name="kai" value="'.$row['kai2'].'">'.$row['kai2'].' ';
	echo '<input type="radio" name="kai" value="'.$row['kai3'].'">'.$row['kai3'].'<br>';
	echo '<input type="submit" name ="kaitou" value ="回答"><br>';
	echo '<input type="hidden" name="num" value = "'.$row['num'].'">';
	echo '<br>';
	echo '</form>';
}

?>

</body>
</html>