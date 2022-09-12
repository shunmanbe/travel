<?php

//データベース接続
define("DSN", "mysql:dbname=(DB名);host=(DBホスト);charset=utf8");
define("MYSQL_USER", "(DBユーザ名)");
define("MYSQL_PASS", "(DBパスワード)");

$options = array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4',);
$pdo  = new PDO(DSN,MYSQL_USER,MYSQL_PASS,$options);
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

?>



<h2>出力</h2>

<?php

$api = intval($_REQUEST["api"]);

If($api>0){
	include ("output_api.php");		//apiデータの出力
}

?>


<table>
	<tr>
		<th></th>
		<th>JSON/XML</th>
	</tr>
	<tr>
		<th>都道府県</th>
		<td><a href="./?api=1">出力</a></td>
	</tr>
	<tr>
		<th>路線</th>
		<td><a href="./?api=2">出力</a></td>
	</tr>
	<tr>
		<th>駅</th>
		<td><a href="./?api=3">出力</a></td>
	</tr>
	<tr>
		<th>駅グループ</th>
		<td><a href="./?api=4">出力</a></td>
	</tr>
	<tr>
		<th>接続駅</th>
		<td><a href="./?api=5">出力</a></td>
	</tr>
</table>




