<?php
//smartyの宣言
define('SMARTY_RESOURCE_CHAR_SET','EUC-JP');
require './smarty-3.1.30/libs/Smarty.class.php';
$smarty = new Smarty();

$smarty->assign("title_pc", "フクロウ掲示板(pc)");
$smarty->assign("title_An", "フクロウ掲示板(スマホ)");

//DBに接続
$pdo = new PDO("データベース名;ホスト名",'ユーザー名','パスワード');
$stmt = $pdo->query('SET NAMES utf8');//文字化け防止
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//エラーを表示させる
ini_set('display_errors', 1); //エラーを表示させる
error_reporting(E_ALL & ~E_NOTICE);//エラーを表示させる


//名前コメントが書き込みされたらDBに保存
if(strlen($_POST['name']) > 0 && strlen($_POST['comment']) > 0){//名前とコメントあり
	$sql = $pdo->prepare("INSERT INTO test5 (name,comment,date) VALUES(:name,:comment,now())");
	$sql->bindParam(':name',$name,PDO::PARAM_STR);
	$sql->bindParam(':comment',$comment,PDO::PARAM_STR);
	$name = $_POST['name']; //名前格納
	$comment = $_POST['comment'];//コメント格納
	$sql->execute();
	$write = '1';//書き込みされたら$writeに1代入
}elseif(strlen($_POST['name']) > 0){//名前のみ
	$smarty->assign("comment_null", "コメントを入力してください!");
}elseif(strlen($_POST['comment']) > 0){//コメントのみ
	$smarty->assign("name_null", "名前を入力してください!");
}


//PEARのキャッシュライブラリを読み込み
require_once "Lite.php";
 
//オプションの設定
$cache_opt = array(
"cacheDir" => "./cache/", //キャッシュファイルの保存場所
"lifeTime" => 60, //キャッシュ時間
"pearErrorMode" => CACHE_LITE_ERROR_DIE //エラー
);

//キャッシュID設定
$cache_id = 'keijiban';

//オブジェクトを作成
$cache_obj = new Cache_Lite($cache_opt);
 
//キャッシュが存在する場合は、キャッシュを取得 
if($cache_obj->get($cache_id)){
	$data = $cache_obj->get($cache_id);
	$smarty->assign('syutoku', 'キャッシュあり');
		if($write == 1){//キャッシュで表示中書き込みされたらキャッシュを更新
			$sql = $pdo->query('select * from test5');
			//データを割り当てる
			$item = array();
				while($data = $sql->fetch(PDO::FETCH_ASSOC)) {
					$item[] = $data;
				}
			$item_mozi = serialize($item);//配列を文字列化
			//キャッシュがある場合は、キャッシュを文字列で保存
			$cache_obj->save($item_mozi, $cache_id);
		}else{//キャッシュで表示中書き込みされていないとき
			$item = unserialize($data);//文字列を配列に戻す
		}
}else{//キャッシュが存在しない場合は、キャッシュを保存
	$sql = $pdo->query('select * from test5');
	//データを割り当てる
	$item = array();
		while ($data = $sql->fetch(PDO::FETCH_ASSOC)) {
			$item[] = $data;
		}
	$item_mozi = serialize($item);//配列を文字列化
	$cache_obj->save($item_mozi, $cache_id);//配列から文字列に変換してからセーブしないとダメ
	$smarty->assign('hozon', 'キャッシュなし');
}

//Smartyにitemsという名前で配列を渡す
$smarty->assign('items', $item);

//データベース接続終了
$pdo = null;

//テンプレートに出力
$agent = $_SERVER['HTTP_USER_AGENT'];

//Android用
if((strpos($agent, 'Android') !== false)){
 $smarty->display("template2.tpl");
}

//pc用
else if(preg_match("/^Mozilla/",$agent) || preg_match("/^Chrome/",$agent)){
$smarty->display("template1.tpl");
}

?>