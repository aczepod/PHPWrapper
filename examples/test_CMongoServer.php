<?php

/**
 * {@link CMongoServer.php Base} object test suite.
 *
 * This file contains routines to test and demonstrate the behaviour of the
 * base object {@link CMongoServer class}.
 *
 *	@package	Test
 *	@subpackage	Framework
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 08/09/2012
 */

/*=======================================================================================
 *																						*
 *								test_CMongoServer.php									*
 *																						*
 *======================================================================================*/

//
// Global includes.
//
require_once( 'includes.inc.php' );

//
// Class includes.
//
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CMongoServer.php" );

//
// Graph includes.
//
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CNeo4jGraph.php" );


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
		echo( '<h5>$test = new CMongoServer();</h5>' );
		$test = new CMongoServer();
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
	// Instantiate empty server.
	//
	echo( '<h4>Instantiate empty server</h4>' );
	echo( '<h5>$test = new CMongoServer();</h5>' );
	$test = new CMongoServer();
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Instantiate specific server.
	//
	echo( '<h4>Instantiate specific server</h4>' );
	echo( '<h5>$url = $test[ kOFFSET_NAME ];</h5>' );
	$url = $test[ kOFFSET_NAME ];
	echo( "$url<br>" );
	echo( '<h5>$test = new CMongoServer();</h5>' );
	$test = new CMongoServer( $url );
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Return/create database.
	//
	echo( '<h4>Return/create database</h4>' );
	echo( '<h5>$db = $test->Database( "TEST" );</h5>' );
	$db = $test->Database( "TEST" );
	echo( '<pre>' ); print_r( $db ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Return/create empty database.
	//
	try
	{
		echo( '<h4>Return/create database</h4>' );
		echo( '<h5>$db = $test->Database();</h5>' );
		$db = $test->Database();
		echo( '<h3><font color="red">Should have raised an exception</font></h3>' );
		echo( '<pre>' ); print_r( $db ); echo( '</pre>' );
		echo( '<hr />' );
	}
	catch( Exception $error )
	{
		echo( '<h5>Expected exception</h5>' );
		echo( '<pre>'.(string) $error.'</pre>' );
		echo( '<hr>' );
	}
	
	//
	// Change server.
	//
	echo( '<h4>Change server</h4>' );
	echo( '<h5>$test->Connection( ( class_exists( "MongoClient" ) ) ? new MongoClient() : new Mongo() );</h5>' );
	$test->Connection( ( class_exists( 'MongoClient' ) ) ? new MongoClient() : new Mongo() );
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
	
	//
	// Set graph.
	//
	echo( '<h4>Set graph</h4>' );
	echo( '<h5>$test->Graph( new CNeo4jGraph() );</h5>' );
	$test->Graph( new CNeo4jGraph() );
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Remove graph.
	//
	echo( '<h4>Remove graph</h4>' );
	echo( '<h5>$test->Graph( FALSE );</h5>' );
	$test->Graph( FALSE );
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
