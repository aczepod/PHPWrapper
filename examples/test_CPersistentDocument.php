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
require_once( 'includes.inc.php' );

//
// Class includes.
//
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CPersistentDocument.php" );


/*=======================================================================================
 *	RUNTIME SETTINGS																	*
 *======================================================================================*/
 
//
// Debug switches.
//
define( 'kDEBUG_PARENT', TRUE );


/*=======================================================================================
 *	TEST CLASS																			*
 *======================================================================================*/
 
//
// Test class definition.
//
class MyClass extends CPersistentDocument
{
	//
	// Utilities to show protected data.
	//
	public function inited()	{	return ( $this->_IsInited() ) ? 'Y' : 'N';		}
	public function dirty()		{	return ( $this->_IsDirty() ) ? 'Y' : 'N';		}
	public function committed()	{	return ( $this->_IsCommitted() ) ? 'Y' : 'N';	}
	public function encoded()	{	return ( $this->_IsEncoded() ) ? 'Y' : 'N';		}
	//
	// Resolve default container.
	//
	static function DefaultDatabase( CServer $theServer )
		{	return $theServer->Database( "TEST" );	}
	static function DefaultContainer( CDatabase $theDatabase )
		{	return $theDatabase->Container( "CPersistentDocument" );	}
}

//
// Sibling class.
//
class MySibling extends MyClass{}


/*=======================================================================================
 *	TEST DEFAULT EXCEPTIONS																*
 *======================================================================================*/
 
//
// Test class.
//
try
{
	//
	// Create container.
	//
	echo( '<h4>Create test container</h4>' );
	echo( '$server = new CMongoServer();<br />' );
	$server = New CMongoServer();
	echo( '$db = $mongo->selectDB( "TEST" );<br />' );
	echo( '$database = $server->Database( "TEST" );<br />' );
	$database = $server->Database( "TEST" );
	echo( '$database->Drop();<br />' );
	$database->Drop();
	echo( '$container = $database->Container( "CPersistentDocument" );<br />' );
	$container = $database->Container( "CPersistentDocument" );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Test parent class.
	//
	if( kDEBUG_PARENT )
	{
		//
		// Instantiate class.
		//
		echo( '<h4>Instantiate class</h4>' );
		echo( '<h5>$test = new MyClass();</h5>' );
		$test = new MyClass();
		echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
		echo( '<hr />' );
		
		//
		// Set offset.
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
		echo( '<h4>Get missing offset</h4>' );
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
		echo( '<h4>Test array_keys()</h4>' );
		echo( '<h5>$test->array_keys();</h5>' );
		echo( '<pre>' ); print_r( $test->array_keys() ); echo( '</pre>' );
		echo( '<hr />' );
		
		//
		// Test array_values.
		//
		echo( '<h4>Test array_values()</h4>' );
		echo( '<h5>$test->array_values();</h5>' );
		echo( '<pre>' ); print_r( $test->array_values() ); echo( '</pre>' );
		echo( '<hr />' );
		
		//
		// Test array offsets.
		//
		echo( '<h4>Test array offset access</h4>' );
		echo( '<h5>$test[ \'C\' ][ 1 ];</h5>' );
		echo( '<pre>' ); print_r( $test[ 'C' ][ 1 ] ); echo( '</pre>' );
		echo( '<hr />' );
	}
	
	//
	// Instantiate class.
	//
	echo( '<h4>Instantiate class</h4>' );
	echo( '<h5>$test = new MyClass();</h5>' );
	$test = new MyClass();
	echo( '<h4>Add some offsets</h4>' );
	echo( '<h5>$test[ "CODE" ] = "This is the global unique identifier of the object";</h5>' );
	$test[ "CODE" ] = "This is the global unique identifier of the object";
	echo( '<h5>$test[ \'B\' ] = 2;</h5>' );
	$test[ 'B' ] = 2;
	echo( '<h5>$test[ \'C\' ] = array( 1, 2, 3 );</h5>' );
	$test[ 'C' ] = array( 1, 2, 3 );
	echo( 'Inited['.$test->inited().'] Dirty['.$test->dirty().'] Saved['.$test->committed().'] Encoded['.$test->encoded().']<br />' );
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Insert document.
	//
	echo( '<h4>Insert document</h4>' );
	echo( '<h5>$status = $test->Insert( $container );</h5>' );
	$status = $test->Insert( $container );
	$id = $test[ kTAG_NID ];
	echo( 'Inited['.$test->inited().'] Dirty['.$test->dirty().'] Saved['.$test->committed().'] Encoded['.$test->encoded().']<br />' );
	echo( 'Object<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Insert duplicate document.
	//
	try
	{
		echo( '<h4>Insert duplicate document</h4>' );
		echo( '<h5>$test[ "B" ] = 3; // To turn on the dirty flag...</h5>' );
		$test[ "B" ] = 3;
		echo( '<h5>$status = $test->Insert( $container ); // Should raise an exception.</h5>' );
		$status = $test->Insert( $container );
		echo( '<h3><font color="red">Should have raised an exception</font></h3>' );
		echo( 'Inited['.$test->inited().'] Dirty['.$test->dirty().'] Saved['.$test->committed().'] Encoded['.$test->encoded().']<br />' );
		echo( 'Object<pre>' ); print_r( $test ); echo( '</pre>' );
		echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
		echo( '<hr />' );
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
	// Update document.
	//
	echo( '<h4>Update document</h4>' );
	echo( '<h5>$test[ "B" ] = "bee";</h5>' );
	$test[ "B" ] = "bee";
	echo( 'Inited['.$test->inited().'] Dirty['.$test->dirty().'] Saved['.$test->committed().'] Encoded['.$test->encoded().']<br />' );
	echo( '<h5>$test->Update( $server );</h5>' );
	$test->Update( $server );
	echo( 'Inited['.$test->inited().'] Dirty['.$test->dirty().'] Saved['.$test->committed().'] Encoded['.$test->encoded().']<br />' );
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Update missing document.
	//
	try
	{
		echo( '<h4>Update missing document</h4>' );
		echo( '<h5>$test[ kTAG_NID ] = 99;</h5>' );
		$test[ kTAG_NID ] = 99;
		echo( '<h5>$test->Update( $container ); // Should raise an exception.</h5>' );
		$test->Update( $container );
		echo( '<h3><font color="red">Should have raised an exception</font></h3>' );
		echo( 'Inited['.$test->inited().'] Dirty['.$test->dirty().'] Saved['.$test->committed().'] Encoded['.$test->encoded().']<br />' );
		echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
		echo( '<hr />' );
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
	// Replace new document.
	//
	echo( '<h4>Replace new document</h4>' );
	echo( '<h5>$test[ "B" ] = 3; // To turn on the dirty flag...</h5>' );
	$test[ "B" ] = 3;
	echo( '<h5>$status = $test->Replace( $server ); // We have set a missing ID before...</h5>' );
	$status = $test->Replace( $server );
	echo( 'Inited['.$test->inited().'] Dirty['.$test->dirty().'] Saved['.$test->committed().'] Encoded['.$test->encoded().']<br />' );
	echo( 'Object<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Replace existing document.
	//
	echo( '<h4>Replace existing document</h4>' );
	echo( '<h5>$test[ "X" ] = 10; // To turn on the dirty flag...</h5>' );
	$test[ "X" ] = 10;
	echo( '<h5>$status = $test->Replace( $server );</h5>' );
	$status = $test->Replace( $server );
	echo( 'Inited['.$test->inited().'] Dirty['.$test->dirty().'] Saved['.$test->committed().'] Encoded['.$test->encoded().']<br />' );
	echo( 'Object<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Reset non-existing document.
	//
	echo( '<h4>Reset non-existing document</h4>' );
	echo( '<h5>$test[ "B" ] = NULL;</h5>' );
	$test[ "B" ] = NULL;
	echo( '<h5>$test[ "C" ] = NULL;</h5>' );
	$test[ "C" ] = NULL;
	echo( '<h5>$test[ kTAG_NID ] = "pippo";</h5>' );
	$test[ kTAG_NID ] = "pippo";
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<h5>$status = $test->Restore( $server );</h5>' );
	$status = $test->Restore( $server );
	echo( 'Inited['.$test->inited().'] Dirty['.$test->dirty().'] Saved['.$test->committed().'] Encoded['.$test->encoded().']<br />' );
	echo( 'Object<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Reset existing document.
	//
	echo( '<h4>Reset existing document</h4>' );
	echo( '<h5>$test[ kTAG_NID ] = 99;</h5>' );
	$test[ kTAG_NID ] = 99;
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<h5>$status = $test->Restore( $server );</h5>' );
	$status = $test->Restore( $server );
	echo( 'Inited['.$test->inited().'] Dirty['.$test->dirty().'] Saved['.$test->committed().'] Encoded['.$test->encoded().']<br />' );
	echo( 'Object<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Delete existing document.
	//
	echo( '<h4>Delete existing document</h4>' );
	echo( '<h5>$status = $test->Delete( $server );</h5>' );
	$status = $test->Delete( $server );
	echo( 'Inited['.$test->inited().'] Dirty['.$test->dirty().'] Saved['.$test->committed().'] Encoded['.$test->encoded().']<br />' );
	echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Delete missing document.
	//
	echo( '<h4>Delete missing document</h4>' );
	echo( '<h5>$status = $test->Delete( $server );</h5>' );
	$status = $test->Delete( $server );
	echo( 'Inited['.$test->inited().'] Dirty['.$test->dirty().'] Saved['.$test->committed().'] Encoded['.$test->encoded().']<br />' );
	echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Create an existing document from the base class.
	//
	echo( '<h4>Create an existing document from the base class</h4>' );
	echo( '<h5>$test = CPersistentDocument::NewObject( $container, $id );</h5>' );
	$test = CPersistentDocument::NewObject( $container, $id );
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Create an existing document from the derived class using container resolution.
	//
	echo( '<h4>Create an existing document from the derived class using container resolution</h4>' );
	echo( '<h5>$test = MyClass::NewObject( $server, $id );</h5>' );
	$test = MyClass::NewObject( $server, $id );
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Create an existing document from the sibling class using container resolution.
	//
	echo( '<h4>Create an existing document from the sibling class using container resolution</h4>' );
	echo( '<h5>$test = MySibling::NewObject( $server, $id );</h5>' );
	$test = MySibling::NewObject( $server, $id );
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Create a missing document.
	//
	echo( '<h4>Create a missing document</h4>' );
	echo( '<h5>$test = CPersistentDocument::NewObject( $container, 99 );</h5>' );
	$test = CPersistentDocument::NewObject( $container, 99 );
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
