<?php

/**
 * {@link COntologyNode.php Base} object test suite.
 *
 * This file contains routines to test and demonstrate the behaviour of the
 * base object {@link COntologyNode class}.
 *
 *	@package	Test
 *	@subpackage	Framework
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 04/09/2012
 */

/*=======================================================================================
 *																						*
 *								test_COntologyNode.php									*
 *																						*
 *======================================================================================*/

//
// Global includes.
//
require_once( 'includes.inc.php' );

//
// Class includes.
//
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/COntologyNode.php" );


/*=======================================================================================
 *	TEST CLASS																			*
 *======================================================================================*/
 
//
// Test class definition.
//
class MyClass extends COntologyNode
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
//	echo( '$server->Graph( new CNeo4jGraph() );<br />' );
//	$server->Graph( new CNeo4jGraph() );
	echo( '$database = $server->Database( "TEST" );<br />' );
	$database = $server->Database( "TEST" );
	echo( '$database->Drop();<br />' );
	$database->Drop();
	echo( '$container = COntologyNode::DefaultContainer( $database );<br />' );
	$container = COntologyNode::DefaultContainer( $database );
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
	// Instantiate namespace term.
	//
	echo( '<h4>Instantiate namespace term</h4>' );
	$namespace = new COntologyTerm();
	$namespace[ kTAG_LID ] = "NAMESPACE";
//	$status = $namespace->Insert( $database );
	echo( '<pre>' ); print_r( $namespace ); echo( '</pre>' );
	
	//
	// Instantiate term A.
	//
	echo( '<h4>Instantiate term A</h4>' );
	$termA = new COntologyTerm();
	$termA[ kTAG_NAMESPACE ] = $namespace;
	$termA[ kTAG_LID ] = "A";
//	$status = $termA->Insert( $database );
	echo( '<pre>' ); print_r( $termA ); echo( '</pre>' );
	
	//
	// Instantiate term B.
	//
	echo( '<h4>Instantiate term B</h4>' );
	$termB = new COntologyTerm();
	$termB[ kTAG_NAMESPACE ] = $namespace;
	$termB[ kTAG_LID ] = "B";
//	$status = $termB->Insert( $database );
	echo( '<pre>' ); print_r( $termB ); echo( '</pre>' );
	
	//
	// Create term C.
	//
	echo( '<h4>Create term C</h4>' );
	$termC = new COntologyTerm();
	$termC[ kTAG_NAMESPACE ] = $namespace;
	$termC[ kTAG_LID ] = "C";
	$status = $termC->Insert( $database );
	echo( '<pre>' ); print_r( $termC ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );

	//
	// Insert unitialised object.
	//
	try
	{
		echo( '<h4>Insert uninitialized object</h4>' );
		echo( '<h5>$node = new MyClass();</h5>' );
		$node = new MyClass();
		echo( '<h5>$status = $node->Insert( $container );</h5>' );
		$status = $node->Insert( $container );
		echo( '<h3><font color="red">Should have raised an exception</font></h3>' );
		echo( '<pre>' ); print_r( $node ); echo( '</pre>' );
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
	// Insert node with term.
	//
	echo( '<h4>Insert node with term</h4>' );
	echo( '<h5>$node[ kTAG_TERM ] = $termA;</h5>' );
	$node[ kTAG_TERM ] = $termA;
	echo( 'Inited['.$node->inited()
				   .'] Dirty['.$node->dirty()
				   .'] Saved['.$node->committed()
				   .'] Encoded['.$node->encoded().']<br />' );
	echo( 'Before insert<pre>' ); print_r( $node ); echo( '</pre>' );
	echo( '<h5>$status = $node->Insert( $database );</h5>' );
	$status = $node->Insert( $database );
	echo( 'After insert<pre>' ); print_r( $node ); echo( '</pre>' );
	echo( '<h5>$term = $node->LoadTerm( $database, TRUE ); // Notice node reference.</h5>' );
	$term = $node->LoadTerm( $database, TRUE );
	echo( 'Term<pre>' ); print_r( $term ); echo( '</pre>' );
	echo( '<h5>$namespace = $term->LoadNamespace( $database, TRUE ); // Notice namespace reference.</h5>' );
	$namespace = $term->LoadNamespace( $database, TRUE );
	echo( 'Namespace<pre>' ); print_r( $namespace ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr>' );
	
	//
	// Add kind 1.
	//
	echo( '<h4>Add kind 1</h4>' );
	echo( '<h5>$node->Kind( "KIND1", TRUE );</h5>' );
	$node->Kind( "KIND1", TRUE );
	echo( '<pre>' ); print_r( $node ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Add kind 2.
	//
	echo( '<h4>Add kind 2</h4>' );
	echo( '<h5>$node->Kind( "KIND2", TRUE );</h5>' );
	$node->Kind( "KIND2", TRUE );
	echo( '<pre>' ); print_r( $node ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Add kind 1.
	//
	echo( '<h4>Add kind 1</h4>' );
	echo( '<h5>$node->Kind( "KIND1", TRUE );</h5>' );
	$node->Kind( "KIND1", TRUE );
	echo( '<pre>' ); print_r( $node ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Remove kind 2.
	//
	echo( '<h4>Remove kind 2</h4>' );
	echo( '<h5>$node->Kind( "KIND2", FALSE );</h5>' );
	$node->Kind( "KIND2", FALSE );
	echo( '<pre>' ); print_r( $node ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Remove kind 1.
	//
	echo( '<h4>Remove kind 1</h4>' );
	echo( '<h5>$node->Kind( "KIND1", FALSE );</h5>' );
	$node->Kind( "KIND1", FALSE );
	echo( '<pre>' ); print_r( $node ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Add string data type.
	//
	echo( '<h4>Add string data type</h4>' );
	echo( '<h5>$node->Type( kTYPE_STRING, TRUE );</h5>' );
	$node->Type( kTYPE_STRING, TRUE );
	echo( '<pre>' ); print_r( $node ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Add required cardinality.
	//
	echo( '<h4>Add required cardinality</h4>' );
	echo( '<h5>$node->Type( kTYPE_CARD_REQUIRED, TRUE );</h5>' );
	$node->Type( kTYPE_CARD_REQUIRED, TRUE );
	echo( '<pre>' ); print_r( $node ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Add array cardinality.
	//
	echo( '<h4>Add array cardinality</h4>' );
	echo( '<h5>$node->Type( kTYPE_CARD_ARRAY, TRUE );</h5>' );
	$node->Type( kTYPE_CARD_ARRAY, TRUE );
	echo( '<pre>' ); print_r( $node ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Add float data type.
	//
	echo( '<h4>Add float data type</h4>' );
	echo( '<h5>$node->Type( kTYPE_FLOAT, TRUE );</h5>' );
	$node->Type( kTYPE_FLOAT, TRUE );
	echo( '<pre>' ); print_r( $node ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr>' );

	//
	// Insert wrong term.
	//
	try
	{
		echo( '<h4>Insert wrong term</h4>' );
		echo( '<h5>$node[ kTAG_TERM ] = "pippo";</h5>' );
		$node[ kTAG_TERM ] = "pippo";
		echo( '<h3><font color="red">Should have raised an exception</font></h3>' );
		echo( '<pre>' ); print_r( $node ); echo( '</pre>' );
		echo( '<hr />' );
	}
	catch( \Exception $error )
	{
		echo( '<h5>Expected exception</h5>' );
		echo( '<pre>'.(string) $error.'</pre>' );
		echo( '<hr>' );
	}

	//
	// Insert wrong term type.
	//
	try
	{
		echo( '<h4>Insert wrong term type</h4>' );
		echo( '<h5>$node[ kTAG_TERM ] = $node;</h5>' );
		$node[ kTAG_TERM ] = $node;
		echo( '<h3><font color="red">Should have raised an exception</font></h3>' );
		echo( '<pre>' ); print_r( $node ); echo( '</pre>' );
		echo( '<hr />' );
	}
	catch( \Exception $error )
	{
		echo( '<h5>Expected exception</h5>' );
		echo( '<pre>'.(string) $error.'</pre>' );
		echo( '<hr>' );
	}

	//
	// Insert wrong kind.
	//
	try
	{
		echo( '<h4>Insert wrong kind</h4>' );
		echo( '<h5>$node[ kTAG_KIND ] = "pippo";</h5>' );
		$node[ kTAG_KIND ] = "pippo";
		echo( '<h3><font color="red">Should have raised an exception</font></h3>' );
		echo( '<pre>' ); print_r( $node ); echo( '</pre>' );
		echo( '<hr />' );
	}
	catch( \Exception $error )
	{
		echo( '<h5>Expected exception</h5>' );
		echo( '<pre>'.(string) $error.'</pre>' );
		echo( '<hr>' );
	}
	
	//
	// Delete node.
	//
	echo( '<h4>Delete node</h4>' );
	echo( '<h5>$status = $node->Delete( $database );</h5>' );
	$status = $node->Delete( $database );
	echo( 'Inited['.$node->inited()
				   .'] Dirty['.$node->dirty()
				   .'] Saved['.$node->committed()
				   .'] Encoded['.$node->encoded().']<br />' );
	echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
	echo( 'Node<pre>' ); print_r( $node ); echo( '</pre>' );
	echo( '<h5>$term = $node->LoadTerm( $database, TRUE ); // Notice node reference.</h5>' );
	$term = $node->LoadTerm( $database, TRUE );
	echo( 'Term<pre>' ); print_r( $term ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr>' );
	
	//
	// Insert new node.
	//
	echo( '<h4>Insert new node</h4>' );
	echo( '<h5>$node = new MyClass();</h5>' );
	$node = new MyClass();
	echo( '<h5>$node[ kTAG_TERM ] = $termA;</h5>' );
	$node[ kTAG_TERM ] = $termA;
	echo( 'Inited['.$node->inited()
				   .'] Dirty['.$node->dirty()
				   .'] Saved['.$node->committed()
				   .'] Encoded['.$node->encoded().']<br />' );
	echo( '<h5>$status = $node->Insert( $container );</h5>' );
	$status = $node->Insert( $container );
	echo( 'Node<pre>' ); print_r( $node ); echo( '</pre>' );
	echo( '<h5>$term = $node->LoadTerm( $database, TRUE ); // Notice node reference.</h5>' );
	$term = $node->LoadTerm( $database, TRUE );
	echo( 'Term<pre>' ); print_r( $term ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Insert another node with same term.
	//
	echo( '<h4>Insert another node with same term</h4>' );
	echo( '<h5>$node = new MyClass();</h5>' );
	$node = new MyClass();
	echo( '<h5>$node[ kTAG_TERM ] = $termA;</h5>' );
	$node[ kTAG_TERM ] = $termA;
	echo( 'Inited['.$node->inited()
				   .'] Dirty['.$node->dirty()
				   .'] Saved['.$node->committed()
				   .'] Encoded['.$node->encoded().']<br />' );
	echo( '<h5>$status = $node->Insert( $container );</h5>' );
	$status = $node->Insert( $container );
	echo( 'Node<pre>' ); print_r( $node ); echo( '</pre>' );
	echo( '<h5>$term = $node->LoadTerm( $database, TRUE ); // Notice node reference.</h5>' );
	$term = $node->LoadTerm( $database, TRUE );
	echo( 'Term<pre>' ); print_r( $term ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr>' );

	//
	// Convert to string.
	//
	echo( '<h4>Convert to string</h4>' );
	echo( '<h5>$string = (string) $node;</h5>' );
	$string = (string) $node;
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
