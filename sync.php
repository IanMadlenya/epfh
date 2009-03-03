<?php
	include("config.php");

	if($_GET["do"] == "install")
		echo orph_install($db_file);
	
	if($_GET["do"] == "sync") {
		echo orph_clean_db($db_file)."\n";
		echo orph_install($db_file)."\n";
		echo orph_sync_db($db_file, $update_file)."\n";
	}

	//if($_GET["do"] == "do")
		//echo orph_do($db_file, $update_file);
       
	// Sync
	function orph_sync_db($db_file, $csv_file) {
		$csv = new parseCSV($csv_file);
		$db = new SQLiteDB($db_file);


		$queries = 1;
		foreach($csv->data as $item) {
			$db->query("
				INSERT OR REPLACE INTO products ( id, name, code, desc_short, desc_long, price, currency, taxes, eid )
				VALUES ( 
					'".$queries."',
					'".escape($item['Denumire'])."',
					'".escape($item['Cod'])."',
					'".escape($item['Descriere scurta'])."',
					'".escape($item['Descriere lunga'])."',
					'".escape($item['Pret'])."',
					'".escape($item['Moneda'])."',
					'".escape($item['ID Taxe'])."',
					'".escape($item['ID ePayment'])."' );
				");
			$queries++;
		}

		return "Sync finished: $queries done.";
	}

	// Escaping
	function escape($string) {
		if ( 1 == get_magic_qotes_gpc )
			$string = stripslashes($string);
		else
			$string = addslashes($string);

		$string = str_replace("'", '&#039;', $string);
		$string = str_replace('"', '&quot;', $string);

		return sqlite_escape_string(utf8_encode($string));
	}


	// Create database tables
	function orph_install($db_file) {
		$db = new SQLiteDB($db_file);

		$db->query("
			CREATE TABLE products (
			id INT,
			name TEXT,
			code TEXT,
			desc_short TEXT,
			desc_long TEXT,
			price NUMERIC,
			currency NUMERIC,
			taxes INTEGER,
			EID NUMERIC );
		");

		return "Tables created!";

	}
	
	function orph_clean_db($db_file) {
		$db = new SQLiteDB($db_file);

		$db->query("
			DROP TABLE products;
		");

		return "Tables destroyed!";

	}

?>
