<?php

/**
 * {@link CNode.php Base} object test suite.
 *
 * This file contains routines to test and demonstrate the behaviour of the
 * base object {@link CNode class}.
 *
 *	@package	Test
 *	@subpackage	Framework
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 04/09/2012
 */

/*=======================================================================================
 *																						*
 *									test_CNode.php										*
 *																						*
 *======================================================================================*/

//
// Global includes.
//
require_once( 'includes.inc.php' );

//
// Class includes.
//
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CNode.php" );


/*=======================================================================================
 *	TEST CLASS																			*
 *======================================================================================*/
 
//
// Test class definition.
//
class MyClass extends CNode
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
	echo( '$term_container = $database->Container( "CTerm" );<br />' );
	$term_container = $database->Container( "CTerm" );
	echo( '$node_container = $database->Container( "CNode" );<br />' );
	$node_container = $database->Container( "CNode" );
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
	// Create namespace term.
	//
	echo( '<h4>Create namespace term</h4>' );
	$namespace = new CTerm();
	$namespace[ kTAG_LID ] = "NAMESPACE";
	$status = $namespace->Insert( $term_container );
	echo( '<pre>' ); print_r( $namespace ); echo( '</pre>' );
	
	//
	// Create term A.
	//
	echo( '<h4>Create term A</h4>' );
	$termA = new CTerm();
	$termA[ kTAG_NAMESPACE ] = $namespace;
	$termA[ kTAG_LID ] = "A";
	$status = $termA->Insert( $term_container );
	echo( '<pre>' ); print_r( $termA ); echo( '</pre>' );
	
	//
	// Create term B.
	//
	echo( '<h4>Create term B</h4>' );
	$termB = new CTerm();
	$termB[ kTAG_NAMESPACE ] = $namespace;
	$termB[ kTAG_LID ] = "B";
	$status = $termB->Insert( $term_container );
	echo( '<pre>' ); print_r( $termB ); echo( '</pre>' );
	
	//
	// Create term C.
	//
	echo( '<h4>Create term C</h4>' );
	$termC = new CTerm();
	$termC[ kTAG_NAMESPACE ] = $namespace;
	$termC[ kTAG_LID ] = "C";
	$status = $termC->Insert( $term_container );
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
		echo( '<h5>$status = $namespace->Insert( $node_container );</h5>' );
		$status = $node->Insert( $node_container );
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
	echo( '<h5>$status = $node->Insert( $node_container );</h5>' );
	$status = $node->Insert( $node_container );
	echo( '<pre>' ); print_r( $node ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr>' );
	
	//
	// Add kind 1.
	//
	echo( '<h4>Add kind 1</h4>' );
	echo( '<h5>$node->Kind( $termA, TRUE );</h5>' );
	$node->Kind( $termA, TRUE );
	echo( 'Inited['.$node->inited()
				   .'] Dirty['.$node->dirty()
				   .'] Saved['.$node->committed()
				   .'] Encoded['.$node->encoded().']<br />' );
	echo( '<h5>$status = $node->Replace( $node_container );</h5>' );
	$status = $node->Replace( $node_container );
	echo( '<pre>' ); print_r( $node ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Add kind 2.
	//
	echo( '<h4>Add kind 2</h4>' );
	echo( '<h5>$node->Kind( $termB, TRUE );</h5>' );
	$node->Kind( $termB, TRUE );
	echo( 'Inited['.$node->inited()
				   .'] Dirty['.$node->dirty()
				   .'] Saved['.$node->committed()
				   .'] Encoded['.$node->encoded().']<br />' );
	echo( '<h5>$status = $node->Replace( $node_container );</h5>' );
	$status = $node->Replace( $node_container );
	echo( '<pre>' ); print_r( $node ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Add kind 1.
	//
	echo( '<h4>Add kind 1</h4>' );
	echo( '<h5>$node->Kind( $termA, TRUE );</h5>' );
	$node->Kind( $termA, TRUE );
	echo( 'Inited['.$node->inited()
				   .'] Dirty['.$node->dirty()
				   .'] Saved['.$node->committed()
				   .'] Encoded['.$node->encoded().']<br />' );
	echo( '<h5>$status = $node->Replace( $node_container );</h5>' );
	$status = $node->Replace( $node_container );
	echo( '<pre>' ); print_r( $node ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Remove kind 2.
	//
	echo( '<h4>Remove kind 2</h4>' );
	echo( '<h5>$node->Kind( $termB, FALSE );</h5>' );
	$node->Kind( $termB, FALSE );
	echo( 'Inited['.$node->inited()
				   .'] Dirty['.$node->dirty()
				   .'] Saved['.$node->committed()
				   .'] Encoded['.$node->encoded().']<br />' );
	echo( '<h5>$status = $node->Replace( $node_container );</h5>' );
	$status = $node->Replace( $node_container );
	echo( '<pre>' ); print_r( $node ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Remove kind 1.
	//
	echo( '<h4>Remove kind 1</h4>' );
	echo( '<h5>$node->Kind( $termA, FALSE );</h5>' );
	$node->Kind( $termA, FALSE );
	echo( 'Inited['.$node->inited()
				   .'] Dirty['.$node->dirty()
				   .'] Saved['.$node->committed()
				   .'] Encoded['.$node->encoded().']<br />' );
	echo( '<h5>$status = $node->Replace( $node_container );</h5>' );
	$status = $node->Replace( $node_container );
	echo( '<pre>' ); print_r( $node ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Add data type.
	//
	echo( '<h4>Add data type</h4>' );
	echo( '<h5>$node->Type( kTYPE_STRING, TRUE );</h5>' );
	$node->Type( kTYPE_STRING, TRUE );
	echo( 'Inited['.$node->inited()
				   .'] Dirty['.$node->dirty()
				   .'] Saved['.$node->committed()
				   .'] Encoded['.$node->encoded().']<br />' );
	echo( '<h5>$status = $node->Replace( $node_container );</h5>' );
	$status = $node->Replace( $node_container );
	echo( '<pre>' ); print_r( $node ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Add required flag.
	//
	echo( '<h4>Add required flag</h4>' );
	echo( '<h5>$node->Type( kTYPE_CARD_REQUIRED, TRUE );</h5>' );
	$node->Type( kTYPE_CARD_REQUIRED, TRUE );
	echo( 'Inited['.$node->inited()
				   .'] Dirty['.$node->dirty()
				   .'] Saved['.$node->committed()
				   .'] Encoded['.$node->encoded().']<br />' );
	echo( '<h5>$status = $node->Replace( $node_container );</h5>' );
	$status = $node->Replace( $node_container );
	echo( '<pre>' ); print_r( $node ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Add list flag.
	//
	echo( '<h4>Add list flag</h4>' );
	echo( '<h5>$node->Type( kTYPE_CARD_ARRAY, TRUE );</h5>' );
	$node->Type( kTYPE_CARD_ARRAY, TRUE );
	echo( 'Inited['.$node->inited()
				   .'] Dirty['.$node->dirty()
				   .'] Saved['.$node->committed()
				   .'] Encoded['.$node->encoded().']<br />' );
	echo( '<h5>$status = $node->Replace( $node_container );</h5>' );
	$status = $node->Replace( $node_container );
	echo( '<pre>' ); print_r( $node ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr>' );

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
	echo( '<hr>' );

	//
	// Insert duplicate node.
	//
	try
	{
		echo( '<h4>Insert duplicate node</h4>' );
		echo( '<h5>$node->Kind( $termA, TRUE ); // To make object dirty</h5>' );
		$node->Kind( $termA, TRUE );
		echo( '<h5>$status = $node->Insert( $node_container );</h5>' );
		$status = $node->Insert( $node_container );
		echo( '<h3><font color="red">Should have raised an exception</font></h3>' );
		echo( 'Inited['.$node->inited()
					   .'] Dirty['.$node->dirty()
					   .'] Saved['.$node->committed()
					   .'] Encoded['.$node->encoded().']<br />' );
		echo( 'Object<pre>' ); print_r( $node ); echo( '</pre>' );
		echo( 'Status<pre>' ); print_r( $status ); echo( '</pre>' );
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
	// Add new node.
	//
	echo( '<h4>Add new node</h4>' );
	echo( '<h5>$node0 = new MyClass();</h5>' );
	$node0 = new MyClass();
	echo( '<h5>$node0[ kTAG_TERM ] = $termB;</h5>' );
	$node0[ kTAG_TERM ] = $termB;
	echo( 'Inited['.$node0->inited()
				   .'] Dirty['.$node0->dirty()
				   .'] Saved['.$node0->committed()
				   .'] Encoded['.$node0->encoded().']<br />' );
	echo( '<h5>$status = $node0->Replace( $node_container );</h5>' );
	$status = $node0->Replace( $node_container );
	echo( '<pre>' ); print_r( $node0 ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr>' );
	
	//
	// Create edge.
	//
	echo( '<h4>Create edge</h4>' );
	echo( '<h5>$edge = $node0->RelateTo( $node, $termA );</h5>' );
	$edge = $node0->RelateTo( $node, $termA );
	echo( '<pre>' ); print_r( $edge ); echo( '</pre>' );
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
