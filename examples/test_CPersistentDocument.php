<?php

/**
 * {@link CPersistentDocument.php Base} object test suite.
 *
 * This file contains routines to test and demonstrate the behaviour of the
 * base object {@link CPersistentDocument class}.
 *
 *	@package	Test
 *	@subpackage	Framework
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 04/09/2012
 */

/*=======================================================================================
 *																						*
 *								test_CPersistentDocument.php							*
 *																						*
 *======================================================================================*/

//
// Global includes.
//
require_once( '/Library/WebServer/Library/PHPWrapper/includes.inc.php' );

//
// Container.
//
use \MyWrapper\Persistence\CMongoContainer;

//
// Class includes.
//
use \MyWrapper\Persistence\CPersistentDocument;


/*=======================================================================================
 *	RUNTIME SETTINGS																	*
 *======================================================================================*/
 
//
// Debug switches.
//
define( 'kDEBUG_PARENT', FALSE );


/*=======================================================================================
 *	TEST CLASS																			*
 *======================================================================================*/
 
//
// Test class definition.
//
class MyClass extends CPersistentDocument
{
	public function __construct( $input = Array(), $flags = 0, $iterator_class = "ArrayIterator" )
	{
		parent::__construct( $input, $flags, $iterator_class );
		$this->_IsInited( TRUE );
	}
	public function inited()	{	return ( $this->_IsInited() ) ? 'Y' : 'N';		}
	public function dirty()		{	return ( $this->_IsDirty() ) ? 'Y' : 'N';		}
	public function committed()	{	return ( $this->_IsCommitted() ) ? 'Y' : 'N';	}
	public function encoded()	{	return ( $this->_IsEncoded() ) ? 'Y' : 'N';		}
}
 
//
// Other test class definition.
//
class MyOtherClass extends MyClass{}


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
		echo( '<h4>$test = new MyClass();</h4>' );
		$test = new MyClass();
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
	// Create container.
	//
	echo( '<hr />' );
	echo( '<h4>$mongo = New Mongo();</h4>' );
	$mongo = New Mongo();
	echo( '<h4>$db = $mongo->selectDB( "TEST" );</h4>' );
	$db = $mongo->selectDB( "TEST" );
	$db->drop();
	echo( '<h4>$collection = $db->selectCollection( "CPersistentDocument" );</h4>' );
	$collection = $db->selectCollection( "CPersistentDocument" );
	echo( '<h4>$container = new CMongoContainer( $collection );</h4>' );
	$container = new CMongoContainer( $collection );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Instantiate class.
	//
	echo( '<h4>$test = new MyClass();</h4>' );
	$test = new MyClass();
	echo( '<h4>$test[ \'A\' ] = \'a\';</h4>' );
	$test[ 'A' ] = 'a';
	echo( '<h4>$test[ \'B\' ] = 2;</h4>' );
	$test[ 'B' ] = 2;
	echo( '<h4>$test[ \'C\' ] = array( 1, 2, 3 );</h4>' );
	$test[ 'C' ] = array( 1, 2, 3 );
	echo( 'Inited['.$test->inited().'] Dirty['.$test->dirty().'] Saved['.$test->committed().'] Encoded['.$test->encoded().']<br />' );
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Insert document.
	//
	echo( '<h4>$status = $test->Insert( $container );</h4>' );
	$status = $test->Insert( $container );
	$id = $test[ kTAG_LID ];
	echo( 'Inited['.$test->inited().'] Dirty['.$test->dirty().'] Saved['.$test->committed().'] Encoded['.$test->encoded().']<br />' );
	echo( 'Object<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Update document.
	//
	echo( '<h4>$test[ "B" ] = "bee";</h4>' );
	$test[ "B" ] = "bee";
	echo( 'Inited['.$test->inited().'] Dirty['.$test->dirty().'] Saved['.$test->committed().'] Encoded['.$test->encoded().']<br />' );
	echo( '<h4>$test->Update( $container );</h4>' );
	$test->Update( $container );
	echo( 'Inited['.$test->inited().'] Dirty['.$test->dirty().'] Saved['.$test->committed().'] Encoded['.$test->encoded().']<br />' );
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Update missing document.
	//
	try
	{
		echo( '<h4>$test[ kTAG_LID ] = 99;</h4>' );
		$test[ kTAG_LID ] = 99;
		echo( '<h4>$test->Update( $container );</h4>' );
		$test->Update( $container );
		echo( 'Inited['.$test->inited().'] Dirty['.$test->dirty().'] Saved['.$test->committed().'] Encoded['.$test->encoded().']<br />' );
		echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
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
	// Replace new document.
	//
	echo( '<h4>$status = $test->Replace( $container );</h4>' );
	$status = $test->Replace( $container );
	echo( 'Inited['.$test->inited().'] Dirty['.$test->dirty().'] Saved['.$test->committed().'] Encoded['.$test->encoded().']<br />' );
	echo( 'Object<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Replace existing document.
	//
	echo( '<h4>$test[ "X" ] = 10;</h4>' );
	$test[ "X" ] = 10;
	echo( '<h4>$status = $test->Replace( $container );</h4>' );
	$status = $test->Replace( $container );
	echo( 'Inited['.$test->inited().'] Dirty['.$test->dirty().'] Saved['.$test->committed().'] Encoded['.$test->encoded().']<br />' );
	echo( 'Object<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Delete document.
	//
	echo( '<h4>$status = $test->Delete( $container );</h4>' );
	$status = $test->Delete( $container );
	echo( 'Inited['.$test->inited().'] Dirty['.$test->dirty().'] Saved['.$test->committed().'] Encoded['.$test->encoded().']<br />' );
	echo( 'Object<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Create generic document.
	//
	echo( '<h4>$test = CPersistentDocument::Create( $container, $id );</h4>' );
	$test = CPersistentDocument::Create( $container, $id );
//	echo( 'Inited['.$test->inited().'] Dirty['.$test->dirty().'] Saved['.$test->committed().'] Encoded['.$test->encoded().']<br />' );
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Create specific document.
	//
	echo( '<h4>$test = new MyClass( $test ); // to set the inited flag...</h4>' );
	$test = new MyClass( $test );
	echo( '<h4>$test[ kTAG_CLASS ] = "MyOtherClass";</h4>' );
	$test[ kTAG_CLASS ] = "MyOtherClass";
	echo( '<h4>$test->Update( $container );</h4>' );
	$test->Update( $container );
	echo( '<h4>$test = CPersistentDocument::Create( $container, $id );</h4>' );
	$test = CPersistentDocument::Create( $container, $id );
	echo( 'Inited['.$test->inited().'] Dirty['.$test->dirty().'] Saved['.$test->committed().'] Encoded['.$test->encoded().']<br />' );
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );
}

//
// Catch exceptions.
//
catch( Exception $error )
{
	echo( '<pre>'.(string) $error.'</pre>' );
	echo( '<hr>' );
}

echo( "\nDone!\n" );

?>
