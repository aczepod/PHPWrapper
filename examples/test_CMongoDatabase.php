<?php

/**
 * {@link CMongoDatabase.php Base} object test suite.
 *
 * This file contains routines to test and demonstrate the behaviour of the
 * base object {@link CMongoDatabase class}.
 *
 *	@package	Test
 *	@subpackage	Framework
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 08/09/2012
 */

/*=======================================================================================
 *																						*
 *								test_CMongoDatabase.php									*
 *																						*
 *======================================================================================*/

//
// Global includes.
//
require_once( 'includes.inc.php' );

//
// Class includes.
//
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CMongoDatabase.php" );


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
		echo( '<h5>$test = new CMongoDatabase();</h5>' );
		$test = new CMongoDatabase();
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
	// Instantiate server.
	//
	echo( '<h4>Instantiate server</h4>' );
	echo( '<h5>$server = new CMongoServer();</h5>' );
	$server = new CMongoServer();
	echo( '<pre>' ); print_r( $server ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Instantiate empty database.
	//
	echo( '<h4>Instantiate empty database</h4>' );
	echo( '<h5>$test = new CMongoDatabase();</h5>' );
	$test = new CMongoDatabase();
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Instantiate specific database.
	//
	echo( '<h4>Instantiate specific database</h4>' );
	echo( '<h5>$test = new CMongoDatabase( $server, "DB" );</h5>' );
	$test = new CMongoDatabase( $server, "DB" );
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Return/create container.
	//
	echo( '<h4>Return/create container</h4>' );
	echo( '<h5>$container = $test->Container( "CONTAINER" );</h5>' );
	$container = $test->Container( "CONTAINER" );
	echo( '<pre>' ); print_r( $container ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Return/create empty container.
	//
	try
	{
		echo( '<h4>Return/create container</h4>' );
		echo( '<h5>$container = $test->Container();</h5>' );
		$container = $test->Container();
		echo( '<h3><font color="red">Should have raised an exception</font></h3>' );
		echo( '<pre>' ); print_r( $container ); echo( '</pre>' );
		echo( '<hr />' );
	}
	catch( Exception $error )
	{
		echo( '<h5>Expected exception</h5>' );
		echo( '<pre>'.(string) $error.'</pre>' );
		echo( '<hr>' );
	}
	
	//
	// Change database.
	//
	echo( '<h4>Change database</h4>' );
	echo( '<h5>$test->Connection( $server->Connection()->selectDB( "NEW" ) );</h5>' );
	$test->Connection( $server->Connection()->selectDB( "NEW" ) );
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Convert to string.
	//
	echo( '<h4>Convert to string</h4>' );
	echo( '<h5>$name = (string) $test;</h5>' );
	$name = (string) $test;
	echo( '<pre>' ); print_r( $name ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Remove connection.
	//
	echo( '<h4>Remove connection</h4>' );
	echo( '<h5>$test->Connection( FALSE );</h5>' );
	$test->Connection( FALSE );
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
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
