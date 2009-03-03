<?php
	include("config.php");

	$db = new SQLiteDB($db_file);

	$results = $db->query("
		SELECT * FROM products
		");

	$products = "";

	while(sqlite_has_more($results)) {
		$result = $db->fetch_array($results, DB_ASSOC);
		$products .= "<li id=\"prd_".$result['EID']."\">"."\n";
		$products .= "\t"."<div class=\"full_price\">"."\n";
		$products .= "\t\t"."<span class=\"code\">".$result['code']."</span> &mdash;"."\n";
		$products .= "\t\t"."<span class=\"price\">".$result['price']."</span>"."\n";
		$products .= "\t\t"."<span class=\"curr\">".$result['currency']."</span>"."\n";
		$products .= "\t\t"."<form method=\"get\" action=\"".$buy_url."\">"."\n";
		$products .= "\t\t\t"."<input type=\"hidden\" name=\"PRODS\" value=\"".$result['EID']."\" />"."\n";
		$products .= "\t\t\t"."<input type=\"hidden\" name=\"QTY\" value=\"1\" />"."\n";
		$products .= "\t\t\t"."<input type=\"submit\" class=\"button\" value=\"Buy now!\" />"."\n";
		$products .= "\t\t"."</form>"."\n";
		$products .= "\t"."</div>"."\n";
		$products .= "\t"."<h3 class=\"name\">".$result['name']."</h3>"."\n";
		$products .= "\t"."<p class=\"desc_short\">".htmlspecialchars($result['desc_short'])."... </p>"."\n";
		$products .= "\t"."<p class=\"desc_long\">".htmlspecialchars($result['desc_long'])."</p>"."\n";
		$products .= "\t"."<a href=\"#more\" class=\"more\">Read more...</a>"."\n";
		$products .= "</li>"."\n\n";
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<title><?php echo $project_name; ?></title>
	<meta http-equiv="content-type" content="text/html;charset=utf-8" />
	<style type="text/css">
		body { color: #4a4a4a; font-family: "Georgia", Serif; }
		h1, h2, h3 { font-weight: normal; letter-spacing: -1px; color:#5D7D80; }
		a:link { color: #5D7D80; }
		a:visited { color: #666; }
		#content { width: 700px; margin: 50px auto; }
		#header { border-bottom: 1px solid #5D7D80; }
		#main { padding: 10px; }
		#main ul { list-style-type: none; padding-left: 0; }
		#main ul li { margin: 5px 0; }
		#main ul li p { margin: 0 5px; }
		#main ul li .more { margin: 0 5px; }
		#main ul li .full_price { float: right; margin: 5px; color: #cc0000; text-align: right;}
		#main ul li .button { margin: 0; display: block; float: right;}
		#main ul li .desc_long { display: none;}
		#footer { border-top: 1px solid #5D7D80; margin-bottom: 20px; text-align: right; font-size: 80%; clear: both;}
		#footer p { margin: 5px; }
    	</style>
</head>
<body>
	<div id="content">
		<div id="header">
			<h1><?php echo $project_name; ?></h1>
		</div>
		<div id="main">
			<ul id="products">
<?php echo($products); ?>
			</ul>
		</div>
		<div id="footer">
			<p>
			<?php echo "&copy;".date('Y')." <a href=\"".$project_url."\">".$project_name."</a>"; ?>
			</p>
		</div>
	</div>
</body>
</html>
