<?php

/**
 * {@link CTag.php Base} object test suite.
 *
 * This file contains routines to test and demonstrate the behaviour of the
 * base object {@link CTag class}.
 *
 *	@package	Test
 *	@subpackage	Framework
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 17/09/2012
 */

/*=======================================================================================
 *																						*
 *									test_CTag.php										*
 *																						*
 *======================================================================================*/

//
// Global includes.
//
require_once( 'includes.inc.php' );

//
// Class includes.
//
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CTag.php" );


/*=======================================================================================
 *	TEST CLASS																			*
 *======================================================================================*/
 
//
// Test class definition.
//
class MyClass extends CTag
{
	//
	// Utilities to show protected data.
	//
	public function inited()	{	return ( $this->_IsInited() ) ? 'Y' : 'N';		}
	public function dirty()		{	return ( $this->_IsDirty() ) ? 'Y' : 'N';		}
	public function committed()	{	return ( $this->_IsCommitted() ) ? 'Y' : 'N';	}
	public function encoded()	{	return ( $this->_IsEncoded() ) ? 'Y' : 'N';		}
}


/*=======================================================================================
 *	RUNTIME SETTINGS																	*
 *======================================================================================*/
 
//
// Debug switches.
//
define( 'kDEBUG_PARENT', TRUE );


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
	echo( '$server = new CMongoServer();<br />' );
	$server = New CMongoServer();
	echo( '$database = $server->Database( "TEST" );<br />' );
	$database = $server->Database( "TEST" );
	echo( '$database->Drop();<br />' );
	$database->Drop();
	echo( '$container = $database->Container( "CTag" );<br />' );
	$container = $database->Container( "CTag" );
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
		// Test other offsets.
		//
		echo( '<h4>Test array offset access</h4>' );
		echo( '<h5>$test[ \'C\' ][ 1 ];</h5>' );
		echo( '<pre>' ); print_r( $test[ 'C' ][ 1 ] ); echo( '</pre>' );
		echo( '<hr />' );
	}
	
	//
	// Insert unitialised object.
	//
	try
	{
		echo( '<h4>Insert uninitialized object</h4>' );
		echo( '<h5>$tag = new MyClass();</h5>' );
		$tag = new MyClass();
		echo( '<h5>$status = $namespace->Insert( $container );</h5>' );
		$status = $tag->Insert( $container );
		echo( '<h3><font color="red">Should have raised an exception</font></h3>' );
		echo( '<pre>' ); print_r( $tag ); echo( '</pre>' );
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
	// Insert tag with one itemed path.
	//
	echo( '<h4>Insert tag with one itemed path</h4>' );
	echo( '<h5>$tag = new MyClass();</h5>' );
	$tag = new MyClass();
	echo( '<h5>$tag->PushItem( "First" );</h5>' );
	$tag->PushItem( "First" );
	echo( 'Inited['.$tag->inited()
				   .'] Dirty['.$tag->dirty()
				   .'] Saved['.$tag->committed()
				   .'] Encoded['.$tag->encoded().']<br />' );
	echo( '<h5>$status = $tag->Insert( $container );</h5>' );
	$status = $tag->Insert( $container );
	echo( '<pre>' ); print_r( $tag ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Append second item to path.
	//
	try
	{
		echo( '<h4>Append second item to path</h4>' );
		echo( '<h5>$tag = new MyClass();</h5>' );
		$tag = new MyClass();
		echo( '<h5>$tag->PushItem( "First" );</h5>' );
		$tag->PushItem( "First" );
		echo( '<h5>$tag->PushItem( "Second" );</h5>' );
		$tag->PushItem( "Second" );
		echo( '<h5>$status = $tag->Insert( $container );</h5>' );
		$status = $tag->Insert( $container );
		echo( '<h3><font color="red">Should have raised an exception</font></h3>' );
		echo( '<pre>' ); print_r( $tag ); echo( '</pre>' );
		echo( '<hr />' );
	}
	catch( \Exception $error )
	{
		echo( '<h5>Expected exception</h5>' );
		echo( '<pre>'.(string) $error.'</pre>' );
		echo( '<hr>' );
	}
	
	//
	// Append third item to path.
	//
	echo( '<h4>Append third item to path</h4>' );
	echo( '<h5>$tag->PushItem( "Third" );</h5>' );
	$tag->PushItem( "Third" );
	echo( '<h5>$tag->Category( array( "categort1", "category2" ), TRUE );</h5>' );
	$tag->Category( array( "categort1", "category2" ), TRUE );
	echo( '<h5>$tag->Kind( "kind1", TRUE );</h5>' );
	$tag->Kind( "kind1", TRUE );
	echo( '<h5>$tag->Kind( "kind2", TRUE );</h5>' );
	$tag->Kind( "kind2", TRUE );
	echo( '<h5>$tag->Type( array( "type1", "type2" ), TRUE );</h5>' );
	$tag->Type( array( "type1", "type2" ), TRUE );
	echo( '<h5>$tag->Input( array( kINPUT_CHOICE, kINPUT_RADIO ), TRUE );</h5>' );
	$tag->Input( array( kINPUT_CHOICE, kINPUT_RADIO ), TRUE );
	echo( '<h5>$tag->Pattern( "[A-Z]+" );</h5>' );
	$tag->Pattern( "[A-Z]+" );
	echo( '<h5>$tag->Length( 24 );</h5>' );
	$tag->Length( 24 );
	echo( '<h5>$tag->LowerBound( 100.5 );</h5>' );
	$tag->LowerBound( 100.5 );
	echo( '<h5>$tag->UpperBound( 123 );</h5>' );
	$tag->UpperBound( 123 );
	echo( '<h5>$tag->Example( 105.7, TRUE );</h5>' );
	$tag->Example( 105.7, TRUE );
	echo( '<h5>$tag->Example( "babaluna", TRUE );</h5>' );
	$tag->Example( "babaluna", TRUE );
	echo( 'Inited['.$tag->inited()
				   .'] Dirty['.$tag->dirty()
				   .'] Saved['.$tag->committed()
				   .'] Encoded['.$tag->encoded().']<br />' );
	echo( '<h5>$status = $tag->Insert( $container );</h5>' );
	$status = $tag->Insert( $container );
	echo( '<pre>' ); print_r( $tag ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );

	//
	// Convert to string.
	//
	echo( '<h4>Convert to string</h4>' );
	echo( '<h5>$string = (string) $tag;</h5>' );
	$string = (string) $tag;
	echo( '<pre>' ); print_r( $string ); echo( '</pre>' );
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
