<?php

/**
 * {@link CMongoContainer.php Base} object test suite.
 *
 * This file contains routines to test and demonstrate the behaviour of the
 * base object {@link CMongoContainer class}.
 *
 *	@package	Test
 *	@subpackage	Framework
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 04/09/2012
 */

/*=======================================================================================
 *																						*
 *								test_CMongoContainer.php								*
 *																						*
 *======================================================================================*/

//
// Global includes.
//
require_once( '/Library/WebServer/Library/PHPWrapper/includes.inc.php' );

//
// Class includes.
//
use \MyWrapper\Persistence\CMongoContainer;


/*=======================================================================================
 *	RUNTIME SETTINGS																	*
 *======================================================================================*/
 
//
// Debug switches.
//
define( 'kDEBUG_PARENT', FALSE );


/*=======================================================================================
 *	TEST DEFAULT EXCEPTIONS																*
 *======================================================================================*/
 
//
// Test class.
//
try
{
	//
	// Test parent class.
	//
	if( kDEBUG_PARENT )
	{
		//
		// Instantiate class.
		//
		echo( '<h4>$test = new CMongoContainer();</h4>' );
		$test = new CMongoContainer();
		echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
		echo( '<hr />' );
		
		//
		// Set offset.
		//
		echo( '<h4>$test[ \'A\' ] = \'a\';</h4>' );
		$test[ 'A' ] = 'a';
		echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
		echo( '<h4>$test[ \'B\' ] = 2;</h4>' );
		$test[ 'B' ] = 2;
		echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
		echo( '<h4>$test[ \'C\' ] = array( 1, 2, 3 );</h4>' );
		$test[ 'C' ] = array( 1, 2, 3 );
		echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
		echo( '<hr />' );
		
		//
		// Set NULL offset.
		//
		echo( '<h4>$test[ \'A\' ] = NULL;</h4>' );
		$test[ 'A' ] = NULL;
		echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
		echo( '<hr />' );
		
		//
		// Get non-existing offset.
		//
		echo( '<h4>$x = $test[ \'missing\' ];</h4>' );
		$x = $test[ 'missing' ];
		if( $x !== NULL )
			print_r( $x );
		else
			echo( "<tt>NULL</tt>" );
		echo( '<hr />' );
		
		//
		// Test array_keys.
		//
		echo( '<h4>$test->array_keys();</h4>' );
		echo( '<pre>' ); print_r( $test->array_keys() ); echo( '</pre>' );
		echo( '<hr />' );
		
		//
		// Test array_values.
		//
		echo( '<h4>$test->array_values();</h4>' );
		echo( '<pre>' ); print_r( $test->array_values() ); echo( '</pre>' );
		echo( '<hr />' );
		
		//
		// Test array offsets.
		//
		echo( '<h4>$test[ \'C\' ][ 1 ];</h4>' );
		echo( '<pre>' ); print_r( $test[ 'C' ][ 1 ] ); echo( '</pre>' );
		echo( '<hr />' );
	}
	
	//
	// Create collection.
	//
	echo( '<hr />' );
	echo( '<h4>$mongo = New Mongo();</h4>' );
	$mongo = New Mongo();
	echo( '<h4>$db = $mongo->selectDB( "TEST" );</h4>' );
	$db = $mongo->selectDB( "TEST" );
	$db->drop();
	echo( '<h4>$collection = $db->selectCollection( "CMongoContainer" );</h4>' );
	$collection = $db->selectCollection( "CMongoContainer" );
	echo( '<hr />' );
	
	//
	// Instantiate with crap.
	//
	try
	{
		echo( '<h4>$test = new CMongoContainer( \'should fail\' );</h4>' );
		$test = new CMongoContainer( 'should fail' );
		echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
		echo( '<hr />' );
	}
	catch( Exception $error )
	{
		echo( '<h4>Expected exception</h4>' );
		echo( '<pre>'.(string) $error.'</pre>' );
		echo( '<hr>' );
	}
	
	//
	// Instantiate with collection.
	//
	echo( '<h4>$test = new CMongoContainer( $collection );</h4>' );
	$test = new CMongoContainer( $collection );
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Get container name.
	//
	echo( '<h4>$name = (string) $test; // is the collection name</h4>' );
	$name = (string) $test;
	echo( $name );
	echo( '<hr />' );
	
	//
	// Remove container.
	//
	echo( '<h4>$test->Container( FALSE );</h4>' );
	$test->Container( FALSE );
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Restore collection.
	//
	echo( '<hr />' );
	echo( '<h4>$test = new CMongoContainer( $collection );</h4>' );
	$test = new CMongoContainer( $collection );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Insert object without ID.
	//
	echo( '<h4>$object = array( "A" => 1, "B" => "due", "C" => array( 1, 2, 3 ) );</h4>' );
	$object = array( "A" => 1, "B" => "due", "C" => array( 1, 2, 3 ) );
	echo( '<pre>' ); print_r( $object ); echo( '</pre>' );
	echo( '<h4>$status = $test->ManageObject( $object, NULL, kFLAG_PERSIST_INSERT );</h4>' );
	$status = $test->ManageObject( $object, NULL, kFLAG_PERSIST_INSERT );
	echo( 'Object<pre>' ); print_r( $object ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Insert object with ID.
	//
	echo( '<h4>$object = new ArrayObject( array( kOFFSET_NID => 1, "DATA" => "dati" ) );</h4>' );
	$object = new ArrayObject( array( kOFFSET_NID => 1, "DATA" => "dati" ) );
	echo( '<pre>' ); print_r( $object ); echo( '</pre>' );
	echo( '<h4>$status = $test->ManageObject( $object, NULL, kFLAG_PERSIST_INSERT );</h4>' );
	$status = $test->ManageObject( $object, NULL, kFLAG_PERSIST_INSERT );
	echo( 'Object<pre>' ); print_r( $object ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Insert object with different ID.
	//
	echo( '<h4>$status = $test->ManageObject( $object, 2, kFLAG_PERSIST_INSERT );</h4>' );
	$status = $test->ManageObject( $object, 2, kFLAG_PERSIST_INSERT );
	echo( 'Object<pre>' ); print_r( $object ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Insert object with same ID.
	//
	try
	{
		echo( '<h4>$status = $test->ManageObject( $object, 1, kFLAG_PERSIST_INSERT );</h4>' );
		$status = $test->ManageObject( $object, 1, kFLAG_PERSIST_INSERT );
		echo( 'Object<pre>' ); print_r( $object ); echo( '</pre>' );
		echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
		echo( '<hr />' );
	}
	catch( Exception $error )
	{
		echo( '<h4>Expected exception</h4>' );
		echo( '<pre>'.(string) $error.'</pre>' );
		echo( '<hr>' );
	}
	echo( '<hr>' );
	
	//
	// Update object.
	//
	echo( '<h4>$object[ "NEW" ] = "New field";</h4>' );
	$object[ "NEW" ] = "New field";
	echo( 'Object<pre>' ); print_r( $object ); echo( '</pre>' );
	echo( '<h4>$status = $test->ManageObject( $object, NULL, kFLAG_PERSIST_UPDATE );</h4>' );
	$status = $test->ManageObject( $object, NULL, kFLAG_PERSIST_UPDATE );
	echo( 'Object<pre>' ); print_r( $object ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Update non-existing object.
	//
	try
	{
		echo( '<h4>$status = $test->ManageObject( $object, 9, kFLAG_PERSIST_UPDATE );</h4>' );
		$status = $test->ManageObject( $object, 9, kFLAG_PERSIST_UPDATE );
		echo( 'Object<pre>' ); print_r( $object ); echo( '</pre>' );
		echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
		echo( '<hr />' );
		echo( '<hr />' );
	}
	catch( Exception $error )
	{
		echo( '<h4>Expected exception</h4>' );
		echo( '<pre>'.(string) $error.'</pre>' );
		echo( '<hr>' );
	}
	echo( '<hr>' );
	
	//
	// Replace new object.
	//
	echo( '<h4>$object->offsetUnset( kOFFSET_NID );</h4>' );
	$object->offsetUnset( kOFFSET_NID );
	echo( 'Object<pre>' ); print_r( $object ); echo( '</pre>' );
	echo( '<h4>$status = $test->ManageObject( $object, NULL, kFLAG_PERSIST_REPLACE );</h4>' );
	$status = $test->ManageObject( $object, NULL, kFLAG_PERSIST_REPLACE );
	echo( 'Object<pre>' ); print_r( $object ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Replace existing object.
	//
	echo( '<h4>$status = $test->ManageObject( $object, 2, kFLAG_PERSIST_REPLACE );</h4>' );
	$status = $test->ManageObject( $object, 2, kFLAG_PERSIST_REPLACE );
	echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Modify existing object.
	//
	echo( '<h4>$ident = $object[ kOFFSET_NID ]; $mod = array( \'$set\' => array( "DATA" => "NEW" ) );</h4>' );
	$ident = $object[ kOFFSET_NID ]; $mod = array( '$set' => array( "DATA" => "NEW" ) );
	echo( '<h4>$status = $test->ManageObject( $mod, $ident, kFLAG_PERSIST_MODIFY );</h4>' );
	$status = $test->ManageObject( $mod, $ident, kFLAG_PERSIST_MODIFY );
	echo( 'Object<pre>' ); print_r( $mod ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Modify non-existing object.
	//
	echo( '<h4>$ident = 99; $mod = array( \'$set\' => array( "DATA" => "OLD" ) );</h4>' );
	$ident = 99; $mod = array( '$set' => array( "DATA" => "OLD" ) );
	echo( '<h4>$status = $test->ManageObject( $mod, $ident, kFLAG_PERSIST_MODIFY );</h4>' );
	$status = $test->ManageObject( $mod, $ident, kFLAG_PERSIST_MODIFY );
	echo( 'Object<pre>' ); print_r( $mod ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Delete existing object.
	//
	echo( '<h4>$status = $test->ManageObject( $object, NULL, kFLAG_PERSIST_DELETE );</h4>' );
	$status = $test->ManageObject( $object, NULL, kFLAG_PERSIST_DELETE );
	echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Delete non-existing object.
	//
	$scrap = 'scrap';
	echo( '<h4>$status = $test->ManageObject( $scrap, 99, kFLAG_PERSIST_DELETE );</h4>' );
	$status = $test->ManageObject( $scrap, 99, kFLAG_PERSIST_DELETE );
	echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Load existing object.
	//
	echo( '<h4>$status = $test->ManageObject( $object, 1 );</h4>' );
	$status = $test->ManageObject( $object, 1 );
	echo( 'Object<pre>' ); print_r( $object ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Load non-existing object.
	//
	echo( '<h4>$status = $test->ManageObject( $object, 2 );</h4>' );
	$status = $test->ManageObject( $object, 2 );
	echo( 'Object<pre>' ); print_r( $object ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
	echo( '<hr>' );
	echo( '<hr />' );
}

//
// Catch exceptions.
//
catch( Exception $error )
{
	echo( '<h3><font color="red">Unexpected exception</font></h3>' );
	echo( '<pre>'.(string) $error.'</pre>' );
	echo( '<hr>' );
}

echo( "\nDone!\n" );

?>
