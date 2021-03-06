<?php
$pdo = new PDO("データベース名;ホスト名",'ユーザー名','パスワード');//接続
$stmt = $pdo->query('SET NAMES utf8');//文字化け防止
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//エラーを表示させる
ini_set('display_errors', 1); //エラーを表示させる
error_reporting(E_ALL & ~E_NOTICE);//エラーを表示させる

// 変数

$name = filter_input(INPUT_POST, 'name'); //名前格納
$comment = filter_input(INPUT_POST, 'comment'); //コメント格納
$pass = filter_input(INPUT_POST, 'pass');//パスワード格納
$delete = filter_input(INPUT_POST, 'delete'); //削除格納
$edit_num = $_POST['edit'];//編集番号格納

$sql = 'SELECT * FROM test3;';
$results = $pdo->query($sql);

?>


<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<title>🦉フクロウ掲示板🦉</title>
</head>
<body>

<h1>🦉フクロウ掲示板🦉</h1>
<form action="mission_3-8.php" method="post" enctype="multipart/form-data">

<?php

session_start();
echo '🦉'.$_SESSION['name'].'様がログイン中<br>';

//編集機能

if (!empty($_POST['edit2'])) {
	foreach($results as $row){
		if ($row['num'] == $edit_num) { //送信した数と既存の投稿番号が一致したとき実行
			if($_POST['pass3'] == $row['password']){//送信したパスと設定したパスが一致したとき実行
				$name2 = $row['name'];
				$comment2 = $row['comment'];
				$pass4 = $row['password'];
				echo '🦉'.$edit_num.'番を編集します';
			}else if ($_POST['pass3'] != $row['password']){
				echo '🦉パスワードが違います!';
				echo nl2br("\n");
			}
		}
	} 
}

// 削除機能

if(!empty($_POST['delete2'])) {
	foreach($results as $row){
		if($row['num'] == $_POST['delete']) { //送信した数と既存の投稿番号が一致したとき実行
			if($_POST['pass2'] == $row['password']){//送信したパスと設定したパスが一致したとき実行
				$sql = "delete from test3 where num=".$row['num'];
				$result = $pdo->query($sql);
			}else if ($_POST['pass2'] != $row['password']){
				echo '🦉パスワードが違います!';
				echo nl2br("\n");
			}
		}
	}
}

//画面に表示

if (!empty($_POST['write'])) {
	if (strlen($name) > 0 && strlen($comment) > 0  && strlen($pass) > 0){//名前コメントパスワード全て
	}else if (strlen($comment) > 0  && strlen($pass) > 0) {
		echo '🦉お名前が未入力です'; //パスワードとコメントのみ
		echo nl2br("\n");
		echo nl2br("\n");
	}else if (strlen($name) > 0 && strlen($comment) > 0) {//名前とコメントのみ
		echo '🦉パスワードが未入力です'; 
		echo nl2br("\n");
		echo nl2br("\n");
	}else if (strlen($name) > 0  && strlen($pass) > 0) {//パスワードと名前のみ
		echo '🦉コメントが未入力です'; 
		echo nl2br("\n");
		echo nl2br("\n");
	}else if(strlen($name) > 0){//名前のみ
		echo '🦉コメントとパスワードが未入力です'; 
		echo nl2br("\n");
		echo nl2br("\n");
	}else if (strlen($comment) > 0) {//コメのみ
		echo '🦉お名前とパスワードが未入力です'; 
		echo nl2br("\n");
		echo nl2br("\n");
	}else if (strlen($pass) > 0) {//パスのみ
		echo '🦉お名前とコメントが未入力です'; 
		echo nl2br("\n");
		echo nl2br("\n");
	}
}

?>

<p><label>お名前：
<input type="text" maxlength="255" placeholder="お名前を入力" name="name" value = "<?php
echo $_SESSION['name'];

if (isset($_POST['edit2'])) {
	echo $name2;

}?>">
</label></p>
<p><label>コメント：
<input type="text" maxlength="255" placeholder="コメントを入力" name="comment" value = "<?php
if (!empty($_POST['edit2'])) {
	echo $comment2;

}?>">
</label></p>
<p><label>パスワードを設定してください：
<input type="text" maxlength="255" placeholder="パスワードを設定" name="pass" value = "<?php
if (!empty($_POST['edit2'])) {
	echo $pass4;

}?>">
<br />※パスワードは削除と編集をするときに使います!<br /></label></p>
<p><label>画像または動画をアップロード:
<input type="file" name="datafile"></label></p>
<input type="submit" name ="write" value ="投稿">
<input type="hidden" name="edit3" value = "<?php 
if (!empty($_POST['edit2'])) {
	echo $name2;

}?>">
<input type="hidden" name="edit4" value = "<?php 
if (!empty($_POST['edit2'])) {
	echo $comment2;

}?>">
<input type="hidden" name="edit5" value = "<?php 
if (!empty($_POST['edit2'])) {
	echo $edit_num;

}?>">
<input type="hidden" name="pass3" value = "<?php 
if (!empty($_POST['edit2'])) {
	echo $pass4;

}?>">
</form>
<hr>

<form action="mission_3-8.php" method="post">
<p><label>削除対象番号：
<input type="text" maxlength="255" placeholder="削除番号を入力" name="delete">
<p><label>パスワード：
<input type="text" maxlength="255" placeholder="パスワードを入力" name="pass2">
<br />※削除対象番号は半角数字で入力してください</label></p>
<input type="submit" name ="delete2" value ="削除">
</form>
<hr>

<form action="mission_3-8.php" method="post">
<p><label>編集対象番号：
<input type="text" maxlength="255" placeholder="編集番号を入力" name="edit">
<p><label>パスワード：
<input type="text" maxlength="255" placeholder="パスワードを入力" name="pass3">
<br />※編集対象番号は半角数字で入力してください</label></p>
<input type="submit" name ="edit2" value ="編集">
<hr>
<a href="http://co-400.it.99sv-coco.com/mission_3-10.php">アンケートページ</a>
<hr>
</form>

<?php

//編集機能

if(!empty($_POST['edit3']) && !empty($_POST['edit4']) && !empty($_POST['pass3'])) {
	$edit_num = $_POST['edit5'];
		foreach($results as $row){
			if ($row['num'] == $edit_num) { //送信した数と既存の投稿番号が一致したとき実行
				$num = $row['num'];
				$nm = $_POST['name']; 
				$kome = $_POST['comment'];
				$pass_edit = $_POST['pass'];
				$sql = "update test3 set name='$nm',comment='$kome',password='$pass_edit' where num = '$num';";
				$result = $pdo->query($sql);
			}
		}
}


//通常書き込み

if (($_FILES['datafile']['size'] == 0) && strlen($name) > 0 && strlen($comment) > 0 && strlen($pass) > 0 && empty($_POST['edit3']) && empty($_POST['edit4'])){ //名前コメントパスワード入っていたら
	//投稿番号/名前/コメント/日付/パスワード
	$sql = $pdo->prepare("INSERT INTO test3 (name,comment,ext,date,password) VALUES(:name,:comment,:ext,now(),:password)");
	$sql->bindParam(':name',$name,PDO::PARAM_STR);
	$sql->bindParam(':comment',$comment,PDO::PARAM_STR);
	$sql->bindParam(':ext',$ext_null);
	$sql->bindParam(':password',$pass,PDO::PARAM_STR);
	$ext_null = "";
	$sql->execute();
}

//画像か動画アップロード付き書き込み


if(!empty($_FILES['datafile']) && strlen($name) > 0 && strlen($comment) > 0 && strlen($pass) > 0 && empty($_POST['edit3']) && empty($_POST['edit4'])){

	$img = file_get_contents($_FILES['datafile']['tmp_name']);//画像動画パス
	$ext = pathinfo($_FILES['datafile']['name'], PATHINFO_EXTENSION);//拡張子抽出

	$image_array = array('gif','jpeg','jpg','png','JPG','JPEG','bmp');
	$video_array = array('wmv','avi','mpeg','mpg','vob','ogm','mov','rm','divx','mp4');


	foreach($image_array as $imagearray){//画像ならDBのvideoに保存
		if($imagearray == $ext){
			$stmt = $pdo->prepare("INSERT INTO test3 (name,comment,ext,image,date,password) VALUES(:name,:comment,:ext,:img,now(),:password)");
				$stmt->bindParam(':name',$name,PDO::PARAM_STR);
				$stmt->bindParam(':comment',$comment,PDO::PARAM_STR);
				$stmt->bindParam(':ext',$ext);
				$stmt->bindParam(':img',$img);
				$stmt->bindParam(':password',$pass,PDO::PARAM_STR);
				$stmt->execute();
		}
	}
		
	foreach($video_array as $videoarray){//動画ならDBのvideoに保存
		if($videoarray == $ext){
			$stmt = $pdo->prepare("INSERT INTO test3 (name,comment,ext,video,date,password) VALUES(:name,:comment,:ext,:video,now(),:password)");
				$stmt->bindParam(':name',$name,PDO::PARAM_STR);
				$stmt->bindParam(':comment',$comment,PDO::PARAM_STR);
				$stmt->bindParam(':ext',$ext);
				$stmt->bindParam(':video',$img);
				$stmt->bindParam(':password',$pass,PDO::PARAM_STR);
				$stmt->execute();
		
		}
	}

}

//画面に表示

$sql = 'SELECT * FROM test3 order by num;';
$results = $pdo->query($sql);

foreach($results as $row){
	//イイネボタン
	echo '<form action="mission_3-8.php" method="post">';
	echo '<input type="submit" name ="iine" value ="イイネ!">';
	echo '<input type="hidden" name="iine_num" value = '.$row['num'].'>';
	
	$count = $row['iine'];
		if($_POST['iine_num'] == $row['num']){
			$count = $row['iine'] + 1;
			$sql = "UPDATE test3 set iine = '".$count."' where num ='".$_POST['iine_num']."';";
			$stmt = $pdo->query($sql);
		}
	echo $count;
	echo '</form>';
		if(!empty($row['image'])){
			echo '投稿番号:'.$row['num'].'<br>';
			echo '<img src="./img.php?key='.$row['num'].'" /><br>';
			echo '名前:'.$row['name'].'<br>';
			echo 'コメント:'.$row['comment'].'<br>';
			echo $row['date'].'<br>';
			echo '<br>';
		}else if(!empty($row['video'])){
			echo '投稿番号:'.$row['num'].'<br>';
			echo '<video src="./video.php?key='.$row['num'].'" width="440" height="260"></video><br>';
			echo '名前:'.$row['name'].'<br>';
			echo 'コメント:'.$row['comment'].'<br>';
			echo $row['date'].'<br>';
			echo '<br>';
		}else if(empty($row['image']) && empty($row['video'])){
			echo '投稿番号:'.$row['num'].'<br>';
			echo '名前:'.$row['name'].'<br>';
			echo 'コメント:'.$row['comment'].'<br>';
			echo $row['date'].'<br>';
			echo '<br>';
		}
}

?>


</body>
</html>
