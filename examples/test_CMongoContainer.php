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
require_once( 'includes.inc.php' );

//
// Class includes.
//
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CMongoContainer.php" );


/*=======================================================================================
 *	RUNTIME SETTINGS																	*
 *======================================================================================*/
 
//
// Debug switches.
//
define( 'kDEBUG_PARENT', TRUE );


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
		echo( '<h4>Instantiate class</h4>' );
		echo( '<h5>$test = new CMongoContainer();</h5>' );
		$test = new CMongoContainer();
		echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
		echo( '<hr />' );
		
		//
		// Set offsets.
		//
		echo( '<h4>Set offsets</h4>' );
		echo( '<h5>$test[ \'A\' ] = \'a\';</h5>' );
		$test[ 'A' ] = 'a';
		echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
		echo( '<h5>$test[ \'B\' ] = 2;</h5>' );
		$test[ 'B' ] = 2;
		echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
		echo( '<h5>$test[ \'C\' ] = array( 1, 2, 3 );</h5>' );
		$test[ 'C' ] = array( 1, 2, 3 );
		echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
		echo( '<hr />' );
		
		//
		// Set NULL offset.
		//
		echo( '<h4>Set NULL offset</h4>' );
		echo( '<h5>$test[ \'A\' ] = NULL;</h5>' );
		$test[ 'A' ] = NULL;
		echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
		echo( '<hr />' );
		
		//
		// Get non-existing offset.
		//
		echo( '<h4>Get non-existing offset</h4>' );
		echo( '<h5>$x = $test[ \'missing\' ];</h5>' );
		$x = $test[ 'missing' ];
		if( $x !== NULL )
			print_r( $x );
		else
			echo( "<tt>NULL</tt>" );
		echo( '<hr />' );
		
		//
		// Test array_keys.
		//
		echo( '<h4>Test array_keys</h4>' );
		echo( '<h5>$test->array_keys();</h5>' );
		echo( '<pre>' ); print_r( $test->array_keys() ); echo( '</pre>' );
		echo( '<hr />' );
		
		//
		// Test array_values.
		//
		echo( '<h4>Test array_values</h4>' );
		echo( '<h5>$test->array_values();</h5>' );
		echo( '<pre>' ); print_r( $test->array_values() ); echo( '</pre>' );
		echo( '<hr />' );
		
		//
		// Test array offsets.
		//
		echo( '<h4>Test array offsets</h4>' );
		echo( '<h5>$test[ "C" ][ 1 ];</h5>' );
		echo( '<pre>' ); print_r( $test[ "C" ][ 1 ] ); echo( '</pre>' );
		echo( '<hr />' );
		echo( '<hr />' );
	}
	
	//
	// Create container.
	//
	echo( '<h4>Create test container</h4>' );
	echo( '$mongo = New CMongoServer();<br />' );
	$mongo = New CMongoServer();
	echo( '$db = $mongo->Database( "TEST" );<br />' );
	$db = $mongo->Database( "TEST" );
	$db->Connection()->drop();
	echo( '$container = new CMongoContainer( $db, "CMongoContainer" );<br />' );
	$container = new CMongoContainer( $db, "CMongoContainer" );
	echo( '$collection = $container->Connection();<br />' );
	$collection = $container->Connection();
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Instantiate with crap.
	//
	try
	{
		echo( '<h4>Instantiate with crap</h4>' );
		echo( '<h5>$test = new CMongoContainer( \'should fail\' );</h5>' );
		$test = new CMongoContainer( 'should fail' );
		echo( '<h3><font color="red">Should have raised an exception</font></h3>' );
		echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
		echo( '<hr />' );
	}
	catch( Exception $error )
	{
		echo( '<h5>Expected exception</h5>' );
		echo( '<pre>'.(string) $error.'</pre>' );
		echo( '<hr>' );
	}
	
	//
	// Instantiate with collection.
	//
	echo( '<h4>Instantiate with collection</h4>' );
	echo( '<h5>$test = new CMongoContainer( $collection );</h5>' );
	$test = new CMongoContainer( $collection );
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Get container name.
	//
	echo( '<h4>Get container name</h4>' );
	echo( '<h5>$name = (string) $test; // is the collection name</h5>' );
	$name = (string) $test;
	echo( $name );
	echo( '<hr />' );
	
	//
	// Remove container.
	//
	echo( '<h4>Remove container</h4>' );
	echo( '<h5>$test->Connection( FALSE );</h5>' );
	$test->Connection( FALSE );
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Restore container.
	//
	echo( '<h4>Restore collection</h4>' );
	echo( '<h5>$test = new CMongoContainer( $collection );</h5>' );
	$test = new CMongoContainer( $collection );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Insert object without ID.
	//
	echo( '<h4>Insert object without ID</h4>' );
	echo( '<h5>$object = array( "A" => 1, "B" => "due", "C" => array( 1, 2, 3 ) );</h5>' );
	$object = array( "A" => 1, "B" => "due", "C" => array( 1, 2, 3 ) );
	echo( '<pre>' ); print_r( $object ); echo( '</pre>' );
	echo( '<h5>$status = $test->ManageObject( $object, NULL, kFLAG_PERSIST_INSERT );</h5>' );
	$status = $test->ManageObject( $object, NULL, kFLAG_PERSIST_INSERT );
	echo( 'Object<pre>' ); print_r( $object ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Insert object with ID.
	//
	echo( '<h4>Insert object with ID</h4>' );
	echo( '<h5>$object = new ArrayObject( array( kTAG_NID => 1, "DATA" => "dati" ) );</h5>' );
	$object = new ArrayObject( array( kTAG_NID => 1, "DATA" => "dati" ) );
	echo( '<pre>' ); print_r( $object ); echo( '</pre>' );
	echo( '<h5>$status = $test->ManageObject( $object, NULL, kFLAG_PERSIST_INSERT );</h5>' );
	$status = $test->ManageObject( $object, NULL, kFLAG_PERSIST_INSERT );
	echo( 'Object<pre>' ); print_r( $object ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Insert object with different ID.
	//
	echo( '<h4>Insert object with different ID</h4>' );
	echo( '<h5>$status = $test->ManageObject( $object, 2, kFLAG_PERSIST_INSERT );</h5>' );
	$status = $test->ManageObject( $object, 2, kFLAG_PERSIST_INSERT );
	echo( 'Object<pre>' ); print_r( $object ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Insert duplicate object.
	//
	try
	{
		echo( '<h4>Insert duplicate object</h4>' );
		echo( '<h5>$status = $test->ManageObject( $object, 1, kFLAG_PERSIST_INSERT );</h5>' );
		$status = $test->ManageObject( $object, 1, kFLAG_PERSIST_INSERT );
		echo( '<h3><font color="red">Should have raised an exception</font></h3>' );
		echo( 'Object<pre>' ); print_r( $object ); echo( '</pre>' );
		echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
		echo( '<hr />' );
	}
	catch( Exception $error )
	{
		echo( '<h5>Expected exception</h5>' );
		echo( '<pre>'.(string) $error.'</pre>' );
		echo( '<hr>' );
	}
	echo( '<hr>' );
	
	//
	// Update object.
	//
	echo( '<h4>Update object</h4>' );
	echo( '<h5>$object[ "NEW" ] = "New field";</h5>' );
	$object[ "NEW" ] = "New field";
	echo( 'Object<pre>' ); print_r( $object ); echo( '</pre>' );
	echo( '<h5>$status = $test->ManageObject( $object, NULL, kFLAG_PERSIST_UPDATE );</h5>' );
	$status = $test->ManageObject( $object, NULL, kFLAG_PERSIST_UPDATE );
	echo( 'Object<pre>' ); print_r( $object ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Update non-existing object.
	//
	echo( '<h4>Update non-existing object</h4>' );
	echo( '<h5>$status = $test->ManageObject( $object, 9, kFLAG_PERSIST_UPDATE );</h5>' );
	$status = $test->ManageObject( $object, 9, kFLAG_PERSIST_UPDATE );
	echo( 'Object<pre>' ); print_r( $object ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Replace new object.
	//
	echo( '<h4>Replace new object</h4>' );
	echo( '<h5>$object->offsetUnset( kTAG_NID );</h5>' );
	$object->offsetUnset( kTAG_NID );
	echo( 'Object<pre>' ); print_r( $object ); echo( '</pre>' );
	echo( '<h5>$status = $test->ManageObject( $object, NULL, kFLAG_PERSIST_REPLACE );</h5>' );
	$status = $test->ManageObject( $object, NULL, kFLAG_PERSIST_REPLACE );
	echo( 'Object<pre>' ); print_r( $object ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Replace existing object.
	//
	echo( '<h4>Replace existing object</h4>' );
	echo( '<h5>$object[ "ARRAY1" ] = array( "A", "B", "C" );</h5>' );
	$object[ "ARRAY1" ] = array( "A", "B", "C" );
	echo( '<h5>$object[ "ARRAY2" ] = array( 1, 2, 3 );</h5>' );
	$object[ "ARRAY2" ] = array( 1, 2, 3 );
	echo( '<h5>$object[ "COUNTER" ] = 25;</h5>' );
	$object[ "COUNTER" ] = 25;
	echo( '<h5>$status = $test->ManageObject( $object, 2, kFLAG_PERSIST_REPLACE );</h5>' );
	$status = $test->ManageObject( $object, 2, kFLAG_PERSIST_REPLACE );
	echo( 'Object<pre>' ); print_r( $object ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Add and remove fields.
	//
	echo( '<h4>Add and remove fields</h4>' );
	echo( '<h5>$offsets = array( "ADDED" => "Added!", "NEW" => NULL );</h5>' );
	$offsets = array( "ADDED" => "Added!", "NEW" => NULL );
	echo( '<h5>$status = $test->ManageObject( $offsets, 2, kFLAG_PERSIST_MODIFY );</h5>' );
	$status = $test->ManageObject( $offsets, 2, kFLAG_PERSIST_MODIFY );
	echo( 'Object<pre>' ); print_r( $offsets ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Increment counter.
	//
	echo( '<h4>Increment counter</h4>' );
	echo( '<h5>$offsets = array( "COUNTER" => 1 );</h5>' );
	$offsets = array( "COUNTER" => 1 );
	echo( '<h5>$status = $test->ManageObject( $offsets, 2, kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_INCREMENT );</h5>' );
	$status = $test->ManageObject( $offsets, 2, kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_INCREMENT );
	echo( 'Object<pre>' ); print_r( $offsets ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Increment counter for non existing object.
	//
	echo( '<h4>Increment counter for non existing object</h4>' );
	echo( '<h5>$offsets = array( "COUNTER" => 1 );</h5>' );
	$offsets = array( "COUNTER" => 1 );
	echo( '<h5>$status = $test->ManageObject( $offsets, -99, kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_INCREMENT );</h5>' );
	$status = $test->ManageObject( $offsets, -99, kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_INCREMENT );
	echo( 'Object<pre>' ); print_r( $offsets ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Decrement counter.
	//
	echo( '<h4>Decrement counter</h4>' );
	echo( '<h5>$offsets = array( "COUNTER" => -10 );</h5>' );
	$offsets = array( "COUNTER" => -10 );
	echo( '<h5>$status = $test->ManageObject( $offsets, 2, kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_INCREMENT );</h5>' );
	$status = $test->ManageObject( $offsets, 2, kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_INCREMENT );
	echo( 'Object<pre>' ); print_r( $offsets ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Append.
	//
	echo( '<h4>Append</h4>' );
	echo( '<h5>$offsets = array( "ARRAY1" => "D" );</h5>' );
	$offsets = array( "ARRAY1" => "D" );
	echo( '<h5>$status = $test->ManageObject( $offsets, 2, kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_APPEND );</h5>' );
	$status = $test->ManageObject( $offsets, 2, kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_APPEND );
	echo( 'Object<pre>' ); print_r( $offsets ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Append again.
	//
	echo( '<h4>Append again</h4>' );
	echo( '<h5>$offsets = array( "ARRAY1" => "D" );</h5>' );
	$offsets = array( "ARRAY1" => "D" );
	echo( '<h5>$status = $test->ManageObject( $offsets, 2, kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_APPEND );</h5>' );
	$status = $test->ManageObject( $offsets, 2, kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_APPEND );
	echo( 'Object<pre>' ); print_r( $offsets ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Add to set.
	//
	echo( '<h4>Add to set</h4>' );
	echo( '<h5>$offsets = array( "ARRAY2" => 4 );</h5>' );
	$offsets = array( "ARRAY2" => 4 );
	echo( '<h5>$status = $test->ManageObject( $offsets, 2, kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_ADDSET );</h5>' );
	$status = $test->ManageObject( $offsets, 2, kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_ADDSET );
	echo( 'Object<pre>' ); print_r( $offsets ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Add duplicate to set.
	//
	echo( '<h4>Add duplicate to set</h4>' );
	echo( '<h5>$offsets = array( "ARRAY2" => 1 );</h5>' );
	$offsets = array( "ARRAY2" => 1 );
	echo( '<h5>$status = $test->ManageObject( $offsets, 2, kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_ADDSET );</h5>' );
	$status = $test->ManageObject( $offsets, 2, kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_ADDSET );
	echo( 'Object<pre>' ); print_r( $offsets ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Add duplicate to non-existing set.
	//
	echo( '<h4>Add duplicate to non-existing set</h4>' );
	echo( '<h5>$offsets = array( "ARRAY2" => 1 );</h5>' );
	$offsets = array( "ARRAY2" => 1 );
	echo( '<h5>$status = $test->ManageObject( $offsets, -99, kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_ADDSET );</h5>' );
	$status = $test->ManageObject( $offsets, -99, kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_ADDSET );
	echo( 'Object<pre>' ); print_r( $offsets ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Pop first.
	//
	echo( '<h4>Pop first</h4>' );
	echo( '<h5>$offsets = array( "ARRAY2" => 100 );</h5>' );
	$offsets = array( "ARRAY2" => 100 );
	echo( '<h5>$status = $test->ManageObject( $offsets, 2, kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_POP );</h5>' );
	$status = $test->ManageObject( $offsets, 2, kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_POP );
	echo( 'Object<pre>' ); print_r( $offsets ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Pop last.
	//
	echo( '<h4>Pop last</h4>' );
	echo( '<h5>$offsets = array( "ARRAY2" => -1 );</h5>' );
	$offsets = array( "ARRAY2" => -1 );
	echo( '<h5>$status = $test->ManageObject( $offsets, 2, kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_POP );</h5>' );
	$status = $test->ManageObject( $offsets, 2, kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_POP );
	echo( 'Object<pre>' ); print_r( $offsets ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Pull.
	//
	echo( '<h4>Pull</h4>' );
	echo( '<h5>$offsets = array( "ARRAY1" => "D" );</h5>' );
	$offsets = array( "ARRAY1" => "D" );
	echo( '<h5>$status = $test->ManageObject( $offsets, 2, kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_PULL );</h5>' );
	$status = $test->ManageObject( $offsets, 2, kFLAG_PERSIST_MODIFY + kFLAG_MODIFY_PULL );
	echo( 'Object<pre>' ); print_r( $offsets ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Delete existing object.
	//
	echo( '<h4>Delete existing object</h4>' );
	echo( '<h5>$status = $test->ManageObject( $object, NULL, kFLAG_PERSIST_DELETE );</h5>' );
	$status = $test->ManageObject( $object, NULL, kFLAG_PERSIST_DELETE );
	echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Delete non-existing object.
	//
	echo( '<h4>Delete non-existing object</h4>' );
	echo( '<h5>$status = $test->ManageObject( $scrap, "CRAP", kFLAG_PERSIST_DELETE );</h5>' );
	$status = $test->ManageObject( $scrap, "CRAP", kFLAG_PERSIST_DELETE );
	echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Load existing object.
	//
	echo( '<h4>Load existing object</h4>' );
	echo( '<h5>$status = $test->ManageObject( $object, 1 );</h5>' );
	$status = $test->ManageObject( $object, 1 );
	echo( 'Object<pre>' ); print_r( $object ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Load one offset.
	//
	echo( '<h4>Load one offset</h4>' );
	echo( '<h5>$status = $test->ManageObject( $object, 1, array( "DATA" ) );</h5>' );
	$status = $test->ManageObject( $object, 1, array( "DATA" ) );
	echo( 'Object<pre>' ); print_r( $object ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Load non-existing object.
	//
	echo( '<h5>$status = $test->ManageObject( $object, "CRAP" );</h5>' );
	$status = $test->ManageObject( $object, "CRAP" );
	echo( 'Object<pre>' ); print_r( $object ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
	echo( '<hr>' );
	echo( '<hr />' );
	
	//
	// Call sequence 1.
	//
	echo( '<h4>Call sequence 1</h4>' );
	echo( '<h5>$i = $test->NextSequence( "sequence 1", TRUE );</h5>' );
	$i = $test->NextSequence( "sequence 1", TRUE );
	echo( '<pre>' ); print_r( $i ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Call sequence 1 again.
	//
	echo( '<h4>Call sequence 1 again</h4>' );
	echo( '<h5>$i = $test->NextSequence( "sequence 1", TRUE );</h5>' );
	$i = $test->NextSequence( "sequence 1", TRUE );
	echo( '<pre>' ); print_r( $i ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// And again...
	//
	echo( '<h4>And again...</h4>' );
	echo( '<h5>$i = $test->NextSequence( "sequence 1", TRUE );</h5>' );
	$i = $test->NextSequence( "sequence 1", TRUE );
	echo( '<pre>' ); print_r( $i ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Call sequence 2.
	//
	echo( '<h4>Call sequence 2</h4>' );
	echo( '<h5>$i = $test->NextSequence( "sequence 2", TRUE );</h5>' );
	$i = $test->NextSequence( "sequence 2", TRUE );
	echo( '<pre>' ); print_r( $i ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Call sequence 2 on another container.
	//
	echo( '<h4>Call sequence 2 on another container</h4>' );
	echo( '<h5>$i = $test->NextSequence( "sequence 2", "OTHER-SEQUENCE" );</h5>' );
	$i = $test->NextSequence( "sequence 2", "OTHER-SEQUENCE" );
	echo( '<pre>' ); print_r( $i ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Test equals query.
	//
	echo( '<h4>Test equals query</h4>' );
	echo( '<h5>$query = new CMongoQuery();</h5>' );
	$query = new CMongoQuery();
	echo( '<h5>$stmt = CQueryStatement::Equals( "B", "due" );</h5>' );
	$stmt = CQueryStatement::Equals( "B", "due" );
	echo( '<h5>$query->AppendStatement( $stmt );</h5>' );
	$query->AppendStatement( $stmt );
	echo( '<h5>$rs = $test->Query( $query );</h5>' );
	$rs = $test->Query( $query );
	echo( '<h5>$count = $rs->count();</h5>' );
	$count = $rs->count();
	echo( "$count<br>" );
	foreach( $rs as $record )
		{ 	echo( '<pre>' ); print_r( $record ); echo( '</pre>' );	}
	echo( '<hr />' );
	
	//
	// Test exists query.
	//
	echo( '<h4>Test exists query</h4>' );
	echo( '<h5>$query = new CMongoQuery();</h5>' );
	$query = new CMongoQuery();
	echo( '<h5>$stmt = CQueryStatement::Exists( "DATA" );</h5>' );
	$stmt = CQueryStatement::Exists( "DATA" );
	echo( '<h5>$query->AppendStatement( $stmt );</h5>' );
	$query->AppendStatement( $stmt );
	echo( '<h5>$rs = $test->Query( $query );</h5>' );
	$rs = $test->Query( $query );
	echo( '<h5>$count = $rs->count();</h5>' );
	$count = $rs->count();
	echo( "$count<br>" );
	foreach( $rs as $record )
		{ 	echo( '<pre>' ); print_r( $record ); echo( '</pre>' );	}
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Test remove query.
	//
	echo( '<h4>Test remove query</h4>' );
	echo( '<h5>$query = new CMongoQuery();</h5>' );
	$query = new CMongoQuery();
	echo( '<h5>$stmt = CQueryStatement::Exists( "DATA" );</h5>' );
	$stmt = CQueryStatement::Exists( "DATA" );
	echo( '<h5>$query->AppendStatement( $stmt );</h5>' );
	$query->AppendStatement( $stmt );
	echo( '<h5>$count = $test->Remove( $query );</h5>' );
	$count = $test->Remove( $query );
	echo( "$count<br>" );
	echo( '<hr />' );
	
	//
	// Test remove container query.
	//
	echo( '<h4>Test remove container query</h4>' );
	echo( '<h5>$count = $test->Remove();</h5>' );
	$count = $test->Remove();
	echo( "$count<br>" );
	echo( '<hr />' );
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
