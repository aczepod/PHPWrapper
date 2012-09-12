<?php

/**
 * {@link CEdge.php Base} object test suite.
 *
 * This file contains routines to test and demonstrate the behaviour of the
 * base object {@link CEdge class}.
 *
 *	@package	Test
 *	@subpackage	Framework
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 04/09/2012
 */

/*=======================================================================================
 *																						*
 *									test_CEdge.php										*
 *																						*
 *======================================================================================*/

//
// Global includes.
//
require_once( '/Library/WebServer/Library/PHPWrapper/includes.inc.php' );

//
// Class includes.
//
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CEdge.php" );


/*=======================================================================================
 *	TEST CLASS																			*
 *======================================================================================*/
 
//
// Test class definition.
//
class MyClass extends CEdge
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
	echo( '$term_container = CTerm::Container( $database );<br />' );
	$term_container = CTerm::Container( $database );
	echo( '$node_container = CNode::Container( $database );<br />' );
	$node_container = CNode::Container( $database );
	echo( '$edge_container = CEdge::Container( $database );<br />' );
	$edge_container = CEdge::Container( $database );
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
	$namespace[ kOFFSET_LID ] = "NAMESPACE";
	$status = $namespace->Insert( $term_container );
	echo( '<pre>' ); print_r( $namespace ); echo( '</pre>' );
	
	//
	// Create term A.
	//
	echo( '<h4>Create term A</h4>' );
	$termA = new CTerm();
	$termA[ kOFFSET_NAMESPACE ] = $namespace;
	$termA[ kOFFSET_LID ] = "A";
	$status = $termA->Insert( $term_container );
	echo( '<pre>' ); print_r( $termA ); echo( '</pre>' );
	
	//
	// Create term B.
	//
	echo( '<h4>Create term B</h4>' );
	$termB = new CTerm();
	$termB[ kOFFSET_NAMESPACE ] = $namespace;
	$termB[ kOFFSET_LID ] = "B";
	$status = $termB->Insert( $term_container );
	echo( '<pre>' ); print_r( $termB ); echo( '</pre>' );
	
	//
	// Create term C.
	//
	echo( '<h4>Create term C</h4>' );
	$termC = new CTerm();
	$termC[ kOFFSET_NAMESPACE ] = $namespace;
	$termC[ kOFFSET_LID ] = "C";
	$status = $termC->Insert( $term_container );
	echo( '<pre>' ); print_r( $termC ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Create subject node.
	//
	echo( '<h4>Create subject node</h4>' );
	$nodeS = new CNode();
	$nodeS->Term( $termA );
	$status = $nodeS->Insert( $node_container );
	echo( '<pre>' ); print_r( $nodeS ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Create object node.
	//
	echo( '<h4>Create object node</h4>' );
	$nodeO = new CNode();
	$nodeO->Term( $termC );
	$status = $nodeO->Insert( $node_container );
	echo( '<pre>' ); print_r( $nodeO ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );

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
	// Insert edge.
	//
	echo( '<h4>Insert edge</h4>' );
	echo( '<h5>$edge->Subject( $nodeS[ kOFFSET_NID ] );</h5>' );
	$edge->Subject( $nodeS[ kOFFSET_NID ] );
	echo( '<h5>$edge->Predicate( $termC[ kOFFSET_NID ] );</h5>' );
	$edge->Predicate( $termC[ kOFFSET_NID ] );
	echo( '<h5>$edge->Object( $nodeO[ kOFFSET_NID ] );</h5>' );
	$edge->Object( $nodeO[ kOFFSET_NID ] );
	echo( 'Inited['.$edge->inited()
				   .'] Dirty['.$edge->dirty()
				   .'] Saved['.$edge->committed()
				   .'] Encoded['.$edge->encoded().']<br />' );
	echo( '<h5>$status = $edge->Insert( $edge_container );</h5>' );
	$status = $edge->Insert( $edge_container );
	echo( '<pre>' ); print_r( $edge ); echo( '</pre>' );
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
