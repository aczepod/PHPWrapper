<?php

/**
 * {@link CMongoSequence.php Base} object test suite.
 *
 * This file contains routines to test and demonstrate the behaviour of the
 * base object {@link CMongoSequence class}.
 *
 *	@package	Test
 *	@subpackage	Framework
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 04/09/2012
 */

/*=======================================================================================
 *																						*
 *								test_CMongoSequence.php									*
 *																						*
 *======================================================================================*/

//
// Global includes.
//
require_once( '/Library/WebServer/Library/PHPWrapper/includes.inc.php' );

//
// Auxiliary includes.
//
use \MyWrapper\Persistence\CMongoServer as CMongoServer;
use \MyWrapper\Persistence\CMongoDatabase as CMongoDatabase;
use \MyWrapper\Persistence\CMongoCollection as CMongoCollection;

//
// Class includes.
//
use \MyWrapper\Persistence\CMongoSequence as CMongoSequence;


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
		echo( '<h5>$test = new CMongoSequence();</h5>' );
		$test = new CMongoSequence();
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
		
		//
		// Create container.
		//
		echo( '<h4>Create test container</h4>' );
		echo( '$mongo = New CMongoServer();<br />' );
		$mongo = New CMongoServer();
		echo( '$db = $mongo->Database( "TEST" );<br />' );
		$db = $mongo->Database( "TEST" );
		$db->Connection()->drop();
		echo( '$container = new CMongoSequence( $db, "CMongoSequence" );<br />' );
		$container = new CMongoSequence( $db, "CMongoSequence" );
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
			echo( '<h5>$test = new CMongoSequence( \'should fail\' );</h5>' );
			$test = new CMongoSequence( 'should fail' );
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
		echo( '<h5>$test = new CMongoSequence( $collection );</h5>' );
		$test = new CMongoSequence( $collection );
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
	}
	
	//
	// Restore container.
	//
	echo( '<h4>Restore container</h4>' );
	echo( '<h5>$test = new CMongoSequence( $collection );</h5>' );
	$test = new CMongoSequence( $collection );
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Call sequence 1.
	//
	echo( '<h4>Call sequence 1</h4>' );
	echo( '<h5>$i = $test->Next( "sequence 1" );</h5>' );
	$i = $test->Next( "sequence 1" );
	echo( '<pre>' ); print_r( $i ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Call sequence 1 again.
	//
	echo( '<h4>Call sequence 1 again</h4>' );
	echo( '<h5>$i = $test->Next( "sequence 1" );</h5>' );
	$i = $test->Next( "sequence 1" );
	echo( '<pre>' ); print_r( $i ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// And again...
	//
	echo( '<h4>And again...</h4>' );
	echo( '<h5>$i = $test->Next( "sequence 1" );</h5>' );
	$i = $test->Next( "sequence 1" );
	echo( '<pre>' ); print_r( $i ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Call sequence 2.
	//
	echo( '<h4>Call sequence 2</h4>' );
	echo( '<h5>$i = $test->Next( "sequence 2" );</h5>' );
	$i = $test->Next( "sequence 2" );
	echo( '<pre>' ); print_r( $i ); echo( '</pre>' );
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
