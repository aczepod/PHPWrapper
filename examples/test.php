<?php
	
	//
	// Test namespaces.
	//
	require_once( '/Library/WebServer/Library/PHPWrapper/includes.inc.php' );
	
/*
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

	//
	// Open a Mongo connection.
	//
	$mongo = New Mongo();
	$db = $mongo->selectDB( "TEST" );
	$db->drop();
	$collection = $db->selectCollection( 'test' );
	$options = array( 'safe' => TRUE );
	
	//
	// Create three objects.
	//
	$a = new ArrayObject( array( 'name' => 'A' ) );
	$b = new ArrayObject( array( 'name' => 'B' ) );
	$c = new ArrayObject( array( 'name' => 'C' ) );
	
	//
	// Add three objects.
	//
	$collection->save( $a, $options );
	$collection->save( $b, $options );
	$collection->save( $c, $options );
	
	//
	// Create array.
	//
	$x = array( $a[ '_id' ], $b[ '_id' ], $c[ '_id' ] );
	echo( '<pre>' ); print_r( $x ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Test array.
	//
	echo( '<i>$ok = in_array( $b[ "_id" ], $x );</i><br />' );
	$ok = in_array( $b[ "_id" ], $x );
	echo( '<pre>' ); print_r( ($ok) ? 'Y' : 'N' ); echo( '</pre>' );
	echo( '<hr />' );
	
	echo( '<i>$ok = in_array( ((string) $b[ "_id" ]), $x );</i><br />' );
	$ok = in_array( ((string) $b[ "_id" ]), $x );
	echo( '<pre>' ); print_r( ($ok) ? 'Y' : 'N' ); echo( '</pre>' );
	echo( '<hr />' );
	
	echo( '<i>$ok = in_array( "pippo", $x );</i><br />' );
	$ok = in_array( "pippo", $x );
	echo( '<pre>' ); print_r( ($ok) ? 'Y' : 'N' ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Test objects.
	//
	echo( '<i>$ok = ( $b[ "_id" ] == $b[ "_id" ] );</i><br />' );
	$ok = ( $b[ "_id" ] == $b[ "_id" ] );
	echo( '<pre>' ); print_r( ($ok) ? 'Y' : 'N' ); echo( '</pre>' );
	echo( '<hr />' );
	
	echo( '<i>$ok = ( $b[ "_id" ] == (string) $b[ "_id" ] );</i><br />' );
	$ok = ( $b[ "_id" ] == (string) $b[ "_id" ] );
	echo( '<pre>' ); print_r( ($ok) ? 'Y' : 'N' ); echo( '</pre>' );
	echo( '<hr />' );
	
	echo( '<i>$ok = ( $b[ "_id" ] == (string) $a[ "_id" ] );</i><br />' );
	$ok = ( $b[ "_id" ] == (string) $a[ "_id" ] );
	echo( '<pre>' ); print_r( ($ok) ? 'Y' : 'N' ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Test hashes.
	//
	echo( '<i>$ok = ( md5( $b[ "_id" ] ) == md5( $b[ "_id" ] ) );</i><br />' );
	$ok = ( md5( $b[ "_id" ] ) == md5( $b[ "_id" ] ) );
	echo( '<pre>' ); print_r( ($ok) ? 'Y' : 'N' ); echo( '</pre>' );
	echo( '<hr />' );
	
	echo( '<i>$ok = ( md5( $b[ "_id" ] ) == (string) $b[ "_id" ] );</i><br />' );
	$ok = ( md5( $b[ "_id" ] ) == (string) $b[ "_id" ] );
	echo( '<pre>' ); print_r( ($ok) ? 'Y' : 'N' ); echo( '</pre>' );
	echo( '<hr />' );
	
	echo( '<i>$ok = ( md5( $b[ "_id" ] ) == md5( $a[ "_id" ] ) );</i><br />' );
	$ok = ( $b[ "_id" ] == (string) $a[ "_id" ] );
	echo( '<pre>' ); print_r( ($ok) ? 'Y' : 'N' ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );
*/
	
	require_once( kPATH_MYWRAPPER_LIBRARY_FUNCTION."/accessors.php" );
	
	//
	// Test accessors.
	//
	$object = array( 'ID' => 'PIPPO' );
	echo( '<pre>' ); print_r( $object ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Add to terms.
	//
	echo( '<i>$ok = ManageObjectSetOffset( $object, "terms", 1, TRUE, TRUE );</i><br />' );
	$ok = ManageObjectSetOffset( $object, "terms", 1, TRUE, TRUE );
	echo( 'Object<pre>' ); print_r( $object ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $ok ); echo( '</pre>' );
	echo( '<hr />' );
	
	echo( '<i>$ok = ManageObjectSetOffset( $object, "terms", "due", TRUE, TRUE );</i><br />' );
	$ok = ManageObjectSetOffset( $object, "terms", "due", TRUE, TRUE );
	echo( 'Object<pre>' ); print_r( $object ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $ok ); echo( '</pre>' );
	echo( '<hr />' );
	
	echo( '<i>$ok = ManageObjectSetOffset( $object, "terms", "3", TRUE, TRUE );</i><br />' );
	$ok = ManageObjectSetOffset( $object, "terms", "3", TRUE, TRUE );
	echo( 'Object<pre>' ); print_r( $object ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $ok ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Add duplicate.
	//
	echo( '<i>$ok = ManageObjectSetOffset( $object, "terms", 1, TRUE, TRUE );</i><br />' );
	$ok = ManageObjectSetOffset( $object, "terms", 1, TRUE, TRUE );
	echo( 'Object<pre>' ); print_r( $object ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $ok ); echo( '</pre>' );
	echo( '<hr />' );
	
	echo( '<i>$ok = ManageObjectSetOffset( $object, "terms", "1", TRUE, TRUE );</i><br />' );
	$ok = ManageObjectSetOffset( $object, "terms", "1", TRUE, TRUE );
	echo( 'Object<pre>' ); print_r( $object ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $ok ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Delete.
	//
	echo( '<i>$ok = ManageObjectSetOffset( $object, "terms", 1, FALSE, TRUE );</i><br />' );
	$ok = ManageObjectSetOffset( $object, "terms", 1, FALSE, TRUE );
	echo( 'Object<pre>' ); print_r( $object ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $ok ); echo( '</pre>' );
	echo( '<hr />' );
	
	echo( '<i>$ok = ManageObjectSetOffset( $object, "terms", "due", FALSE, TRUE );</i><br />' );
	$ok = ManageObjectSetOffset( $object, "terms", "due", FALSE, TRUE );
	echo( 'Object<pre>' ); print_r( $object ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $ok ); echo( '</pre>' );
	echo( '<hr />' );
	
	echo( '<i>$ok = ManageObjectSetOffset( $object, "terms", 3, FALSE, TRUE );</i><br />' );
	$ok = ManageObjectSetOffset( $object, "terms", 3, FALSE, TRUE );
	echo( 'Object<pre>' ); print_r( $object ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $ok ); echo( '</pre>' );
	echo( '<hr />' );
	
?>
