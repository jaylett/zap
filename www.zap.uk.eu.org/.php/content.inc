<?

function error($msg) {
	echo "<!-- ERROR: read_content: $msg -->\n";
}

function find_content_languages($filename) {
	$result     = array();
	$dirname    = substr($filename, 0, strrpos($filename, '/'));
	$fileprefix = substr($filename, strrpos($filename, '/') + 1);
	$regex      = "/^${fileprefix}-([^\\.]+)\\.info\$/";

	$fd = @opendir($dirname);

	if ($fd == 0)
		return $result;

	while (($file = readdir($fd)) !== false) {
		$matches = array();

		if (preg_match($regex, $file, $matches))
			array_push($result, $matches[1]);
	}

	closedir($fd);

	return $result;
}

function read_content($filename, $language = '', $delimiter = "---") {

	if (empty($language))
		$language = ofx_get_language();

	$languages = explode('-', $language);

	for ($i = sizeof($languages); $i; --$i) {
		$fn = $filename;

		for ($j = 0; $j < $i; $j++)
			$fn .= '-' . $languages[$j];

		$fp = @fopen($fn . ".info", "r");

		if ($fp != 0)
			break;
	}

	if ($fp == 0)
		$fp = @fopen($filename . "-en.info", 'r');

	if ($fp == 0) {
		error("Couldn't open file $filename");
		return 0;
	}

	$result = array();

	$currentline  = "";
	$currentarray = array();
	$currentid    = "";
	$lineno       = 0;

	while (!feof($fp)) {
		$line    = fgets($fp, 4096);
		$lineno += 1;

		$trimmed = trim($line);

		if ($trimmed == "") {
			continue;
		}

		if (substr($trimmed, 0, 1) == "#") {
			continue;
		}

		if (trim(substr($line, 0, 1)) == "") {
			$currentarray[$currentid] .= " " . trim($line);
			continue;
		}

		if ($trimmed == $delimiter) {
			array_push($result, $currentarray);
			$currentarray = array();
			continue;
		}

		$pos = strpos($trimmed, ":");

		if ($pos === false) {
			error("Parse error in file $filename (line $lineno): No colon found and no whitespace at start");
			fclose($fp);
			return 0;
		}

		$currentid = substr($trimmed, 0, $pos);

		$currentarray[$currentid] = trim(substr($line, $pos + 1));
	}

	array_push($result, $currentarray);

	return $result;
}

?>