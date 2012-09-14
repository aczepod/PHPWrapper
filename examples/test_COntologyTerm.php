<?php

/**
 * {@link COntologyTerm.php Base} object test suite.
 *
 * This file contains routines to test and demonstrate the behaviour of the
 * base object {@link COntologyTerm class}.
 *
 *	@package	Test
 *	@subpackage	Framework
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 04/09/2012
 */

/*=======================================================================================
 *																						*
 *								test_COntologyTerm.php									*
 *																						*
 *======================================================================================*/

//
// Global includes.
//
require_once( '/Library/WebServer/Library/PHPWrapper/includes.inc.php' );

//
// Class includes.
//
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/COntologyTerm.php" );


/*=======================================================================================
 *	TEST CLASS																			*
 *======================================================================================*/
 
//
// Test class definition.
//
class MyClass extends COntologyTerm
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
	echo( '$container = COntologyTerm::DefaultContainer( $database );<br />' );
	$container = COntologyTerm::DefaultContainer( $database );
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
		echo( '<h5>$namespace = $termA->LoadNamespace( $container, TRUE ); // Notice the namespace reference count</h5>' );
		$namespace = $termA->LoadNamespace( $container, TRUE );
		echo( '<pre>' ); print_r( $namespace ); echo( '</pre>' );
		echo( '<hr />' );
		
		//
		// Insert term B with new namespace.
		//
		echo( '<h4>Insert term B with new namespace</h4>' );
		echo( '<h5>$namespace_bis = new MyClass();</h5>' );
		$namespace_bis = new MyClass();
		echo( '<h5>$namespace_bis->LID( "MY-NAMESPACE" );</h5>' );
		$namespace_bis->LID( "MY-NAMESPACE" );
		echo( '<h5>$termB = new MyClass();</h5>' );
		$termB = new MyClass();
		echo( '<h5>$termB->NS( $namespace_bis );</h5>' );
		$termB->NS( $namespace_bis );
		echo( '<h5>$termB->LID( "B" );</h5>' );
		$termB->LID( "B" );
		echo( 'Before commit<pre>' ); print_r( $termB ); echo( '</pre>' );
		echo( '<h5>$status = $termB->Insert( $container );</h5>' );
		$status = $termB->Insert( $container );
		echo( 'Inited['.$termB->inited()
					   .'] Dirty['.$termB->dirty()
					   .'] Saved['.$termB->committed()
					   .'] Encoded['.$termB->encoded().']<br />' );
		echo( 'After commit<pre>' ); print_r( $termB ); echo( '</pre>' );
		echo( '<h5>$namespace_bis = $termB->LoadNamespace( $container, TRUE ); // Notice the namespace reference count</h5>' );
		$namespace_bis = $termB->LoadNamespace( $container, TRUE );
		echo( 'Namespace<pre>' ); print_r( $namespace_bis ); echo( '</pre>' );
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
			echo( 'Inited['.$termA->inited()
						   .'] Dirty['.$termA->dirty()
						   .'] Saved['.$termA->committed()
						   .'] Encoded['.$termA->encoded().']<br />' );
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
			echo( 'Inited['.$termA->inited()
						   .'] Dirty['.$termA->dirty()
						   .'] Saved['.$termA->committed()
						   .'] Encoded['.$termA->encoded().']<br />' );
			echo( '<pre>' ); print_r( $termA ); echo( '</pre>' );
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
		// Test wrong namespace type.
		//
		try
		{
			echo( '<h4>Test wrong namespace type</h4>' );
			echo( '<h5>$namespace_tris = new CPersistentObject;</h5>' );
			$namespace_tris = new CPersistentObject();
			echo( '<h5>$namespace_tris[ kOFFSET_LID ] = "GAGA";</h5>' );
			$namespace_tris[ kOFFSET_LID ] = "GAGA";
			echo( '<h5>$termC = new MyClass();</h5>' );
			$termC = new MyClass();
			echo( '<h5>$termC->NS( $namespace_tris );</h5>' );
			$termC->NS( $namespace_tris );
			echo( '<h3><font color="red">Should have raised an exception</font></h3>' );
			echo( 'Inited['.$termC->inited()
						   .'] Dirty['.$termC->dirty()
						   .'] Saved['.$termC->committed()
						   .'] Encoded['.$termC->encoded().']<br />' );
			echo( '<pre>' ); print_r( $termC ); echo( '</pre>' );
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
	// Create term with namespace ID from database.
	//
	echo( '<h4>Create term with namespace ID from database</h4>' );
	echo( '<h5>$last_term = new MyClass();</h5>' );
	$last_term = new MyClass();
	echo( '<h5>$last_term[ kOFFSET_LID ] = "last_code";</h5>' );
	$last_term[ kOFFSET_LID ] = "last_code";
	echo( '<h5>$last_term[ kOFFSET_NAMESPACE ] = $namespace[ kOFFSET_NID ];</h5>' );
	$last_term[ kOFFSET_NAMESPACE ] = $namespace[ kOFFSET_NID ];
	echo( '<h5>$status = $last_term->Insert( $database );</h5>' );
	$status = $last_term->Insert( $database );
	echo( 'Inited['.$last_term->inited()
				   .'] Dirty['.$last_term->dirty()
				   .'] Saved['.$last_term->committed()
				   .'] Encoded['.$last_term->encoded().']<br />' );
	echo( '<pre>' ); print_r( $last_term ); echo( '</pre>' );
	echo( '<h5>$namespace = COntologyTerm::NewObject( COntologyTerm::DefaultContainer( $database ), $namespace[ kOFFSET_NID ] ); // Notice the namespace reference count</h5>' );
	$namespace = COntologyTerm::NewObject( COntologyTerm::DefaultContainer( $database ), $namespace[ kOFFSET_NID ] );
	echo( '<pre>' ); print_r( $namespace ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Test modifying namespace counter.
	//
	try
	{
		echo( '<h4>Test modifying namespace counter</h4>' );
		echo( '<h5>$last_term[ kOFFSET_REFS_NAMESPACE ] = 24;</h5>' );
		$last_term[ kOFFSET_REFS_NAMESPACE ] = 24;
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

	//
	// Test modifying node list.
	//
	try
	{
		echo( '<h4>Test modifying node list</h4>' );
		echo( '<h5>$last_term[ kOFFSET_REFS_NODE ] = 24;</h5>' );
		$last_term[ kOFFSET_REFS_NODE ] = 24;
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

	//
	// Test modifying tag list.
	//
	try
	{
		echo( '<h4>Test modifying tag list</h4>' );
		echo( '<h5>$last_term[ kOFFSET_REFS_TAG ] = 24;</h5>' );
		$last_term[ kOFFSET_REFS_TAG ] = 24;
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
