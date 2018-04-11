<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<title>🦉アンケート結果🦉</title>
</head>
<body>

<h1>🦉アンケート結果🦉</h1>
<form action="mission_3-10_kaitou.php" method="post">

<?php
$num = $_POST['num'];

$pdo = new PDO("データベース名;ホスト名",'ユーザー名','パスワード');//接続
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//エラーを表示させる
$stmt = $pdo->query('SET NAMES utf8');//文字化け防止

//カウント更新

$sql = 'SELECT * FROM test4;';
$results = $pdo->query($sql);

foreach($results as $row){
	if($num == $row['num']){
		if($_POST['kai'] == $row['kai1']){
			$count1 = $row['count1'] + 1;
			$sql = "UPDATE test4 set count1 = '$count1' where num ='$num';";
			$stmt = $pdo->query($sql);
		}else if($_POST['kai'] == $row['kai2']){
			$count2 = $row['count2'] + 1;
			$sql = "UPDATE test4 set count2 = '$count2' where num ='$num';";
			$stmt = $pdo->query($sql);
		}else if($_POST['kai'] == $row['kai3']){
			$count3 = $row['count3'] + 1;
			$sql = "UPDATE test4 set count3 = '$count3' where num ='$num';";
			$stmt = $pdo->query($sql);
		}
	}
}

//出力

if(!empty($_POST['kai'])){
	echo '回答ありがとうございました!<br>';
	echo 'あなたは'.$_POST['kai'].'に投票しました。<br>';
	echo '<br>';
	echo '↓現在の投票結果↓<br>';

	$sql = 'SELECT * FROM test4;';
	$results = $pdo->query($sql);

		foreach($results as $row){
			if($num == $row['num']){
				echo $row['kai1'].':'.$row['count1'].'人<br>';
				echo $row['kai2'].':'.$row['count2'].'人<br>';
				echo $row['kai3'].':'.$row['count3'].'人<br>';
			}
		}
}else if(empty($_POST['kai'])){
	echo '回答にチェックを入れてください!';
}
?>

</form>
<form action="mission_3-10.php" method="post"><br>
<input type="submit" name ="return" value ="戻る">
</form>
</body>
</html>