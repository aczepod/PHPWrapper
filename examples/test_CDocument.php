<?php

/**
 * {@link CDocument.php Base} object test suite.
 *
 * This file contains routines to test and demonstrate the behaviour of the
 * base object {@link CDocument class}.
 *
 *	@package	Test
 *	@subpackage	Framework
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 02/09/2012
 */

/*=======================================================================================
 *																						*
 *									test_CDocument.php									*
 *																						*
 *======================================================================================*/

//
// Global includes.
//
require_once( '/Library/WebServer/Library/PHPWrapper/includes.inc.php' );

//
// Class includes.
//
use \MyWrapper\Framework\CDocument;


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
// Instantiate test class.
//
$test = new CDocument();

//
// Test class.
//
try
{
	//
	// Instantiate class.
	//
	echo( '<h4>$test = new CDocument();</h4>' );
	$test = new CDocument();
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Set offset.
	//
	echo( '<h4>$test[ \'A\' ] = \'a\';</h4>' );
	$test[ 'A' ] = 'a';
	echo( '<h4>$test[ \'B\' ] = 2;</h4>' );
	$test[ 'B' ] = 2;
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
