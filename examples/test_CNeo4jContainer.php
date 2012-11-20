<?php

/**
 * {@link CNeo4jContainer.php Base} object test suite.
 *
 * This file contains routines to test and demonstrate the behaviour of the
 * base object {@link CNeo4jContainer class}.
 *
 *	@package	Test
 *	@subpackage	Framework
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 04/09/2012
 */

/*=======================================================================================
 *																						*
 *								test_CNeo4jContainer.php								*
 *																						*
 *======================================================================================*/

//
// Global includes.
//
require_once( 'includes.inc.php' );

//
// Class includes.
//
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CNeo4jContainer.php" );


/*=======================================================================================
 *	TEST																				*
 *======================================================================================*/
 
//
// Test class.
//
try
{
	//
	// Create container.
	//
	echo( '<hr />' );
	echo( '<h4>Create test container</h4>' );
	echo( '$graph = new CNeo4jContainer();<br />' );
	$graph = new CNeo4jContainer();
	echo( '<pre>' ); print_r( $graph ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );

	//
	// Create node.
	//
	echo( '<h4>Create node</h4>' );
	echo( '$node = $graph->Connection()->makeNode();<br />' );
	$node = $graph->Connection()->makeNode();
	echo( '$node->setProperty( "Name", "Milko" );<br />' );
	$node->setProperty( "Name", "Milko" );
	echo( '$node->setProperty( "Surname", "Škofič" );<br />' );
	$node->setProperty( "Surname", "Škofič" );
	echo( '<pre>' ); print_r( $node ); echo( '</pre>' );
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
