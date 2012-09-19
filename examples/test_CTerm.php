<?php

/**
 * {@link CTerm.php Base} object test suite.
 *
 * This file contains routines to test and demonstrate the behaviour of the
 * base object {@link CTerm class}.
 *
 *	@package	Test
 *	@subpackage	Framework
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 04/09/2012
 */

/*=======================================================================================
 *																						*
 *									test_CTerm.php										*
 *																						*
 *======================================================================================*/

//
// Global includes.
//
require_once( '/Library/WebServer/Library/PHPWrapper/includes.inc.php' );

//
// Class includes.
//
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CTerm.php" );


/*=======================================================================================
 *	TEST CLASS																			*
 *======================================================================================*/
 
//
// Test class definition.
//
class MyClass extends CTerm
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
		{	return $theDatabase->Container( "CTerm" );	}
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
	// Notes.
	//
	echo( '<h4>Object behaviour:</h4>' );
	echo( '<ul>' );
	echo( '<li>Base term object.' );
	echo( '</ul><hr>' );
	
	//
	// Create container.
	//
	echo( '<hr />' );
	echo( '<h4>Create test container</h4>' );
	echo( '$server = new CMongoServer();<br />' );
	$server = New CMongoServer();
	echo( '$db = $mongo->selectDB( "TEST" );<br />' );
	echo( '$database = $server->Database( "TEST" );<br />' );
	$database = $server->Database( "TEST" );
	echo( '$database->Drop();<br />' );
	$database->Drop();
	echo( '$container = $database->Container( "CTerm" );<br />' );
	$container = $database->Container( "CTerm" );
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
		echo( '<hr />' );
	}

	//
	// Insert unitialised object.
	//
	try
	{
		echo( '<h4>Insert uninitialized object</h4>' );
		echo( '<h5>$namespace = new MyClass();</h5>' );
		$namespace = new MyClass();
		echo( 'Inited['.$namespace->inited()
					   .'] Dirty['.$namespace->dirty()
					   .'] Saved['.$namespace->committed()
					   .'] Encoded['.$namespace->encoded().']<br />' );
		echo( '<h5>$status = $namespace->Insert( $container );</h5>' );
		$status = $namespace->Insert( $container );
		echo( '<h3><font color="red">Should have raised an exception</font></h3>' );
		echo( '<pre>' ); print_r( $namespace ); echo( '</pre>' );
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
	// Insert namespace term.
	//
	echo( '<h4>Insert namespace term</h4>' );
	echo( '<h5>$namespace = new MyClass();</h5>' );
	$namespace = new MyClass();
	echo( '<h5>$namespace->LID( "NAMESPACE" );</h5>' );
	$namespace->LID( "NAMESPACE" );
	echo( 'Inited['.$namespace->inited()
				   .'] Dirty['.$namespace->dirty()
				   .'] Saved['.$namespace->committed()
				   .'] Encoded['.$namespace->encoded().']<br />' );
	echo( '<h5>$status = $namespace->Insert( $container );</h5>' );
	$status = $namespace->Insert( $container );
	echo( '<pre>' ); print_r( $namespace ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Insert term A.
	//
	echo( '<h4>Insert term A</h4>' );
	echo( '<h5>$termA = new MyClass();</h5>' );
	$termA = new MyClass();
	echo( '<h5>$termA->NS( $namespace );</h5>' );
	$termA->NS( $namespace );
	echo( '<h5>$termA[ kOFFSET_LID ] = "A";</h5>' );
	$termA[ kOFFSET_LID ] = "A";
	echo( '<h5>$status = $termA->Insert( $container );</h5>' );
	$status = $termA->Insert( $container );
	echo( 'Inited['.$termA->inited()
				   .'] Dirty['.$termA->dirty()
				   .'] Saved['.$termA->committed()
				   .'] Encoded['.$termA->encoded().']<br />' );
	echo( '<pre>' ); print_r( $termA ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Test namespace lock.
	//
	try
	{
		echo( '<h4>Test namespace lock</h4>' );
		echo( '<h5>$termA[ kOFFSET_NAMESPACE ] = NULL;</h5>' );
		$termA[ kOFFSET_NAMESPACE ] = NULL;
		echo( '<h3><font color="red">Should have raised an exception</font></h3>' );
		echo( 'Inited['.$namespace->inited()
					   .'] Dirty['.$namespace->dirty()
					   .'] Saved['.$namespace->committed()
					   .'] Encoded['.$namespace->encoded().']<br />' );
		echo( '<pre>' ); print_r( $namespace ); echo( '</pre>' );
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
	// Test local identifier lock.
	//
	try
	{
		echo( '<h4>Test local identifier lock</h4>' );
		echo( '<h5>$termA[ kOFFSET_LID ] = "B";</h5>' );
		$termA[ kOFFSET_LID ] = "B";
		echo( '<h3><font color="red">Should have raised an exception</font></h3>' );
		echo( 'Inited['.$namespace->inited()
					   .'] Dirty['.$namespace->dirty()
					   .'] Saved['.$namespace->committed()
					   .'] Encoded['.$namespace->encoded().']<br />' );
		echo( '<pre>' ); print_r( $namespace ); echo( '</pre>' );
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
	// Insert term B.
	//
	echo( '<h4>Insert term B</h4>' );
	echo( '<h5>$termB = new MyClass();</h5>' );
	$termB = new MyClass();
	echo( '<h5>$termB->NS( (string) $namespace );</h5>' );
	$termB->NS( (string) $namespace );
	echo( '<h5>$termB[ kOFFSET_LID ] = "B";</h5>' );
	$termB[ kOFFSET_LID ] = "B";
	echo( '<h5>$status = $termB->Insert( $container );</h5>' );
	$status = $termB->Insert( $container );
	echo( 'Inited['.$termB->inited()
				   .'] Dirty['.$termB->dirty()
				   .'] Saved['.$termB->committed()
				   .'] Encoded['.$termB->encoded().']<br />' );
	echo( '<pre>' ); print_r( $termB ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Add default label.
	//
	echo( '<h4>Add default label</h4>' );
	echo( '<h5>$termB->Label( NULL, "Default label" );</h5>' );
	$termB->Label( NULL, "Default label" );
	echo( 'Inited['.$termB->inited()
				   .'] Dirty['.$termB->dirty()
				   .'] Saved['.$termB->committed()
				   .'] Encoded['.$termB->encoded().']<br />' );
	echo( '<pre>' ); print_r( $termB ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Add italian label.
	//
	echo( '<h4>Add italian label</h4>' );
	echo( '<h5>$termB->Label( "it", "Italian" );</h5>' );
	$termB->Label( "it", "Italian" );
	echo( 'Inited['.$termB->inited()
				   .'] Dirty['.$termB->dirty()
				   .'] Saved['.$termB->committed()
				   .'] Encoded['.$termB->encoded().']<br />' );
	echo( '<pre>' ); print_r( $termB ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Add english label.
	//
	echo( '<h4>Add english label</h4>' );
	echo( '<h5>$termB->Label( "en", "english" );</h5>' );
	$termB->Label( "en", "english" );
	echo( 'Inited['.$termB->inited()
				   .'] Dirty['.$termB->dirty()
				   .'] Saved['.$termB->committed()
				   .'] Encoded['.$termB->encoded().']<br />' );
	echo( '<pre>' ); print_r( $termB ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Retrieve italian label.
	//
	echo( '<h4>Retrieve italian label</h4>' );
	echo( '<h5>$label = $termB->Label( "it" );</h5>' );
	$label = $termB->Label( "it" );
	echo( '<pre>' ); print_r( $label ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Retrieve default label.
	//
	echo( '<h4>Retrieve default label</h4>' );
	echo( '<h5>$label = $termB->Label();</h5>' );
	$label = $termB->Label();
	echo( '<pre>' ); print_r( $label ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Delete english label.
	//
	echo( '<h4>Delete english label</h4>' );
	echo( '<h5>$termB->Label( "en", FALSE );</h5>' );
	$termB->Label( "en", FALSE );
	echo( '<pre>' ); print_r( $termB ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Delete default label.
	//
	echo( '<h4>Delete default label</h4>' );
	echo( '<h5>$termB->Label( NULL, FALSE );</h5>' );
	$termB->Label( NULL, FALSE );
	echo( '<pre>' ); print_r( $termB ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Delete italian label.
	//
	echo( '<h4>Delete italian label</h4>' );
	echo( '<h5>$termB->Label( "it", FALSE );</h5>' );
	$termB->Label( "it", FALSE );
	echo( '<pre>' ); print_r( $termB ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Add default description.
	//
	echo( '<h4>Add default description</h4>' );
	echo( '<h5>$termB->Description( NULL, "Default description" );</h5>' );
	$termB->Description( NULL, "Default description" );
	echo( '<pre>' ); print_r( $termB ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Set wrong description.
	//
	try
	{
		echo( '<h4>Set wrong description</h4>' );
		echo( '<h5>$termB[ kOFFSET_DESCRIPTION ] = "Description";</h5>' );
		$termB[ kOFFSET_DESCRIPTION ] = "Description";
		echo( '<h3><font color="red">Should have raised an exception</font></h3>' );
		echo( '<pre>' ); print_r( $namespace ); echo( '</pre>' );
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
	// Convert to string.
	//
	echo( '<h4>Convert to string</h4>' );
	echo( '<h5>$string = (string) $termB;</h5>' );
	$string = (string) $termB;
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
