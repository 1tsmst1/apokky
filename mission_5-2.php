<html lang = "ja">
<head>
	<meta charset = "UTF-8">
</head>
<body>
<?php
//◆4-1◆【データベースへの接続】
//・データベース名： 
//・(MySQLホスト名)： localhost (固定)
//・ユーザー名： 
//・パスワード： 
$dsn = 'mysql:dbname=データベース名;host=localhost';
$user = 'ユーザー名';
$password = 'パスワード';
$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
//◆◆◆
//◆4-2◆【データベース内にテーブルを作成】
$sql = "CREATE TABLE IF NOT EXISTS tbtest"
." ("
. "id INT AUTO_INCREMENT PRIMARY KEY,"
. "name char(32),"
. "comment TEXT,"
. "date DATETIME"
.");";
$stmt = $pdo->query($sql);
//◆◆◆
//◆4-0◆【作成したテーブルを削除】
//$sql = 'DROP TABLE tbtest';
//$results = $pdo -> query($sql);
//◆◆◆
//◆4-3◆【作成したテーブルを一覧で表示する】
//$sql ='SHOW TABLES';
//$result = $pdo -> query($sql);
//foreach ($result as $row){
//	echo $row[0];
//	echo '<br>';
//}
//echo "<hr>";
//◆◆◆
//【パスワード】
$pass = "sanders"; //投稿パスワード「sanders」
$dpass = "tech";	//削除パスワード「tech」
$epass = "base";	//編集パスワード「base」
?>
<!-- 【フォーム】 -->
<!-- action データの送信先、method データの送信方法(post,get) -->
	<?php	//【Error: 空！！】
	//【投稿】
	if(!empty($_POST["post"])){	//[送信]押したとき
		if( empty($_POST["name"]) ){	//[名前]が空→「空だよ！」
			echo "!-------------------------------!" . "<br>";
			echo "Error: Name is Empty." . "<br>";
			echo "!-------------------------------!" . "<br>";
		} elseif( empty($_POST["comment"]) ) {	//[コメント]が空→「空だよ！」
			echo "!-------------------------------!" . "<br>";
			echo "Error: Comment is Empty." . "<br>";
			echo "!-------------------------------!" . "<br>";
		} elseif( empty($_POST["post_p"]) ) {	//[PW]が空→「空だよ！」
			echo "!-------------------------------!" . "<br>";
			echo "Error: Password is Empty." . "<br>";
			echo "!-------------------------------!" . "<br>";
		}
	}
	//【削除】
	if(!empty($_POST["delete"])){	//[削除]押したとき
		if( empty($_POST["deleteNo"]) ){	//[削除対象番号]が空→「空だよ！」
			echo "!-------------------------------!" . "<br>";
			echo "Error: Delete-Number is Empty." . "<br>";
			echo "!-------------------------------!" . "<br>";
		} elseif( empty($_POST["delete_p"]) ) {	//[削除PW]が空→「空だよ！」
			echo "!-------------------------------!" . "<br>";
			echo "Error: Password is Empty." . "<br>";
			echo "!-------------------------------!" . "<br>";
		}
	}
	//【編集】
	if(!empty($_POST["edit"])){	//[編集]押したとき
		if( empty($_POST["editNo"]) ){	//[編集対象番号]が空→「空だよ！」
			echo "!-------------------------------!" . "<br>";
			echo "Error: Edit-Number is Empty." . "<br>";
			echo "!-------------------------------!" . "<br>";
		} elseif( empty($_POST["edit_p"]) ) {	//[編集PW]が空→「空だよ！」
			echo "!-------------------------------!" . "<br>";
			echo "Error: Password is Empty." . "<br>";
			echo "!-------------------------------!" . "<br>";
		}
	}
	?>
<form action="mission_5-2.php" method="post">
	<!-- 入力フォーム -->
		 	<!-- <input> text 一行入力項目の表示。name で指定したキーワードをもとにphpでデータを受け取る -->
		名前　　　　：
			<input type="text" name="name" size="30" value="<?php
				if ( !empty($_POST["edit"]) && !empty($_POST["edit_p"]) && ($_POST["edit_p"] == $epass) ) {
					$sql = 'SELECT * FROM tbtest';
					$stmt = $pdo->query($sql);
					$results = $stmt->fetchAll();
					foreach ($results as $row){
						if($row['id'] == $_POST["editNo"]){;
							echo $row['name'];
						}
					}
				}
			?>" /><br />
		コメント　　：
			<input type="text" name="comment" size="30" value="<?php
				if ( !empty($_POST["edit"]) && !empty($_POST["edit_p"]) && ($_POST["edit_p"] == $epass) ) {
					$sql = 'SELECT * FROM tbtest';
					$stmt = $pdo->query($sql);
					$results = $stmt->fetchAll();
					foreach ($results as $row){
						if($row['id'] == $_POST["editNo"]){;
							echo $row['comment'];
						}
					}
				}
 			?>" /><br />
		パスワード　：	<!-- ☆3-5-1☆ -->
			<input type="text" name="post_p" size="30" value="" />
		<!-- 編集する番号 -->
			<input type="hidden" name="edit_No" size="30" value="<?php
				if ( !empty($_POST["edit"]) && !empty($_POST["edit_p"]) && ($_POST["edit_p"] == $epass) ) {
					$sql = 'SELECT * FROM tbtest';
					$stmt = $pdo->query($sql);
					$results = $stmt->fetchAll();
					foreach ($results as $row){
						if($row['id'] == $_POST["editNo"]){;
							echo $row['id'];
						}
					}
				}
			?>" />
		<!-- 送信ボタン -->
	 		 <!-- <input> submit データ送信ボタンの表示。value で指定した語句がボタンに表示される。-->
			<input type="submit" name = "post" value="送信" /><br />
	<!-- 削除フォーム -->
		<!-- 削除機能 -->
		削除対象番号：
			<input type="text" name="deleteNo" size="30" value="" /><br />
		パスワード　：	<!-- ☆3-5-3☆ -->
			<input type="text" name="delete_p" size="30" value="" />
		<!-- 削除ボタン -->
			<input type="submit" name="delete" value="削除" /><br />
	<!-- 編集番号指定用フォーム -->
		<!-- 編集対象番号の入力 -->
		編集対象番号：
			<input type="text" name="editNo" size="30" value="" /><br />
		パスワード　：	<!-- ☆3-5-3☆ -->
			<input type="text" name="edit_p" size="30" value="" />
		<!-- 編集ボタン -->
			<input type="submit" name="edit" value="編集" /><br />
	<?php	//【Error: パスワード違うよ！！】
		if( ( (!empty($_POST["name"])) && (!empty($_POST["comment"])) && (!empty($_POST["post_p"])) && ($_POST["post_p"] != $pass) )
		 || ( (!empty($_POST["deleteNo"])) && (!empty($_POST["delete_p"])) && ($_POST["delete_p"] != $dpass) )
		 || ( (!empty($_POST["edit"])) && (!empty($_POST["edit_p"])) && ($_POST["edit_p"] != $epass) ) ){
			echo "!-------------------------------!" . "<br>";
			echo "Error: Password is invalid." . "<br>";
			echo "!-------------------------------!" . "<br>";
		}
	?>
	<?php	
		echo "---------------------------------" . "<br>";
		echo "【　投稿一覧　】" . "<br>";
	?>
</form>
<?php
if ( (!empty($_POST["name"])) && (!empty($_POST["comment"])) && (!empty($_POST["post_p"])) && ($_POST["post_p"] == $pass) ) {	//【保存機能】
//【編集実行機能】
	if ( !empty($_POST["edit_No"])) {
//◆4-7◆【 [UPDATE] データの更新】
		$id = $_POST["edit_No"];
		$name = $_POST["name"];	//"変更したい名前"
		$comment = $_POST["comment"];	//"変更したいコメント"
		date_default_timezone_set('Asia/Tokyo');
		$date = date('Y-m-d H:i:s');
		$sql = 'update tbtest set name=:name,comment=:comment,date=:date where id=:id';
		$stmt = $pdo->prepare($sql);
		$stmt->bindParam(':name', $name, PDO::PARAM_STR);
		$stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
		$stmt->bindParam(':date', $date, PDO::PARAM_STR);
		$stmt->bindParam(':id', $id, PDO::PARAM_INT);
		$stmt->execute();
//◆◆◆
	} else {
//【新規投稿】
//◆4-5◆【 [INSERT] データの挿入】
		$sql = $pdo -> prepare("INSERT INTO tbtest (name, comment, date) VALUES (:name, :comment, :date)");
		$sql -> bindParam(':name', $name, PDO::PARAM_STR);
		$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
		$sql -> bindParam(':date', $date, PDO::PARAM_STR);
		//好きな名前、好きな言葉は自分で決めること
		$name = $_POST["name"];	//"好きな名前"
		$comment = $_POST["comment"];	//"好きなコメント"
		date_default_timezone_set('Asia/Tokyo');
		$date = date('Y-m-d H:i:s');
		$sql -> execute();
//◆◆◆
	}
} elseif ( (!empty($_POST["deleteNo"])) && (!empty($_POST["delete_p"])) && ($_POST["delete_p"] == $dpass) ){
//【削除処理】
//◆4-8◆【 [DELETE] データの削除】
	$id = $_POST["deleteNo"];
	$sql = 'delete from tbtest where id=:id';
	$stmt = $pdo->prepare($sql);
	$stmt->bindParam(':id', $id, PDO::PARAM_INT);
	$stmt->execute();
//◆◆◆
}
//【表示機能】
//◆4-6◆【 [SELECT] データの表示】
$sql = 'SELECT * FROM tbtest';
$stmt = $pdo->query($sql);
$results = $stmt->fetchAll();
foreach ($results as $row){
	echo $row['id'].', ';	//$rowの中にはテーブルのカラム名が入る
	echo $row['name'].', ';
	echo $row['comment'].', ';
	echo $row['date'].'<br>';
//echo "<hr>";
//◆◆◆
}
?>
</body>
</html>
