<?php

/**
 * {@link COntology.php Base} object test suite.
 *
 * This file contains routines to test and demonstrate the behaviour of the
 * base object {@link COntology class}.
 *
 *	@package	Test
 *	@subpackage	Framework
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 18/09/2012
 */

/*=======================================================================================
 *																						*
 *									test_COntology.php									*
 *																						*
 *======================================================================================*/

//
// Global includes.
//
require_once( '/Library/WebServer/Library/PHPWrapper/includes.inc.php' );

//
// Class includes.
//
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/COntology.php" );


/*=======================================================================================
 *	TEST CLASS																			*
 *======================================================================================*/
 
//
// Test class definition.
//
class MyClass extends COntology
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
	// Create connection.
	//
	echo( '<hr />' );
	echo( '<h4>Create connection</h4>' );
	echo( '$server = new CMongoServer();<br />' );
	$server = New CMongoServer();
	echo( '$database = $server->Database( "TEST" );<br />' );
	$database = $server->Database( "TEST" );
	echo( '$database->Drop();<br />' );
	$database->Drop();
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
	}

	//
	// Create empty ontology object.
	//
	echo( '<h4>Create empty ontology object</h4>' );
	echo( '<h5>$ontology = new MyClass();</h5>' );
	$test = new MyClass();
	echo( 'Inited['.$test->inited()
				   .'] Dirty['.$test->dirty()
				   .'] Saved['.$test->committed()
				   .'] Encoded['.$test->encoded().']<br />' );
	echo( '<i>Name: </i>'.(string) $test );
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Try getting a term.
	//
	try
	{
		echo( '<h4>Try getting a term</h4>' );
		echo( '<h5>$term = $test->NewTerm( "NAMESPACE" );</h5>' );
		$term = $test->NewTerm( "NAMESPACE" );
		echo( '<h3><font color="red">Should have raised an exception</font></h3>' );
		echo( '<pre>' ); print_r( $term ); echo( '</pre>' );
		echo( '<hr />' );
	}
	catch( Exception $error )
	{
		echo( '<h5>Expected exception</h5>' );
		echo( '<pre>'.(string) $error.'</pre>' );
		echo( '<hr>' );
	}

	//
	// Create filled ontology object.
	//
	echo( '<h4>Create filled ontology object</h4>' );
	echo( '<h5>$test = new MyClass( $database );</h5>' );
	$test = new MyClass( $database );
	echo( 'Inited['.$test->inited()
				   .'] Dirty['.$test->dirty()
				   .'] Saved['.$test->committed()
				   .'] Encoded['.$test->encoded().']<br />' );
	echo( '<i>Name: </i>'.(string) $test );
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Try getting a term with empty identifier.
	//
	try
	{
		echo( '<h4>Try getting a term with empty identifier</h4>' );
		echo( '<h5>$term = $test->NewTerm( NULL );</h5>' );
		$term = $test->NewTerm( NULL );
		echo( '<h3><font color="red">Should have raised an exception</font></h3>' );
		echo( '<pre>' ); print_r( $term ); echo( '</pre>' );
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
	// Create namespace term.
	//
	echo( '<h4>Create namespace term</h4>' );
	echo( '<h5>$term = $test->NewTerm( "NAMESPACE", NULL, "Namespace", "This is the namespace term", "en" );</h5>' );
	$term = $test->NewTerm( "NAMESPACE", NULL, "Namespace", "This is the namespace term", "en" );
	echo( '<pre>' ); print_r( $term ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Try creating another namespace term.
	//
	echo( '<h4>Try creating another namespace term</h4>' );
	echo( '<h5>$term = $test->NewTerm( "NAMESPACE", NULL, "Other label", "Other description", "en" );</h5>' );
	$term = $test->NewTerm( "NAMESPACE", NULL, "Other label", "Other description", "en" );
	echo( '<pre>' ); print_r( $term ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Create ontology term.
	//
	echo( '<h4>Create ontology term</h4>' );
	echo( '<h5>$term = $test->NewTerm( "ONTOLOGY", "NAMESPACE", "Ontology", "This is the ontology term", "en" );</h5>' );
	$term = $test->NewTerm( "ONTOLOGY", "NAMESPACE", "Ontology", "This is the ontology term", "en" );
	echo( '<pre>' ); print_r( $term ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Resolve namespace term.
	//
	echo( '<h4>Resolve namespace term</h4>' );
	echo( '<h5>$namespace = $test->ResolveTerm( "NAMESPACE" );</h5>' );
	$namespace = $test->ResolveTerm( "NAMESPACE" );
	echo( '<pre>' ); print_r( $namespace ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Create category term.
	//
	echo( '<h4>Create category term</h4>' );
	echo( '<h5>$term = $test->NewTerm( "CATEGORY", $namespace, "Category", "This is the category term", "en" );</h5>' );
	$term = $test->NewTerm( "CATEGORY", $namespace, "Category", "This is the category term", "en" );
	echo( '<pre>' ); print_r( $term ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Create predicate term.
	//
	echo( '<h4>Create predicate term</h4>' );
	echo( '<h5>$term = $test->NewTerm( "PREDICATE", $namespace[ kOFFSET_NID ], "Predicate", "This is the predicate term", "en" );</h5>' );
	$term = $test->NewTerm( "PREDICATE", $namespace[ kOFFSET_NID ], "Predicate", "This is the predicate term", "en" );
	echo( '<pre>' ); print_r( $term ); echo( '</pre>' );
	echo( '<hr />' );
exit;
	
	//
	// Create trait term.
	//
	echo( '<h4>Create trait term</h4>' );
	$termTrait = new COntologyTerm();
	$termTrait[ kOFFSET_NAMESPACE ] = $namespace;
	$termTrait[ kOFFSET_LID ] = "TRAIT";
	$termTrait->Insert( $database );
	echo( '<pre>' ); print_r( $termTrait ); echo( '</pre>' );
	
	//
	// Create method term.
	//
	echo( '<h4>Create method term</h4>' );
	$termMethod = new COntologyTerm();
	$termMethod[ kOFFSET_NAMESPACE ] = $namespace;
	$termMethod[ kOFFSET_LID ] = "METHOD";
	$termMethod->Insert( $database );
	echo( '<pre>' ); print_r( $termMethod ); echo( '</pre>' );
	
	//
	// Create scale term.
	//
	echo( '<h4>Create scale term</h4>' );
	$termScale = new COntologyTerm();
	$termScale[ kOFFSET_NAMESPACE ] = $namespace;
	$termScale[ kOFFSET_LID ] = "SCALE";
	$termScale->Insert( $database );
	echo( '<pre>' ); print_r( $termScale ); echo( '</pre>' );
	
	//
	// Create ontology node.
	//
	echo( '<h4>Create ontology node</h4>' );
	$nodeOnto = new COntologyNode();
	$nodeOnto->Term( $termOnto );
	$nodeOnto->Insert( $database );
	echo( '<pre>' ); print_r( $nodeOnto ); echo( '</pre>' );
	
	//
	// Create category node.
	//
	echo( '<h4>Create category node</h4>' );
	$nodeCat = new COntologyNode();
	$nodeCat->Term( $termCat );
	$nodeCat->Insert( $database );
	echo( '<pre>' ); print_r( $nodeCat ); echo( '</pre>' );
	
	//
	// Create trait node.
	//
	echo( '<h4>Create trait node</h4>' );
	$nodeTrait = new COntologyNode();
	$nodeTrait->Term( $termTrait );
	$nodeTrait->Insert( $database );
	echo( '<pre>' ); print_r( $nodeTrait ); echo( '</pre>' );
	
	//
	// Create method node.
	//
	echo( '<h4>Create method node</h4>' );
	$nodeMethod = new COntologyNode();
	$nodeMethod->Term( $termMethod );
	$nodeMethod->Insert( $database );
	echo( '<pre>' ); print_r( $nodeMethod ); echo( '</pre>' );
	
	//
	// Create scale node.
	//
	echo( '<h4>Create scale node</h4>' );
	$nodeScale = new COntologyNode();
	$nodeScale->Term( $termScale );
	$nodeScale->Insert( $database );
	echo( '<pre>' ); print_r( $nodeScale ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );

	//
	// Get namespace term.
	//
	echo( '<h4>Get namespace term</h4>' );
	echo( '<h5>$term = $test->NewTerm( "NAMESPACE" );</h5>' );
	$term = $test->NewTerm( "NAMESPACE" );
	echo( '<pre>' ); print_r( $term ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Get predicate term with global identifier.
	//
	echo( '<h4>Get predicate term with global identifier</h4>' );
	echo( '<h5>$term = $test->NewTerm( "NAMESPACE:PREDICATE" );</h5>' );
	$term = $test->NewTerm( "NAMESPACE:PREDICATE" );
	echo( '<pre>' ); print_r( $term ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Get predicate term with namespace object.
	//
	echo( '<h4>Get predicate term with namespace object</h4>' );
	echo( '<h5>$term = $test->NewTerm( "PREDICATE", $namespace );</h5>' );
	$term = $test->NewTerm( "PREDICATE", $namespace );
	echo( '<pre>' ); print_r( $term ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Get predicate term with namespace identifier.
	//
	echo( '<h4>Get predicate term with namespace identifier</h4>' );
	echo( '<h5>$term = $test->NewTerm( "PREDICATE", $namespace[ kOFFSET_NID ] );</h5>' );
	$term = $test->NewTerm( "PREDICATE", $namespace[ kOFFSET_NID ] );
	echo( '<pre>' ); print_r( $term ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );

	//
	// Create new term.
	//
	echo( '<h4>Create new term</h4>' );
	echo( '<h5>$term = $test->NewTerm( "NEW", $namespace, "Label", "Description", "en" );</h5>' );
	$term = $test->NewTerm( "NEW", $namespace, "Label", "Description", "en" );
	echo( '<pre>' ); print_r( $term ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Insert new term.
	//
	echo( '<h4>Insert new term</h4>' );
	echo( '<h5>$status = $test->Insert( $term );</h5>' );
	$status = $test->Insert( $term );
	echo( 'Status: <pre>' ); print_r( $status ); echo( '</pre>' );
	echo( 'Term: <pre>' ); print_r( $term ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );

	//
	// Retrieve ontology node.
	//
	echo( '<h4>Retrieve ontology </h4>' );
	echo( '<h5>$node = $test->NewNode( $termOnto );</h5>' );
	$node = $test->NewNode( $termOnto );
	echo( 'Nodes: <pre>' ); print_r( $node ); echo( '</pre>' );
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
