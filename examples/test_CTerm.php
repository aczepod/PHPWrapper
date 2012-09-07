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
// Containers.
//
use MyWrapper\Persistence\CContainer;
use MyWrapper\Persistence\CMongoContainer;

//
// Class includes.
//
use MyWrapper\Ontology\CTerm;


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
	echo( '$mongo = New Mongo();<br />' );
	$mongo = New \Mongo();
	echo( '$db = $mongo->selectDB( "TEST" );<br />' );
	$db = $mongo->selectDB( "TEST" );
	$db->drop();
	echo( '$collection = $db->selectCollection( "CTerm" );<br />' );
	$collection = $db->selectCollection( "CTerm" );
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
	echo( '<h4>Insert initialized object</h4>' );
	echo( '<h5>$namespace[ kOFFSET_LID ] = "NAMESPACE";</h5>' );
	$namespace[ kOFFSET_LID ] = "NAMESPACE";
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
	echo( '<h5>$termA[ kOFFSET_NAMESPACE ] = $namespace;</h5>' );
	$termA[ kOFFSET_NAMESPACE ] = $namespace;
	echo( '<h5>$termA[ kOFFSET_LID ] = "A";</h5>' );
	$termA[ kOFFSET_LID ] = "A";
	echo( '<h5>$status = $termA->Insert( $container );</h5>' );
	$status = $termA->Insert( $container );
	echo( 'Inited['.$termA->inited()
				   .'] Dirty['.$termA->dirty()
				   .'] Saved['.$termA->committed()
				   .'] Encoded['.$termA->encoded().']<br />' );
	echo( '<pre>' ); print_r( $termA ); echo( '</pre>' );
	echo( '<h5>$namespace = CTerm::NewObject( $container, $namespace[ kOFFSET_NID ] ); // Notice the namespace reference count</h5>' );
	$namespace = CTerm::NewObject( $container, $namespace[ kOFFSET_NID ] );
	echo( '<pre>' ); print_r( $namespace ); echo( '</pre>' );
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
	// Insert term and namespace.
	//
	echo( '<h4>Insert term and namespace</h4>' );
	echo( '<h5>$other_namespace = new MyClass();</h5>' );
	$other_namespace = new MyClass();
	echo( '<h5>$other_namespace[ kOFFSET_LID ] = "other namespace";</h5>' );
	$other_namespace[ kOFFSET_LID ] = "other namespace";
	echo( '<h5>$other_term = new MyClass();</h5>' );
	$other_term = new MyClass();
	echo( '<h5>$other_term[ kOFFSET_LID ] = "other_code";</h5>' );
	$other_term[ kOFFSET_LID ] = "other_code";
	echo( '<h5>$other_term[ kOFFSET_NAMESPACE ] = $other_namespace;</h5>' );
	$other_term[ kOFFSET_NAMESPACE ] = $other_namespace;
	echo( '<h5>$status = $other_term->Insert( $container );</h5>' );
	$status = $other_term->Insert( $container );
	echo( 'Inited['.$other_term->inited()
				   .'] Dirty['.$other_term->dirty()
				   .'] Saved['.$other_term->committed()
				   .'] Encoded['.$other_term->encoded().']<br />' );
	echo( 'Term<pre>' ); print_r( $other_term ); echo( '</pre>' );
	echo( 'namespace<pre>' ); print_r( $other_namespace ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Create term with namespace ID.
	//
	echo( '<h4>Create term with namespace ID</h4>' );
	echo( '<h5>$last_term = new MyClass();</h5>' );
	$last_term = new MyClass();
	echo( '<h5>$last_term[ kOFFSET_LID ] = "last_code";</h5>' );
	$last_term[ kOFFSET_LID ] = "last_code";
	echo( '<h5>$last_term[ kOFFSET_NAMESPACE ] = $namespace[ kOFFSET_NID ];</h5>' );
	$last_term[ kOFFSET_NAMESPACE ] = $namespace[ kOFFSET_NID ];
	echo( '<h5>$status = $last_term->Insert( $container );</h5>' );
	$status = $last_term->Insert( $container );
	echo( 'Inited['.$last_term->inited()
				   .'] Dirty['.$last_term->dirty()
				   .'] Saved['.$last_term->committed()
				   .'] Encoded['.$last_term->encoded().']<br />' );
	echo( '<pre>' ); print_r( $last_term ); echo( '</pre>' );
	echo( '<h5>$namespace = CTerm::NewObject( $container, $namespace[ kOFFSET_NID ] ); // Notice the namespace reference count</h5>' );
	$namespace = CTerm::NewObject( $container, $namespace[ kOFFSET_NID ] );
	echo( '<pre>' ); print_r( $namespace ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Create term with crap namespace.
	//
	try
	{
		echo( '<h4>Create term with crap namespace</h4>' );
		echo( '<h5>$crap_term = new MyClass();</h5>' );
		$crap_term = new MyClass();
		echo( '<h5>$crap_term[ kOFFSET_LID ] = "crap_code";</h5>' );
		$crap_term[ kOFFSET_LID ] = "crap_code";
		echo( '<h5>$crap_term[ kOFFSET_NAMESPACE ] = "should not find me";</h5>' );
		$crap_term[ kOFFSET_NAMESPACE ] = "should not find me";
		echo( '<h5>$status = $crap_term->Insert( $container );</h5>' );
		$status = $crap_term->Insert( $container );
		echo( '<h3><font color="red">Should have raised an exception</font></h3>' );
		echo( 'Inited['.$crap_term->inited()
					   .'] Dirty['.$crap_term->dirty()
					   .'] Saved['.$crap_term->committed()
					   .'] Encoded['.$crap_term->encoded().']<br />' );
		echo( '<pre>' ); print_r( $crap_term ); echo( '</pre>' );
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
