#!/usr/bin/php -q
<?php

// Android translation helper tool
// cross checks two strings.xml files to find diffs
//
// usage: ./strings-check.php values/base.xml values-lang/translated.xml
//
// Written by Marcin Orlowski <mail (@) marcinorlowski (.) com>
//
// 2010.07.03: Initial release

class Convert {

	public function XmlToArray( $n )
	{
		$xml_array = array();
		$occurance = array();

		foreach($n->childNodes as $nc) {
			if (isset($occurance[$nc->nodeName]))
				$occurance[$nc->nodeName]++;
			else
				$occurance[$nc->nodeName] = 1;
		}

		foreach($n->childNodes as $nc) {
			if( $nc->hasChildNodes() ) {
				$childNodes = $nc->childNodes;
				$children = $childNodes->length;

				if ($children>1) {
					$xml_array[$nc->nodeName][] = $this->XmlToArray($nc);

					$counter = count($xml_array[$nc->nodeName])-1;

					$atrybuty = $nc->attributes;
					for ($k = 0; $k < $atrybuty->length; $k++) {
						$xml_array[$nc->nodeName][$counter]['attribute'][$atrybuty->item($k)->nodeName] = $atrybuty->item($k)->nodeValue;
					}
					//$counter++;
				} else {
					$xml_array[$nc->nodeName][]['cdata'] = $nc->nodeValue;
					$counter = count($xml_array[$nc->nodeName])-1;
					$atrybuty = $nc->attributes;
					for ($k = 0; $k < $atrybuty->length; $k++) {
						$xml_array[$nc->nodeName][$counter]['attribute'][$atrybuty->item($k)->nodeName] = $atrybuty->item($k)->nodeValue;
					}
				}
			} els {
			{
				if( $nc->hasAttributes() ) {
					$atrybuty = $nc->attributes;
					$counter = 0;
					for ($k = 0; $k < $atrybuty->length; $k++) {
						$xml_array[$nc->nodeName][$counter]['attribute'][$atrybuty->item($k)->nodeName]= $atrybuty->item($k)->nodeValue;
					}
				}
			}

		 }

		 return $xml_array;
	}

	public function GetLabels( $fileName )
	{
		$xml = new DOMDocument('1.0','UTF-8');
		$xml->load( $fileName );

		$data = $this->XmlToArray( $xml );

		$result = array();

		foreach( $data['resources'][0]['string'] AS $entry ) {
			$tmp = sprintf("%s", trim($entry['attribute']['name']));
			$result[$tmp] = $tmp;
		}

		return $result;

	}

// class convert
}


	if( $_SERVER['argc'] != 3 ) {
		printf("Usage: %s strings-EN.xml string-LANG.xml\n", $_SERVER['argv'][0] );
		die( "*** Aborted\n");
	}

	$fileEn = $_SERVER['argv'][1];
	$fileLang = $_SERVER['argv'][2];

	if( file_exists( $fileEn ) == FALSE ) {
		die( sprintf("*** Missing file '%s'\n", $fileEn ));
	}

	if( file_exists( $fileLang ) == FALSE ) {
		die( sprintf("*** Missing file '%s'\n", $fileLang ) );
	}


	$convert = new Convert();
	$dataLang = $convert->GetLabels( $fileLang );
	$dataEn = $convert->GetLabels( $fileEn );

	$cntLang = $cntEn = 0;

	echo "\n";

	// comparing
	printf("Missing in <LANG> (You need to add these to your file)\n");
    printf("File: %s\n", $fileLang);
	printf("------------------------------------------------------\n");
	foreach( $dataEn AS $string ) {
		if( isset( $dataLang[$string] ) == false ) {
			printf("%s\n", $string);
			$cntLang++;
		}
	}

	echo "\n";
	printf("Missing in EN (you probably shall remove it from your <LANG> file)\n");
	printf("File: %s\n", $fileEn);
	printf("------------------------------------------------------------------\n");
	foreach( $dataLang AS $string ) {
		if( isset( $dataEn[$string] ) == false ) {
			printf("%s\n", $string);
			$cntEn++;
		}
	}

	echo "\n\nSummary\n----------------\n";

	printf("BASE file: '%s'\n", $fileEn);
	printf("LANG file: '%s'\n", $fileLang);

	echo "\n";

	if( ($cntLang == 0) && ($cntEn==0) ) {
		echo "OK. Files seem to be up to date.\n";
	} else {
		if( $cntLang > 0 ) {
			printf( "%4d missing strings in your LANG file.\n", $cntLang );
		}

		if( $cntEn > 0 ) {
			printf("%4d obsolete strings in your LANG file.\n", $cntEn );
		}
	}

	echo "\n";
