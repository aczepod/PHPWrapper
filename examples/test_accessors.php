<?php

/**
 * <tt>accessors.php</tt> function test suite.
 *
 * This file contains routines to test and demonstrate the behaviour of the
 * <tt>accessors.php</tt> function.
 *
 *	@package	Test
 *	@subpackage	Framework
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 05/11/2012
 */

/*=======================================================================================
 *																						*
 *									test_accessors.php									*
 *																						*
 *======================================================================================*/

//
// Global includes.
//
require_once( '/Library/WebServer/Library/PHPWrapper/includes.inc.php' );

//
// Function includes.
//
require_once( kPATH_MYWRAPPER_LIBRARY_FUNCTION."/accessors.php" );


/*=======================================================================================
 *	TEST																				*
 *======================================================================================*/
 
//
// Test class.
//
try
{
	//
	// Create test object.
	//
	echo( '<hr />' );
	echo( '<h4>Create test object</h4>' );
	echo( '<h5>$test = new ArrayObject();</h5>' );
	$test = new ArrayObject();
	echo( '<h5>$test->testProperty = "testProperty";</h5>' );
	$test->testProperty = "some data";
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Test ManageProperty.
	//
	echo( '<h4>Test ManageProperty</h4>' );
	echo( '<h5>$result = ManageProperty( $test->testProperty, "new data", TRUE );</h5>' );
	$result = ManageProperty( $test->testProperty, "new data", TRUE );
	echo( 'Result:<pre>' ); print_r( $result ); echo( '</pre>' );
	echo( 'Object:<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<h5>$result = ManageProperty( $test->testProperty, NULL );</h5>' );
	$result = ManageProperty( $test->testProperty, NULL );
	echo( 'Result:<pre>' ); print_r( $result ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<h5>$result = ManageProperty( $test->testProperty, FALSE, TRUE );</h5>' );
	$result = ManageProperty( $test->testProperty, FALSE, TRUE );
	echo( 'Result:<pre>' ); print_r( $result ); echo( '</pre>' );
	echo( 'Object:<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Test ManageOffset.
	//
	echo( '<h4>Test ManageOffset</h4>' );
	echo( '<h5>$result = ManageOffset( $test, "offset", "Some data" );</h5>' );
	$result = ManageOffset( $test, "offset", "Some data" );
	echo( 'Result:<pre>' ); print_r( $result ); echo( '</pre>' );
	echo( 'Object:<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<h5>$result = ManageOffset( $test, "offset" );</h5>' );
	$result = ManageOffset( $test, "offset" );
	echo( 'Result:<pre>' ); print_r( $result ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<h5>$result = ManageOffset( $test, "offset", FALSE, TRUE );</h5>' );
	$result = ManageOffset( $test, "offset", FALSE, TRUE );
	echo( 'Result:<pre>' ); print_r( $result ); echo( '</pre>' );
	echo( 'Object:<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Test ManageTypedOffset.
	//
	echo( '<h4>Test ManageTypedOffset</h4>' );
	echo( '<h5>$result = ManageTypedOffset( $test, "offset", "TYPE", "DATA", "type", "data" );</h5>' );
	$result = ManageTypedOffset( $test, "offset", "TYPE", "DATA", "type", "data" );
	echo( 'Result:<pre>' ); print_r( $result ); echo( '</pre>' );
	echo( 'Object:<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<h5>$result = ManageTypedOffset( $test, "offset", "TYPE", "DATA", "type", "type data" );</h5>' );
	$result = ManageTypedOffset( $test, "offset", "TYPE", "DATA", "type", "type data" );
	echo( 'Result:<pre>' ); print_r( $result ); echo( '</pre>' );
	echo( 'Object:<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<h5>$result = ManageTypedOffset( $test, "offset", "TYPE", "DATA", NULL, "empty data" );</h5>' );
	$result = ManageTypedOffset( $test, "offset", "TYPE", "DATA", NULL, "empty data" );
	echo( 'Result:<pre>' ); print_r( $result ); echo( '</pre>' );
	echo( 'Object:<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<h5>$result = ManageTypedOffset( $test, "offset", "TYPE", "DATA" );</h5>' );
	$result = ManageTypedOffset( $test, "offset", "TYPE", "DATA" );
	echo( 'Result:<pre>' ); print_r( $result ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<h5>$result = ManageTypedOffset( $test, "offset", "TYPE", "DATA", "type" );</h5>' );
	$result = ManageTypedOffset( $test, "offset", "TYPE", "DATA", "type" );
	echo( 'Result:<pre>' ); print_r( $result ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<h5>$result = ManageTypedOffset( $test, "offset", "TYPE", "DATA", "???" );</h5>' );
	$result = ManageTypedOffset( $test, "offset", "TYPE", "DATA", "???" );
	echo( 'Result:<pre>' ); print_r( $result ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<h5>$result = ManageTypedOffset( $test, "offset", "TYPE", "DATA", "type", FALSE, TRUE );</h5>' );
	$result = ManageTypedOffset( $test, "offset", "TYPE", "DATA", "type", FALSE, TRUE );
	echo( 'Result:<pre>' ); print_r( $result ); echo( '</pre>' );
	echo( 'Object:<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<h5>$result = ManageTypedOffset( $test, "offset", "TYPE", "DATA", NULL, FALSE, TRUE );</h5>' );
	$result = ManageTypedOffset( $test, "offset", "TYPE", "DATA", NULL, FALSE, TRUE );
	echo( 'Result:<pre>' ); print_r( $result ); echo( '</pre>' );
	echo( 'Object:<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Test ManageIndexedOffset.
	//
	echo( '<h4>Test ManageIndexedOffset</h4>' );
	echo( '<h5>$result = ManageIndexedOffset( $test, "offset", "TYPE1", "data" );</h5>' );
	$result = ManageIndexedOffset( $test, "offset", "TYPE1", "data" );
	echo( 'Result:<pre>' ); print_r( $result ); echo( '</pre>' );
	echo( 'Object:<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<h5>$result = ManageIndexedOffset( $test, "offset", "TYPE1", "type1 data", TRUE );</h5>' );
	$result = ManageIndexedOffset( $test, "offset", "TYPE1", "type1 data", TRUE );
	echo( 'Result:<pre>' ); print_r( $result ); echo( '</pre>' );
	echo( 'Object:<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<h5>$result = ManageIndexedOffset( $test, "offset", NULL, "NULL data" );</h5>' );
	$result = ManageIndexedOffset( $test, "offset", NULL, "NULL data" );
	echo( 'Result:<pre>' ); print_r( $result ); echo( '</pre>' );
	echo( 'Object:<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<h5>$result = ManageIndexedOffset( $test, "offset", "TYPE1" );</h5>' );
	$result = ManageIndexedOffset( $test, "offset", "TYPE1" );
	echo( 'Result:<pre>' ); print_r( $result ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<h5>$result = ManageIndexedOffset( $test, "offset", NULL );</h5>' );
	$result = ManageIndexedOffset( $test, "offset", NULL );
	echo( 'Result:<pre>' ); print_r( $result ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<h5>$result = ManageIndexedOffset( $test, "offset", "TYPE1", FALSE, TRUE );</h5>' );
	$result = ManageIndexedOffset( $test, "offset", "TYPE1", FALSE, TRUE );
	echo( 'Result:<pre>' ); print_r( $result ); echo( '</pre>' );
	echo( 'Object:<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<h5>$result = ManageIndexedOffset( $test, "offset", NULL, FALSE, TRUE );</h5>' );
	$result = ManageIndexedOffset( $test, "offset", NULL, FALSE, TRUE );
	echo( 'Result:<pre>' ); print_r( $result ); echo( '</pre>' );
	echo( 'Object:<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );
}

//
// Catch exceptions.
//
catch( \Exception $error )
{
	echo( '<h3><font color="red">Unexpected exception</font></h3>' );
	echo( '<pre>'.(string) $error.'</pre>' );
	echo( '<hr>' );
}

echo( "\nDone!\n" );

?>
