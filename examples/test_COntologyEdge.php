<?php

/**
 * {@link COntologyEdge.php Base} object test suite.
 *
 * This file contains routines to test and demonstrate the behaviour of the
 * base object {@link COntologyEdge class}.
 *
 *	@package	Test
 *	@subpackage	Framework
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 04/09/2012
 */

/*=======================================================================================
 *																						*
 *								test_COntologyEdge.php									*
 *																						*
 *======================================================================================*/

//
// Global includes.
//
require_once( 'includes.inc.php' );

//
// Class includes.
//
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/COntologyEdge.php" );


/*=======================================================================================
 *	TEST CLASS																			*
 *======================================================================================*/
 
//
// Test class definition.
//
class MyClass extends COntologyEdge
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
	echo( '$edge_container = COntologyEdge::ResolveContainer( $database, TRUE );<br />' );
	$edge_container = COntologyEdge::ResolveContainer( $database, TRUE );
	echo( '$node_container = COntologyNode::ResolveContainer( $database, TRUE );<br />' );
	$node_container = COntologyNode::ResolveContainer( $database, TRUE );
	echo( '$term_container = COntologyTerm::ResolveContainer( $database, TRUE );<br />' );
	$term_container = COntologyTerm::ResolveContainer( $database, TRUE );
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
		echo( '<h5>$test[ "A" ] = "a";</h5>' );
		$test[ "A" ] = "a";
		echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
		echo( '<h5>$test[ "B" ] = 2;</h5>' );
		$test[ "B" ] = 2;
		echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
		echo( '<h5>$test[ "C" ] = array( 1, 2, 3 );</h5>' );
		$test[ "C" ] = array( 1, 2, 3 );
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
		// Create namespace term.
		//
		echo( '<h4>Create namespace term</h4>' );
		$namespace = new COntologyTerm();
		$namespace[ kTAG_LID ] = "NAMESPACE";
//		$status = $namespace->Insert( $term_container );
		echo( '<pre>' ); print_r( $namespace ); echo( '</pre>' );
		
		//
		// Create term A.
		//
		echo( '<h4>Create term A</h4>' );
		$termA = new COntologyTerm();
		$termA[ kTAG_NAMESPACE ] = $namespace;
		$termA[ kTAG_LID ] = "A";
//		$status = $termA->Insert( $term_container );
		echo( '<pre>' ); print_r( $termA ); echo( '</pre>' );
		
		//
		// Create term B.
		//
		echo( '<h4>Create term B</h4>' );
		$termB = new COntologyTerm();
		$termB[ kTAG_NAMESPACE ] = $namespace;
		$termB[ kTAG_LID ] = "B";
//		$status = $termB->Insert( $term_container );
		echo( '<pre>' ); print_r( $termB ); echo( '</pre>' );
		
		//
		// Create term C.
		//
		echo( '<h4>Create term C</h4>' );
		$termC = new COntologyTerm();
		$termC[ kTAG_NAMESPACE ] = $namespace;
		$termC[ kTAG_LID ] = "C";
//		$status = $termC->Insert( $term_container );
		echo( '<pre>' ); print_r( $termC ); echo( '</pre>' );
		echo( '<hr />' );
		
		//
		// Create node A.
		//
		echo( '<h4>Create node A</h4>' );
		$nodeA = new COntologyNode();
		$nodeA->Term( $termA );
//		$status = $nodeA->Insert( $node_container );
		echo( '<pre>' ); print_r( $nodeA ); echo( '</pre>' );
		echo( '<hr />' );
		
		//
		// Create node B.
		//
		echo( '<h4>Create node B</h4>' );
		$nodeB = new COntologyNode();
		$nodeB->Term( $termB );
//		$status = $nodeB->Insert( $node_container );
		echo( '<pre>' ); print_r( $nodeB ); echo( '</pre>' );
		echo( '<hr />' );
		
		//
		// Create node C.
		//
		echo( '<h4>Create node C</h4>' );
		$nodeC = new COntologyNode();
		$nodeC->Term( $termC );
//		$status = $nodeC->Insert( $node_container );
		echo( '<pre>' ); print_r( $nodeC ); echo( '</pre>' );
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
		$edge = new MyClass();
		echo( 'Inited['.$edge->inited()
					   .'] Dirty['.$edge->dirty()
					   .'] Saved['.$edge->committed()
					   .'] Encoded['.$edge->encoded().']<br />' );
		echo( '<h5>$status = $edge->Insert( $edge_container );</h5>' );
		$status = $edge->Insert( $edge_container );
		echo( '<h3><font color="red">Should have raised an exception</font></h3>' );
		echo( '<pre>' ); print_r( $edge ); echo( '</pre>' );
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
	// Insert edge with objects.
	//
	echo( '<h4>Insert edge with objects</h4>' );
	echo( '<h5>$edge = new MyClass();</h5>' );
	$edge = new MyClass();
	echo( '<h5>$edge->Subject( $nodeA );</h5>' );
	$edge->Subject( $nodeA );
	echo( '<h5>$edge->Predicate( $termC );</h5>' );
	$edge->Predicate( $termC );
	echo( '<h5>$edge->Object( $nodeB );</h5>' );
	$edge->Object( $nodeB );
	echo( 'Inited['.$edge->inited()
				   .'] Dirty['.$edge->dirty()
				   .'] Saved['.$edge->committed()
				   .'] Encoded['.$edge->encoded().']<br />' );
	echo( '<h5>$status = $edge->Insert( $edge_container );</h5>' );
	$status = $edge->Insert( $edge_container );
	echo( '<i>Edge</i><pre>' ); print_r( $edge ); echo( '</pre>' );
	echo( '<i>Subject</i><pre>' ); print_r( $nodeA = $edge->LoadSubject( $database ) ); echo( '</pre>' );
	echo( '<i>Predicate</i><pre>' ); print_r( $termC = $edge->LoadPredicate( $edge_container ) ); echo( '</pre>' );
	echo( '<i>Object</i><pre>' ); print_r( $nodeB = $edge->LoadObject( $database ) ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Insert duplicate edge with identifiers.
	//
	try
	{
		echo( '<h4>Insert duplicate edge with identifiers</h4>' );
		echo( '<h4><i>Note that we may implement duplicates check by setting the '
			 .'</i></h4>' );
		echo( '<h4>Insert edge with identifiers</h4>' );
		echo( '<h5>$test = new MyClass();</h5>' );
		$test = new MyClass();
		echo( '<h5>$test->Subject( $nodeA[ kTAG_NID ] );</h5>' );
		$test->Subject( $nodeA[ kTAG_NID ] );
		echo( '<h5>$test->Predicate( $termC[ kTAG_NID ] );</h5>' );
		$test->Predicate( $termC[ kTAG_NID ] );
		echo( '<h5>$test->Object( $nodeB[ kTAG_NID ] );</h5>' );
		$test->Object( $nodeB[ kTAG_NID ] );
		echo( '<h5>$status = $test->Insert( $edge_container );</h5>' );
		$status = $test->Insert( $edge_container );
		echo( '<h3><font color="red">Should have raised an exception</font></h3>' );
		echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
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
	// Let node create edge.
	//
	echo( '<h4>Let node create edge</h4>' );
	echo( '<h5>$edge = $nodeA->RelateTo( $termC, $nodeC );</h5>' );
	$edge = $nodeA->RelateTo( $termC, $nodeC );
	echo( '<h5>$status = $edge->Insert( $database );</h5>' );
	$status = $edge->Insert( $database );
	echo( '<i>Edge</i><pre>' ); print_r( $edge ); echo( '</pre>' );
	echo( '<i>Subject</i><pre>' ); print_r( $edge->LoadSubject( $database ) ); echo( '</pre>' );
	echo( '<i>Predicate</i><pre>' ); print_r( $edge->LoadPredicate( $edge_container ) ); echo( '</pre>' );
	echo( '<i>Object</i><pre>' ); print_r( $edge->LoadObject( $database ) ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );

	//
	// Convert to string.
	//
	echo( '<h4>Convert to string</h4>' );
	echo( '<h5>$string = (string) $edge;</h5>' );
	$string = (string) $edge;
	echo( '<pre>' ); print_r( $string ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );

	//
	// Resolve by ID.
	//
	echo( '<h4>Resolve by ID</h4>' );
	echo( '<h5>$found = COntologyEdge::Resolve( $database, $edge[ kTAG_NID ], TRUE );</h5>' );
	$found = COntologyEdge::Resolve( $database, $edge[ kTAG_NID ], TRUE );
	echo( '<pre>' ); print_r( $found ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Resolve by object.
	//
	echo( '<h4>Resolve by object</h4>' );
	echo( '<h5>$found = COntologyEdge::Resolve( $edge_container, $edge, TRUE );</h5>' );
	$found = COntologyEdge::Resolve( $edge_container, $edge, TRUE );
	echo( '<pre>' ); print_r( $found ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Resolve by global identifier.
	//
	echo( '<h4>Resolve by global identifier</h4>' );
	echo( '<h5>$found = COntologyEdge::Resolve( $database, $string, TRUE );</h5>' );
	$found = COntologyEdge::Resolve( $database, $string, TRUE );
	echo( '<pre>' ); print_r( $found ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Resolve by unique identifier.
	//
	echo( '<h4>Resolve by unique identifier</h4>' );
	echo( '<h5>$found = COntologyEdge::Resolve( $database, $edge[ kTAG_UID ], TRUE );</h5>' );
	$found = COntologyEdge::Resolve( $database, $edge[ kTAG_UID ], TRUE );
	echo( '<pre>' ); print_r( $found ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Delete edge.
	//
	echo( '<h4>Delete edge</h4>' );
	echo( '<h5>$edge->Delete( $database );</h5>' );
	$edge->Delete( $database );
	echo( '<i>Edge</i><pre>' ); print_r( $edge ); echo( '</pre>' );
	echo( '<i>Subject</i><pre>' ); print_r( $nodeA = $edge->LoadSubject( $database ) ); echo( '</pre>' );
	echo( '<i>Predicate</i><pre>' ); print_r( $termC = $edge->LoadPredicate( $edge_container ) ); echo( '</pre>' );
	echo( '<i>Object</i><pre>' ); print_r( $nodeB = $edge->LoadObject( $database ) ); echo( '</pre>' );
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
