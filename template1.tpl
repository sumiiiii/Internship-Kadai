<!DOCTYPE html>
<html>
<head>
<title>smartyテスト(pc)</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

{* PC用コンテンツ *}

<center>
<h1>{$title_pc}</h1>
<form action="smarty1.php" method="post">
<p><label>お名前:</label>
<input type="text" name="name" value="" />
</p>
<p><label>コメント:</label>
<input type="text" name="comment" value="" />
</p>
<input type="submit" value="投稿" />
<hr>

{$comment_null}
{$name_null}

{$hozon}
{$syutoku}

{foreach $items as $itemdata}
{* 処理 *}
<p><div>No.{$itemdata.num}<br>
名前:{$itemdata.name}<br> 
コメント:{$itemdata.comment}<br>
{$itemdata.date|escape}<br></div></p>

{foreachelse}
{* 配列が空だった場合の処理 *}
表示させるデータがありません。
{/foreach}
 
</form>
</center>
</table>
 

</body>
</html>
