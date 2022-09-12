<?php

//出力先フォルダ
$dir_pref    = "./api/p/";
$dir_line    = "./api/l/";
$dir_station = "./api/s/";
$dir_group   = "./api/g/";
$dir_join    = "./api/n/";



$ar_pref = array("-","北海道","青森県","岩手県","宮城県","秋田県","山形県","福島県","茨城県","栃木県","群馬県","埼玉県","千葉県","東京都","神奈川県","新潟県","富山県","石川県","福井県","山梨県","長野県","岐阜県","静岡県","愛知県","三重県","滋賀県","京都府","大阪府","兵庫県","奈良県","和歌山県","鳥取県","島根県","岡山県","広島県","山口県","徳島県","香川県","愛媛県","高知県","福岡県","佐賀県","長崎県","熊本県","大分県","宮崎県","鹿児島県","沖縄県","その他");



If($api==1){

	for($i=1;$i<=47;$i++){

		$print = "";
		$print .= "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
		$print .= "<ekidata version=\"ekidata.jp pref api 1.0\">\n";
		$print .= "	<pref>\n";
		$print .= "		<code>" . $i . "</code>\n";
		$print .= "		<name>" . $ar_pref[$i] . "</name>\n";
		$print .= "	</pref>\n";

		$json = "";
		$json .= "\n";
		$json .= "if(typeof(xml)=='undefined') xml = {};\n";
		$json .= "xml.data = ";
		$json .= "{\"line\":[";

		$sql = "SELECT SQL_CALC_FOUND_ROWS";
		$sql .= " m_line.line_cd";
		$sql .= ",m_line.line_name";
		$sql .= ",m_line.e_status";
		$sql .= ",m_line.e_sort";
		$sql .= ",m_station.pref_cd";
		$sql .= " FROM m_station ";
		$sql .= " LEFT JOIN m_line ON m_line.line_cd = m_station.line_cd";
		$sql .= " WHERE m_station.pref_cd = " . $i . " AND m_line.e_status = 0 AND m_line.line_cd > 10000";
		$sql .= " GROUP BY";
		$sql .= " m_line.line_cd";
		$sql .= ",m_line.line_name";
		$sql .= ",m_line.e_status";
		$sql .= ",m_line.e_sort";
		$sql .= ",m_station.pref_cd";
		$sql .= " ORDER BY";
		$sql .= " m_line.e_status";
		$sql .= ",m_line.line_cd";
		$stmt = $pdo->prepare($sql);
		$stmt -> execute();
		$csth = $pdo->query("SELECT FOUND_ROWS()");
		$resultNumRows = $csth->fetchColumn();
		if($resultNumRows>0){
			$ii=0;
			foreach($stmt as $row){
				$line_cd   = $row['line_cd'];
				$line_name = $row['line_name'];

				$print .= "	<line>\n";
				$print .= "		<line_cd>" . $line_cd . "</line_cd>\n";
				$print .= "		<line_name>" . $line_name . "</line_name>\n";
				$print .= "	</line>\n";

				If($ii > 0){$json .= ",";}
				$json .= "{\"line_cd\":" . $line_cd . ",\"line_name\":\"" . htmlspecialchars($line_name, ENT_QUOTES) . "\"}";

				$ii++;

			}
		}

		$print .=  "</ekidata>\n";
		$json .= "]}\n";
		$json .= "if(typeof(xml.onload)=='function') xml.onload(xml.data);\n";

		//ファイル作成
		$make_file = $dir_pref . $i . ".xml";
		$fp = fopen($make_file,"w");
		fputs($fp,$print);
		fclose($fp);
		chmod ($make_file, 0666);

		//ファイル作成
		$make_file = $dir_pref . $i . ".json";
		$fp = fopen($make_file,"w");
		fputs($fp,$json);
		fclose($fp);
		chmod ($make_file, 0666);

		echo $i . " ";
	}

	echo "終わりました<br>";

}ElseIf($api==2){

	$sql = "SELECT SQL_CALC_FOUND_ROWS line_cd,line_name,lon,lat,zoom FROM m_line WHERE e_status = 0 AND line_type <> 1 ORDER BY e_sort,line_cd";
	$stmt = $pdo->prepare($sql);
	$stmt -> execute();
	$csth = $pdo->query("SELECT FOUND_ROWS()");
	$resultNumRows = $csth->fetchColumn();
	if($resultNumRows>0){
		foreach($stmt as $row){
			$line_cd   = $row['line_cd'];
			$line_name = $row['line_name'];
			$line_lon  = $row['lon'];
			$line_lat  = $row['lat'];
			$line_zoom = $row['zoom'];

			$print = "";
			$print .= "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
			$print .= "<ekidata version=\"ekidata.jp line api 1.0\">\n";
			$print .= "	<line>\n";
			$print .= "		<line_cd>" . $line_cd . "</line_cd>\n";
			$print .= "		<line_name>" . $line_name . "</line_name>\n";
			$print .= "		<line_lon>" . $line_lon . "</line_lon>\n";
			$print .= "		<line_lat>" . $line_lat . "</line_lat>\n";
			$print .= "		<line_zoom>" . $line_zoom . "</line_zoom>\n";
			$print .= "	</line>\n";

			$json = "";
			$json .= "\n";
			$json .= "if(typeof(xml)=='undefined') xml = {};\n";
			$json .= "xml.data = ";
			$json .= "{\"line_cd\":" . $line_cd . ",\"line_name\":\"" . $line_name . "\",\"line_lon\":" . $line_lon . ",\"line_lat\":" . $line_lat . ",\"line_zoom\":" . $line_zoom . ",";
			$json .= "\"station_l\":[";

			//駅一覧 ※新幹線は出力しない
			$sql2 = "SELECT SQL_CALC_FOUND_ROWS station_cd,station_g_cd,station_name,lon,lat";
			$sql2 .= "  FROM m_station";
			$sql2 .= " WHERE e_status = 0 AND station_cd > 1000000 AND line_cd = " . $line_cd;
			$sql2 .= " ORDER BY e_sort,station_cd";
			$stmt2 = $pdo->prepare($sql2);
			$stmt2 -> execute();
			$csth2 = $pdo->query("SELECT FOUND_ROWS()");
			$resultNumRows2 = $csth2->fetchColumn();
			if($resultNumRows2>0){
				$ii=0;
				foreach($stmt2 as $row2){

					$station_cd   = $row2['station_cd'];
					$station_g_cd = $row2['station_g_cd'];
					$lon          = $row2['lon'];
					$lat          = $row2['lat'];
					$station_name = $row2['station_name'];

					$print .= "	<station>\n";
					$print .= "		<station_cd>" . $station_cd . "</station_cd>\n";
					$print .= "		<station_g_cd>" . $station_g_cd . "</station_g_cd>\n";
					$print .= "		<station_name>" . $station_name . "</station_name>\n";
					$print .= "		<lon>" . $lon . "</lon>\n";
					$print .= "		<lat>" . $lat . "</lat>\n";
					$print .= "	</station>\n";

					If($ii > 0){$json .= ",";}
					$json .= "{\"station_cd\":" . $station_cd . ",\"station_g_cd\":" . $station_g_cd;
					$json .= ",\"station_name\":\"" . $station_name . "\",\"lon\":" . $lon . ",\"lat\":" . $lat . "}";

					$ii++;
				}
			}

			$print .=  "</ekidata>\n";

			$json .= "]}\n";
			$json .= "if(typeof(xml.onload)=='function') xml.onload(xml.data);\n";

			//ファイル作成
			$make_file = $dir_line . $line_cd . ".xml";
			$fp = fopen($make_file,"w");
			fputs($fp,$print);
			fclose($fp);
			chmod ($make_file, 0666);

			//ファイル作成
			$make_file = $dir_line . $line_cd . ".json";
			$fp = fopen($make_file,"w");
			fputs($fp,$json);
			fclose($fp);
			chmod ($make_file, 0666);

			echo $line_cd . " ";
		}
	}

	echo "終わりました<br>";

}ElseIf($api==3){


	//駅一覧
	$sql = "SELECT SQL_CALC_FOUND_ROWS";
	$sql .= " m_station.pref_cd";
	$sql .= ",m_station.line_cd";
	$sql .= ",m_station.station_cd";
	$sql .= ",m_station.station_g_cd";
	$sql .= ",m_station.station_name";
	$sql .= ",m_station.lon";
	$sql .= ",m_station.lat";
	$sql .= ",m_line.line_name";
	$sql .= " FROM m_station";
	$sql .= " LEFT JOIN m_line ON m_line.line_cd = m_station.line_cd";
	$sql .= " WHERE m_station.e_status = 0 AND m_station.station_cd > 1000000";
	$sql .= " ORDER BY m_station.station_cd";
	$stmt = $pdo->prepare($sql);
	$stmt -> execute();
	$csth = $pdo->query("SELECT FOUND_ROWS()");
	$resultNumRows = $csth->fetchColumn();
	if($resultNumRows>0){
		foreach($stmt as $row){
			$pref_cd      = $row['pref_cd'];
			$line_cd      = $row['line_cd'];
			$station_cd   = $row['station_cd'];
			$station_g_cd = $row['station_g_cd'];
			$lon          = $row['lon'];
			$lat          = $row['lat'];
			$station_name = $row['station_name'];
			$line_name    = $row['line_name'];

			$print = "";
			$print .= "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
			$print .= "<ekidata version=\"ekidata.jp station api 1.0\">\n";
			$print .= "	<station>\n";
			$print .= "		<pref_cd>" . $pref_cd . "</pref_cd>\n";
			$print .= "		<line_cd>" . $line_cd . "</line_cd>\n";
			$print .= "		<line_name>" . $line_name . "</line_name>\n";
			$print .= "		<station_cd>" . $station_cd . "</station_cd>\n";
			$print .= "		<station_g_cd>" . $station_g_cd . "</station_g_cd>\n";
			$print .= "		<station_name>" . $station_name . "</station_name>\n";
			$print .= "		<lon>" . $lon . "</lon>\n";
			$print .= "		<lat>" . $lat . "</lat>\n";
			$print .= "	</station>\n";
			$print .=  "</ekidata>\n";


			$json = "";
			$json .= "\n";
			$json .= "if(typeof(xml)=='undefined') xml = {};\n";
			$json .= "xml.data = ";
			$json .= "{\"station\":[";
			$json .= "{";
			$json .= " \"pref_cd\":"        . $pref_cd;
			$json .= ",\"line_cd\":"        . $line_cd;
			$json .= ",\"line_name\":\""    . $line_name . "\"";
			$json .= ",\"station_cd\":"     . $station_cd;
			$json .= ",\"station_g_cd\":"   . $station_g_cd;
			$json .= ",\"station_name\":\"" . $station_name . "\"";
			$json .= ",\"lon\":"            . $lon;
			$json .= ",\"lat\":"            . $lat;
			$json .= "}";
			$json .= "]}\n";
			$json .= "if(typeof(xml.onload)=='function') xml.onload(xml.data);\n";


			//ファイル作成
			$make_file = $dir_station . $station_cd . ".xml";
			$fp = fopen($make_file,"w");
			fputs($fp,$print);
			fclose($fp);
			chmod ($make_file, 0666);

			//ファイル作成
			$make_file = $dir_station . $station_cd . ".json";
			$fp = fopen($make_file,"w");
			fputs($fp,$json);
			fclose($fp);
			chmod ($make_file, 0666);

			echo $station_cd . " ";
		}
	}

	echo "終わりました<br>";

}ElseIf($api==4){

	//グループの駅一覧
	$sql = "SELECT SQL_CALC_FOUND_ROWS";
	$sql .= " m_station.line_cd";
	$sql .= ",m_station.station_cd";
	$sql .= ",m_station.station_g_cd";
	$sql .= ",m_station.station_name";
	$sql .= ",m_station.lon";
	$sql .= ",m_station.lat";
	$sql .= ",m_line.line_name";
	$sql .= " FROM m_station";
	$sql .= " LEFT JOIN m_line ON m_line.line_cd = m_station.line_cd";
	$sql .= " WHERE m_station.e_status = 0 AND m_station.station_cd > 1000000";
	$sql .= " ORDER BY m_station.station_cd";
	$stmt = $pdo->prepare($sql);
	$stmt -> execute();
	$csth = $pdo->query("SELECT FOUND_ROWS()");
	$resultNumRows = $csth->fetchColumn();
	if($resultNumRows>0){
		foreach($stmt as $row){

			$line_cd      = $row['line_cd'];
			$station_cd   = $row['station_cd'];
			$station_g_cd = $row['station_g_cd'];
			$lon          = $row['lon'];
			$lat          = $row['lat'];
			$station_name = $row['station_name'];
			$line_name    = $row['line_name'];

			$print = "";
			$print .= "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
			$print .= "<ekidata version=\"ekidata.jp station api 1.0\">\n";
			$print .= "	<station>\n";
			$print .= "		<line_cd>" . $line_cd . "</line_cd>\n";
			$print .= "		<line_name>" . $line_name . "</line_name>\n";
			$print .= "		<station_cd>" . $station_cd . "</station_cd>\n";
			$print .= "		<station_g_cd>" . $station_g_cd . "</station_g_cd>\n";
			$print .= "		<station_name>" . $station_name . "</station_name>\n";
			$print .= "		<lon>" . $lon . "</lon>\n";
			$print .= "		<lat>" . $lat . "</lat>\n";
			$print .= "	</station>\n";

			$json = "";
			$json .= "\n";
			$json .= "if(typeof(xml)=='undefined') xml = {};\n";
			$json .= "xml.data = ";
			$json .= "{\"station_g\":[";


			//グループ駅一覧
			$sql2 = "SELECT SQL_CALC_FOUND_ROWS";
			$sql2 .= " m_station.pref_cd";
			$sql2 .= ",m_station.line_cd";
			$sql2 .= ",m_station.station_cd";
			$sql2 .= ",m_station.station_name";
			$sql2 .= ",m_line.line_name";
			$sql2 .= " FROM m_station";
			$sql2 .= " LEFT JOIN m_line ON m_line.line_cd = m_station.line_cd";
			$sql2 .= " WHERE m_station.e_status = 0 AND m_station.station_cd > 1000000 AND m_station.station_g_cd = " . $station_g_cd;
			$sql2 .= " ORDER BY m_station.e_sort,m_station.station_cd";

			$stmt2 = $pdo->prepare($sql2);
			$stmt2 -> execute();
			$csth2 = $pdo->query("SELECT FOUND_ROWS()");
			$resultNumRows2 = $csth2->fetchColumn();
			if($resultNumRows2>0){
				$ii=0;
				foreach($stmt2 as $row2){

					$pref_cd2      = $row2['pref_cd'];
					$line_cd2      = $row2['line_cd'];
					$station_cd2   = $row2['station_cd'];
					$station_name2 = $row2['station_name'];
					$line_name2    = $row2['line_name'];

					$print .= "	<station_g>\n";
					$print .= "		<pref_cd>" . $pref_cd2 . "</pref_cd>\n";
					$print .= "		<line_cd>" . $line_cd2 . "</line_cd>\n";
					$print .= "		<line_name>" . $line_name2 . "</line_name>\n";
					$print .= "		<station_cd>" . $station_cd2 . "</station_cd>\n";
					$print .= "		<station_name>" . $station_name2 . "</station_name>\n";
					$print .= "	</station_g>\n";

					If($ii > 0){$json .= ",";}
					$json .= "{\"pref_cd\":" . $pref_cd2 . ",\"line_cd\":" . $line_cd2 . ",\"line_name\":\"" . $line_name2 . "\"";
					$json .= ",\"station_cd\":" . $station_cd2 . ",\"station_name\":\"" . $station_name2 . "\"}";

					$ii++;
				}
			}

			$print .=  "</ekidata>\n";
			$json .= "]}\n";
			$json .= "if(typeof(xml.onload)=='function') xml.onload(xml.data);\n";

			//ファイル作成
			$make_file = $dir_group . $station_cd . ".xml";
			$fp = fopen($make_file,"w");
			fputs($fp,$print);
			fclose($fp);
			chmod ($make_file, 0666);

			//ファイル作成
			$make_file = $dir_group . $station_cd . ".json";
			$fp = fopen($make_file,"w");
			fputs($fp,$json);
			fclose($fp);
			chmod ($make_file, 0666);

			echo $station_cd . " ";
		}
	}

	echo "終わりました<br>";

}ElseIf($api==5){

	//隣り合う駅一覧
	$sql = "SELECT SQL_CALC_FOUND_ROWS";
	$sql .= " line_cd";
	$sql .= " FROM m_line";
	$sql .= " WHERE e_status = 0 AND line_type <> 1";
	$sql .= " ORDER BY e_status,line_cd";
	$stmt = $pdo->prepare($sql);
	$stmt -> execute();
	$csth = $pdo->query("SELECT FOUND_ROWS()");
	$resultNumRows = $csth->fetchColumn();
	if($resultNumRows>0){
		foreach($stmt as $row){

			$line_cd = $row['line_cd'];

			$print = "";
			$print .= "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
			$print .= "<ekidata version=\"ekidata.jp station_join api 1.0\">\n";

			$json = "";
			$json .= "\n";
			$json .= "if(typeof(xml)=='undefined') xml = {};\n";
			$json .= "xml.data = ";
			$json .= "{\"station_join\":[";

			//ここからデータ取得
			$sql2 = "SELECT SQL_CALC_FOUND_ROWS";
			$sql2 .= " m_station_join.station_cd1";
			$sql2 .= ",m_station_join.station_cd2";
			$sql2 .= ",s1.station_name AS s_name1";
			$sql2 .= ",s1.lat AS s_lat1";
			$sql2 .= ",s1.lon AS s_lon1";
			$sql2 .= ",s2.station_name AS s_name2";
			$sql2 .= ",s2.lat AS s_lat2";
			$sql2 .= ",s2.lon AS s_lon2";
			$sql2 .= " FROM m_station_join";
			$sql2 .= " LEFT JOIN m_station AS s1 ON m_station_join.station_cd1 = s1.station_cd";
			$sql2 .= " LEFT JOIN m_station AS s2 ON m_station_join.station_cd2 = s2.station_cd";
			$sql2 .= " WHERE m_station_join.line_cd = " . $line_cd;

			$stmt2 = $pdo->prepare($sql2);
			$stmt2 -> execute();
			$csth2 = $pdo->query("SELECT FOUND_ROWS()");
			$resultNumRows2 = $csth2->fetchColumn();
			$ii=0;
			if($resultNumRows2>0){
				foreach($stmt2 as $row2){

					$station_cd1   = $row2['station_cd1'];
					$station_cd2   = $row2['station_cd2'];
					$station_name1 = $row2['s_name1'];
					$lat1          = $row2['s_lat1'];
					$lon1          = $row2['s_lon1'];
					$station_name2 = $row2['s_name2'];
					$lat2          = $row2['s_lat2'];
					$lon2          = $row2['s_lon2'];

					$print .= "	<station_join>\n";
					$print .= "		<station_cd1>" . $station_cd1 . "</station_cd1>\n";
					$print .= "		<station_cd2>" . $station_cd2 . "</station_cd2>\n";
					$print .= "		<station_name1>" . $station_name1 . "</station_name1>\n";
					$print .= "		<station_name2>" . $station_name2 . "</station_name2>\n";
					$print .= "		<lat1>" . $lat1 . "</lat1>\n";
					$print .= "		<lon1>" . $lon1 . "</lon1>\n";
					$print .= "		<lat2>" . $lat2 . "</lat2>\n";
					$print .= "		<lon2>" . $lon2 . "</lon2>\n";
					$print .= "	</station_join>\n";

					If($ii > 0){$json .= ",";}
					$json .= "{";
					$json .=  "\"station_cd1\":"     . $station_cd1;
					$json .= ",\"station_cd2\":"     . $station_cd2;
					$json .= ",\"station_name1\":\"" . $station_name1 . "\"";
					$json .= ",\"station_name2\":\"" . $station_name2 . "\"";
					$json .= ",\"lat1\":"            . $lat1;
					$json .= ",\"lon1\":"            . $lon1;
					$json .= ",\"lat2\":"            . $lat2;
					$json .= ",\"lon2\":"            . $lon2;
					$json .= "}";
					$ii++;
				}
			}

			$print .=  "</ekidata>\n";

			$json .= "]}\n";
			$json .= "if(typeof(xml.onload)=='function') xml.onload(xml.data);\n";

			//ファイル作成
			$make_file = $dir_join . $line_cd . ".xml";
			$fp = fopen($make_file,"w");
			fputs($fp,$print);
			fclose($fp);
			chmod ($make_file, 0666);

			//ファイル作成
			$make_file = $dir_join . $line_cd . ".json";
			$fp = fopen($make_file,"w");
			fputs($fp,$json);
			fclose($fp);
			chmod ($make_file, 0666);

			echo $line_cd . " ";

		}
	}

	echo "終わりました<br>";

}
?>