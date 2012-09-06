<?php

/**
 * {@link CPersistentObject.php Base} object test suite.
 *
 * This file contains routines to test and demonstrate the behaviour of the
 * base object {@link CPersistentObject class}.
 *
 *	@package	Test
 *	@subpackage	Framework
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 04/09/2012
 */

/*=======================================================================================
 *																						*
 *								test_CPersistentObject.php								*
 *																						*
 *======================================================================================*/

//
// Global includes.
//
require_once( '/Library/WebServer/Library/PHPWrapper/includes.inc.php' );

//
// Containers.
//
use MyWrapper\Persistence\CContainer;
use MyWrapper\Persistence\CMongoContainer;

//
// Class includes.
//
use MyWrapper\Persistence\CPersistentObject;


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
class MyClass extends CPersistentObject
{
	//
	// Object is inited if it has the 'CODE' offset.
	//
	protected function _Ready()
	{
		if( parent::_Ready() )
			return $this->offsetExists( 'CODE' );
		return FALSE;
	}
	
	//
	// The 36 first characters of the 'CODE' value is the global unique identifier.
	//
	protected function _index( $theContainer, $theModifiers )
	{
		return substr( $this->offsetGet( 'CODE' ), 0, 36 );
	}
	
	//
	// The native unique identifier is hashed.
	//
	static function _id( $theIdentifier = NULL, CContainer $theContainer = NULL )
	{
		if( ($theContainer !==  NULL)
		 && ($theIdentifier !==  NULL) )
			return $theContainer->ConvertBinary( md5( $theIdentifier, TRUE ) );
		
		return parent::_id( $theIdentifier, $theContainer );
	}

	//
	// Utilities to show protected data.
	//
	public function inited()	{	return ( $this->_IsInited() ) ? 'Y' : 'N';		}
	public function dirty()		{	return ( $this->_IsDirty() ) ? 'Y' : 'N';		}
	public function committed()	{	return ( $this->_IsCommitted() ) ? 'Y' : 'N';	}
	public function encoded()	{	return ( $this->_IsEncoded() ) ? 'Y' : 'N';		}
}


/*=======================================================================================
 *	TEST DEFAULT EXCEPTIONS																*
 *======================================================================================*/
 
//
// Test class.
//
try
{
	//
	// Notes.
	//
	echo( '<h4>Object behaviour:</h4>' );
	echo( '<ul>' );
	echo( '<li>Object is inited if it has the <tt>CODE</tt> offset.' );
	echo( '<li>The 36 first characters of the <tt>CODE</tt> value are the global unique identifier.' );
	echo( '<li>The native unique identifier is hashed.' );
	echo( '<li>We implemented a series of public methods to show the object status.' );
	echo( '</ul><hr>' );
	
	//
	// Create container.
	//
	echo( '<hr />' );
	echo( '<h4>Create test container</h4>' );
	echo( '$mongo = New Mongo();<br />' );
	$mongo = New \Mongo();
	echo( '$db = $mongo->selectDB( "TEST" );<br />' );
	$db = $mongo->selectDB( "TEST" );
	$db->drop();
	echo( '$collection = $db->selectCollection( "CPersistentObject" );<br />' );
	$collection = $db->selectCollection( "CPersistentObject" );
	echo( '$container = new CMongoContainer( $collection );<br />' );
	$container = new CMongoContainer( $collection );
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
		
		//
		// Instantiate class.
		//
		echo( '<h4>Instantiate class</h4>' );
		echo( '<h5>$test = new MyClass();</h5>' );
		$test = new MyClass();
		echo( 'Inited['.$test->inited().'] Dirty['.$test->dirty().'] Saved['.$test->committed().'] Encoded['.$test->encoded().']<br />' );
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
		$id = $test[ kOFFSET_NID ];
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
			echo( 'Inited['.$test->inited().'] Dirty['.$test->dirty().'] Saved['.$test->committed().'] Encoded['.$test->encoded().']<br />' );
			echo( 'Object<pre>' ); print_r( $test ); echo( '</pre>' );
			echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
			echo( '<hr />' );
			echo( '<hr />' );
		}
		catch( \Exception $error )
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
		echo( '<h5>$test->Update( $container );</h5>' );
		$test->Update( $container );
		echo( 'Inited['.$test->inited().'] Dirty['.$test->dirty().'] Saved['.$test->committed().'] Encoded['.$test->encoded().']<br />' );
		echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
		echo( '<hr />' );
		
		//
		// Update missing document.
		//
		try
		{
			echo( '<h4>Update missing document</h4>' );
			echo( '<h5>$test[ kOFFSET_NID ] = 99;</h5>' );
			$test[ kOFFSET_NID ] = 99;
			echo( '<h5>$test->Update( $container ); // Should raise an exception.</h5>' );
			$test->Update( $container );
			echo( 'Inited['.$test->inited().'] Dirty['.$test->dirty().'] Saved['.$test->committed().'] Encoded['.$test->encoded().']<br />' );
			echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
			echo( '<hr />' );
			echo( '<hr />' );
		}
		catch( \Exception $error )
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
		echo( '<h5>$status = $test->Replace( $container ); // We have set a missing ID before...</h5>' );
		$status = $test->Replace( $container );
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
		echo( '<h5>$status = $test->Replace( $container );</h5>' );
		$status = $test->Replace( $container );
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
		echo( '<h5>$test[ kOFFSET_NID ] = "pippo";</h5>' );
		$test[ kOFFSET_NID ] = "pippo";
		echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
		echo( '<h5>$status = $test->Restore( $container );</h5>' );
		$status = $test->Restore( $container );
		echo( 'Inited['.$test->inited().'] Dirty['.$test->dirty().'] Saved['.$test->committed().'] Encoded['.$test->encoded().']<br />' );
		echo( 'Object<pre>' ); print_r( $test ); echo( '</pre>' );
		echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
		echo( '<hr />' );
		
		//
		// Reset existing document.
		//
		echo( '<h4>Reset existing document</h4>' );
		echo( '<h5>$test[ kOFFSET_NID ] = 99;</h5>' );
		$test[ kOFFSET_NID ] = 99;
		echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
		echo( '<h5>$status = $test->Restore( $container );</h5>' );
		$status = $test->Restore( $container );
		echo( 'Inited['.$test->inited().'] Dirty['.$test->dirty().'] Saved['.$test->committed().'] Encoded['.$test->encoded().']<br />' );
		echo( 'Object<pre>' ); print_r( $test ); echo( '</pre>' );
		echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
		echo( '<hr />' );
		echo( '<hr />' );
		
		//
		// Delete existing document.
		//
		echo( '<h4>Delete existing document</h4>' );
		echo( '<h5>$status = $test->Delete( $container );</h5>' );
		$status = $test->Delete( $container );
		echo( 'Inited['.$test->inited().'] Dirty['.$test->dirty().'] Saved['.$test->committed().'] Encoded['.$test->encoded().']<br />' );
		echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
		echo( '<hr />' );
		echo( '<hr />' );
		
		//
		// Delete missing document.
		//
		echo( '<h4>Delete missing document</h4>' );
		echo( '<h5>$status = $test->Delete( $container );</h5>' );
		$status = $test->Delete( $container );
		echo( 'Inited['.$test->inited().'] Dirty['.$test->dirty().'] Saved['.$test->committed().'] Encoded['.$test->encoded().']<br />' );
		echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
		echo( '<hr />' );
		echo( '<hr />' );
		
		//
		// Create an existing document.
		//
		echo( '<h4>Create an existing document</h4>' );
		echo( '<h5>$test = CPersistentObject::NewObject( $container, $id );</h5>' );
		$test = CPersistentObject::NewObject( $container, $id );
		echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
		echo( '<hr />' );
		
		//
		// Create a missing document.
		//
		echo( '<h4>Create a missing document</h4>' );
		echo( '<h5>$test = CPersistentObject::NewObject( $container, 99 );</h5>' );
		$test = CPersistentObject::NewObject( $container, 99 );
		echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
		echo( '<hr />' );
		echo( '<hr />' );
	}

	//
	// Insert unitialised object.
	//
	try
	{
		echo( '<h4>Insert uninitialized object</h4>' );
		echo( '<h5>$test = new MyClass();</h5>' );
		$test = new MyClass();
		echo( 'Inited['.$test->inited().'] Dirty['.$test->dirty().'] Saved['.$test->committed().'] Encoded['.$test->encoded().']<br />' );
		echo( '<h5>$status = $test->Insert( $container );</h5>' );
		$status = $test->Insert( $container );
		echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
		echo( '<hr />' );
	}
	catch( \Exception $error )
	{
		echo( '<h5>Expected exception</h5>' );
		echo( '<pre>'.(string) $error.'</pre>' );
		echo( '<hr>' );
	}
	echo( '<hr>' );
	
	//
	// Insert initialized object.
	//
	echo( '<h4>Insert initialized object</h4>' );
	echo( '<h5>$test[ "CODE" ] = "This is another global identifier id of the object";</h5>' );
	$test[ "CODE" ] = "This is another global identifier id of the object";
	echo( 'Inited['.$test->inited().'] Dirty['.$test->dirty().'] Saved['.$test->committed().'] Encoded['.$test->encoded().']<br />' );
	echo( '<h5>$status = $test->Insert( $container );</h5>' );
	$status = $test->Insert( $container );
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Create an existing document via native identifier.
	//
	echo( '<h4>Create an existing document via native identifier</h4>' );
	echo( '<h5>$lid = $test[ kOFFSET_NID ];</h5>' );
	$lid = $test[ kOFFSET_NID ];
	echo( '<pre>' ); print_r( $lid ); echo( '</pre>' );
	echo( '<h5>$other = CPersistentObject::NewObject( $container, $lid );</h5>' );
	$other = MyClass::NewObject( $container, $lid );
	echo( '<pre>' ); print_r( $other ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Create an existing document via global identifier.
	//
	echo( '<h4>Create an existing document via global identifier</h4>' );
	echo( '<h5>$gid = $test[ kOFFSET_GID ];</h5>' );
	$gid = $test[ kOFFSET_GID ];
	echo( "$gid<br />" );
	echo( '<h5>$lid = CPersistentObject::_id( $gid, $container );</h5>' );
	$lid = MyClass::_id( $gid, $container );
	echo( '<pre>' ); print_r( $lid ); echo( '</pre>' );
	echo( '<h5>$other = CPersistentObject::NewObject( $container, $lid );</h5>' );
	$other = MyClass::NewObject( $container, $lid );
	echo( '<pre>' ); print_r( $other ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );
}

//
// Catch exceptions.
//
catch( \Exception $error )
{
	echo( '<pre>'.(string) $error.'</pre>' );
	echo( '<hr>' );
}

echo( "\nDone!\n" );

?>
