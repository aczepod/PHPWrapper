<?php
	
/*
	//
	// Test namespaces.
	//
	require_once( '/Library/WebServer/Library/PHPWrapper/includes.inc.php' );
	
	//
	// Revive namespace.
	//
	use MyWrapper\Framework\CDocument;
	
	//
	// Instantiate class.
	//
	$x = new CDocument();
	
	echo( '<pre>' );
	print_r( $x );
	echo( '</pre>' );
	
	//
	// Encode something.
	//
	$json = CDocument::JsonEncode( array( 'A', 'B', 'C' ) );
	
	//
	// Decode it.
	//
	$php = CDocument::JsonDecode( $json );
	
	//
	// Exception.
	//
	$test = $json.',,,,';
	$php = CDocument::JsonDecode( $test );
*/
	//
	// Open a Mongo connection.
	//
	$mongo = New Mongo();
	$db = $mongo->selectDB( "TEST" );
	$db->drop();
	$collection = $db->selectCollection( 'test' );
	$options = array( 'safe' => TRUE );
	
	//
	// Try committing an array.
	//
	$data = array( 'A' => 'a', 'B' => 2, 'C' => array( 1, 2, 3 ), 4 => 5 );
	$status = $collection->save( $data, $options );
	echo( '<h4>Status:</h4>' );
	echo( '<pre>' ); print_r( $status ); echo( '</pre>' );
	echo( '<h4>Data:</h4>' );
	echo( '<pre>' ); print_r( $data ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Try committing an object.
	//
	$data = new ArrayObject( array( 'A' => 'a', 'B' => 2, 'C' => array( 1, 2, 3 ), 4 => 5 ) );
	$status = $collection->save( $data, $options );
	echo( '<h4>Status:</h4>' );
	echo( '<pre>' ); print_r( $status ); echo( '</pre>' );
	echo( '<h4>Data:</h4>' );
	echo( '<pre>' ); print_r( $data ); echo( '</pre>' );
	echo( '<hr />' );
	
?>
