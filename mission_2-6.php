<?php

ini_set('display_errors', 1); //エラーを表示させる
error_reporting(E_ALL & ~E_NOTICE);//エラーを表示させる
date_default_timezone_set('Asia/Tokyo'); //タイムゾーンの設定

// 変数

$filename = 'message4.txt';//投稿番号/名前/コメント/日付/パスワード
$name = filter_input(INPUT_POST, 'name'); //名前格納
$comment = filter_input(INPUT_POST, 'comment'); //コメント格納
$pass = filter_input(INPUT_POST, 'pass');//パスワード格納
$date = date('Y/m/d H:i:s'); //日時格納
$delete = filter_input(INPUT_POST, 'delete'); //削除格納
$edit_num = $_POST['edit'];//編集番号を$edit_numに代入

?>


<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8">
<title>🦉フクロウ掲示板🦉</title>
</head>
<body>

<h1>🦉フクロウ掲示板🦉</h1>
<form action="mission_2-6.php" method="post">

<?php

//編集機能

if (!empty($_POST['edit2'])) {
	$ret_array = file($filename); //message4.txtを全て配列に入れる
	foreach($ret_array as $retarray) { //message4.txtを全て配列に入れる
		$exp_array = explode("<>", $retarray); //<>で分割
		$number = $exp_array[0]; //分割した投稿番号取得
		$exp_pass3 = $exp_array[4]; //分割したパスワード取得
			if ($number == $edit_num) { //送信した数と既存の投稿番号が一致したとき実行
				if($_POST['pass3'] == $exp_pass3){//送信したパスと設定したパスが一致したとき実行
					$name2 = $exp_array[1]; //分割した名前
					$comment2 = $exp_array[2]; //分割したコメント 
					$pass4 = $exp_array[4];//分割したパス
					echo '🦉'.$edit_num.'番を編集します';
				}else if (!empty($_POST['edit2']) && $_POST['pass3'] != $exp_pass3){
					echo '🦉パスワードが違います!';
					echo nl2br("\n");
				}
			}
	} 
}

// 削除機能

if (!empty($_POST['delete2'])) {
	$ret_array = file($filename); //message4.txtを全て配列に入れる
	$i = 0;
		foreach($ret_array as $retarray) { //message4.txtを全て配列に入れる
			$exp_array = explode("<>", $retarray); //<>で分割
			$number = $exp_array[0]; //分割した投稿番号のみ取得
			$exp_pass2 = $exp_array[4]; //分割しパスワード
			$num = $i++;
				if ($number == $_POST['delete']) { //送信した数と既存の投稿番号が一致したとき実行
					if($_POST['pass2'] == $exp_pass2){//送信したパスと設定したパスが一致したとき実行
						unset($ret_array[$num]); //削除
						file_put_contents($filename, $ret_array); //message4.txtに書き込み
					}else if ($_POST['pass2'] != $exp_pass2){
						echo '🦉パスワードが違います!';
						echo nl2br("\n");
					}
				}
		}
}

//画面に表示

if (!empty($_POST['write'])) {
	if (strlen($name) > 0 && strlen($comment) > 0  && strlen($pass) > 0){ //名前コメントパスワード全て
	}else if (strlen($comment) > 0  && strlen($pass) > 0) { //パスワードとコメントのみ
		echo '🦉お名前が未入力です'; 
		echo nl2br("\n");
		echo nl2br("\n");
	}else if (strlen($name) > 0 && strlen($comment) > 0) {//名前とコメントのみ
		echo '🦉パスワードが未入力です'; 
		echo nl2br("\n");
		echo nl2br("\n");
	}else if (strlen($name) > 0  && strlen($pass) > 0) { //パスワードと名前のみ
		echo '🦉コメントが未入力です'; 
		echo nl2br("\n");
		echo nl2br("\n");
	}else if(strlen($name) > 0){ //名前のみ
		echo '🦉コメントとパスワードが未入力です'; 
		echo nl2br("\n");
		echo nl2br("\n");
	}else if (strlen($comment) > 0) { //コメのみ
		echo '🦉お名前とパスワードが未入力です'; 
		echo nl2br("\n");
		echo nl2br("\n");
	}else if(strlen($pass) > 0) { //パスのみ
		echo '🦉お名前とコメントが未入力です'; 
		echo nl2br("\n");
		echo nl2br("\n");
	}
}

?>

<p><label>お名前：
<input type="text" maxlength="255" placeholder="お名前を入力" name="name" value = "<?php
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

<form action="mission_2-6.php" method="post">
<p><label>削除対象番号：
<input type="text" maxlength="255" placeholder="削除番号を入力" name="delete">
<p><label>パスワード：
<input type="text" maxlength="255" placeholder="パスワードを入力" name="pass2">
<br />※削除対象番号は半角数字で入力してください</label></p>
<input type="submit" name ="delete2" value ="削除">
</form>
<hr>

<form action="mission_2-6.php" method="post">
<p><label>編集対象番号：
<input type="text" maxlength="255" placeholder="編集番号を入力" name="edit">
<p><label>パスワード：
<input type="text" maxlength="255" placeholder="パスワードを入力" name="pass3">
<br />※編集対象番号は半角数字で入力してください</label></p>
<input type="submit" name ="edit2" value ="編集">
</form>
<hr>


<?php

//編集機能

if (!empty($_POST['edit3']) && !empty($_POST['edit4']) && !empty($_POST['pass3'])) {
	$name_new = $_POST["name"];
	$comment_new = $_POST["comment"];
	$pass_new = $_POST["pass"];
	$edit_num = $_POST['edit5'];
	$ret_array = file($filename); //message4.txtを全て配列に入れる
	$fp = fopen($filename, "w+"); //message4.txtを上書きで開く
		foreach($ret_array as $retarray) { //message4.txtを全て配列に入れる
			$exp_array = explode("<>", $retarray); //<>で分割
			$number = $exp_array[0]; //分割した投稿番号のみ取得
				if ($number == $edit_num) { //送信した数と既存の投稿番号が一致したとき実行
					//既存と新規の名前を交換
					$tmp = $_POST['edit3'];
					$_POST['edit3'] = $name_new;
					$name_new = $tmp;
					//既存と新規のコメントを交換
					$tmp2 = $_POST['edit4'];
					$_POST['edit4'] = $comment_new;
					$comment_new = $tmp2;
					//既存と新規のパスを交換
					$tmp3 = $_POST['pass3'];
					$_POST['pass3'] = $pass_new;
					$pass_new = $tmp3;
					$str = $number . '<>' . $_POST['edit3'] . '<>' . $_POST['edit4'] . '<>' . $date .'<>'. $_POST['pass3']. '<>'."\n";
					fputs($fp, $str);//新規の名前とコメント書き込み
				}else{//送信した数と既存の投稿番号が一致しないとき
					fputs($fp,$retarray);
				}
		}
	fclose($fp);
}

// message3.txtに一行ずつ書き込み

if(strlen($name) > 0 && strlen($comment) > 0 && strlen($pass) > 0 && empty($_POST['edit3']) && empty($_POST['edit4'])) {	//名前コメントパスワード入っていたら
	//投稿番号/名前/コメント/日付/パスワード
	$fp2 = fopen('write2.txt','r');
	$num_text = fgets($fp2);//一行目を文字列として読み取る
	fclose($fp2);

	$number = (int)$num_text;//文字列をint型に変換
	$number += 1;//1増やす

	$fp2 = fopen('write2.txt','w');//カウント用ファイルを空にして開く
	fwrite($fp2,$number);//新しい数値を書き込む
	fclose($fp2);

	$str = $number . '<>' . $name . '<>' . $comment . '<>' . $date .'<>'. $pass .'<>'. "\n";
	$fp = fopen($filename, "a"); //message4.txtに$strを追記書き込み
	fwrite($fp, $str);
	fclose($fp);
}

//画面に表示

$ret_array = file($filename); //message4.txtを全て配列に入れる
	foreach($ret_array as $retarray) { //配列の要素を変数に詰める
		$exp_array = explode("<>", $retarray); //<>で分割
		$number = $exp_array[0]; //分割した投稿番号
		$name2 = $exp_array[1]; //分割した名前
		$comment2 = $exp_array[2]; //分割したコメント
		$date2 = $exp_array[3]; //分割した日付

		// 分割したのをmessageに代入

echo nl2br("\n");
$message = <<< EOF
投稿番号:$number<br />
名前:$name2<br />
コメント:$comment2<br />
日付:$date2<br />
<br />
EOF;
echo $message;
	}

?>


</body>
</html>
