<?php
	
	//
	// Default includes.
	//
	require_once( '/Library/WebServer/Library/PHPWrapper/includes.inc.php' );
	
	//
	// Parsing functions.
	//
	require_once( kPATH_MYWRAPPER_LIBRARY_FUNCTION."/parsing.php" );
	
	//
	// Parse PO file.
	//
	$matches = PO2Array( '/Library/WebServer/Library/PHPWrapper/scrapbook/iso_3166.po' );

echo( '<pre>' );
print_r( $matches );
exit( '</pre>' );

?>
