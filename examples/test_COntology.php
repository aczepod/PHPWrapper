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
	// Create IS-A predicate term.
	//
	echo( '<h4>Create IS-A predicate term</h4>' );
	echo( '<h5>$term = $test->NewTerm( "IS-A", NULL, "Is-a", "This is the “is-a” predicate term", "en" );</h5>' );
	$term = $test->NewTerm( "IS-A", NULL, "Is-a", "This is the “is-a” predicate term", "en" );
	echo( '<pre>' ); print_r( $term ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Create TRAIT-OF predicate term.
	//
	echo( '<h4>Create TRAIT-OF predicate term</h4>' );
	echo( '<h5>$term = $test->NewTerm( "TRAIT-OF", NULL, "Trait-of", "This is the “trait-of” predicate term", "en" );</h5>' );
	$term = $test->NewTerm( "TRAIT-OF", NULL, "Trait-of", "This is the “trait-of” predicate term", "en" );
	echo( '<pre>' ); print_r( $term ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Create METHOD-OF predicate term.
	//
	echo( '<h4>Create METHOD-OF predicate term</h4>' );
	echo( '<h5>$term = $test->NewTerm( "METHOD-OF", NULL, "Method-of", "This is the “method-of” predicate term", "en" );</h5>' );
	$term = $test->NewTerm( "METHOD-OF", NULL, "Method-of", "This is the “method-of” predicate term", "en" );
	echo( '<pre>' ); print_r( $term ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Create SCALE-OF predicate term.
	//
	echo( '<h4>Create SCALE-OF predicate term</h4>' );
	echo( '<h5>$term = $test->NewTerm( "SCALE-OF", NULL, "Scale-of", "This is the “scale-of” predicate term", "en" );</h5>' );
	$term = $test->NewTerm( "SCALE-OF", NULL, "Scale-of", "This is the “scale-of” predicate term", "en" );
	echo( '<pre>' ); print_r( $term ); echo( '</pre>' );
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
	// Get ontology term with global identifier.
	//
	echo( '<h4>Get ontology term with global identifier</h4>' );
	echo( '<h5>$term = $test->NewTerm( "NAMESPACE:ONTOLOGY" );</h5>' );
	$term = $test->NewTerm( "NAMESPACE:ONTOLOGY" );
	echo( '<pre>' ); print_r( $term ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Get ontology term with namespace object.
	//
	echo( '<h4>Get ontology term with namespace object</h4>' );
	echo( '<h5>$term = $test->NewTerm( "ONTOLOGY", $namespace );</h5>' );
	$term = $test->NewTerm( "ONTOLOGY", $namespace );
	echo( '<pre>' ); print_r( $term ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Get ontology term with namespace identifier.
	//
	echo( '<h4>Get ontology term with namespace identifier</h4>' );
	echo( '<h5>$term = $test->NewTerm( "ONTOLOGY", $namespace[ kOFFSET_NID ] );</h5>' );
	$term = $test->NewTerm( "ONTOLOGY", $namespace[ kOFFSET_NID ] );
	echo( '<pre>' ); print_r( $term ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );

	//
	// Create new root node.
	//
	echo( '<h4>Create new root node</h4>' );
	echo( '<h5>$node = $test->NewRootNode( "ROOT", $namespace, "Root", "This is the root term", "en" );</h5>' );
	$node = $test->NewRootNode( "ROOT", $namespace, "Root", "This is the root term", "en" );
	echo( '<pre>' ); print_r( $node ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Create ontology root node.
	//
	echo( '<h4>Create ontology root node</h4>' );
	echo( '<h5>$node = $test->NewRootNode( "NAMESPACE:ONTOLOGY" );</h5>' );
	$root_node = $test->NewRootNode( "NAMESPACE:ONTOLOGY" );
	echo( '<pre>' ); print_r( $root_node ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Retrieve root node.
	//
	echo( '<h4>Retrieve root node</h4>' );
	echo( '<h5>$node = $test->NewRootNode( 1 );</h5>' );
	$node = $test->NewRootNode( 1 );
	echo( '<pre>' ); print_r( $node ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Retrieve root node by term.
	//
	echo( '<h4>Retrieve root node by term</h4>' );
	echo( '<h5>$node = $test->NewRootNode( "NAMESPACE:ROOT" );</h5>' );
	$node = $test->NewRootNode( "NAMESPACE:ROOT" );
	echo( '<pre>' ); print_r( $node ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Create category node.
	//
	echo( '<h4>Create category node</h4>' );
	echo( '<h5>$term = $test->ResolveTerm( "CATEGORY", "NAMESPACE", TRUE );</h5>' );
	$term = $test->ResolveTerm( "CATEGORY", "NAMESPACE", TRUE );
	echo( '<h5>$cat_node = $node = $test->NewNode( $term );</h5>' );
	$cat_node = $node = $test->NewNode( $term );
	echo( '<pre>' ); print_r( $cat_node ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Create trait node.
	//
	echo( '<h4>Create trait node</h4>' );
	echo( '<h5>$node = $test->NewTraitNode( "TRAIT", $namespace, "Trait", "This is the trait term", "en" );</h5>' );
	$trait_node = $test->NewTraitNode( "TRAIT", $namespace, "Trait", "This is the trait term", "en" );
	echo( '<pre>' ); print_r( $trait_node ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Create method node 1.
	//
	echo( '<h4>Create method node 1</h4>' );
	echo( '<h5>$node = $test->NewMethodNode( "METHOD1", $namespace[ kOFFSET_NID ], "Method 1", "This is the method term 1", "en" );</h5>' );
	$method_node1 = $test->NewMethodNode( "METHOD1", $namespace[ kOFFSET_NID ], "Method 1", "This is the method term 1", "en" );
	echo( '<pre>' ); print_r( $method_node1 ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Create method node 2.
	//
	echo( '<h4>Create method node 2</h4>' );
	echo( '<h5>$node = $test->NewMethodNode( "METHOD2", $namespace[ kOFFSET_NID ], "Method 2", "This is the method term 2", "en" );</h5>' );
	$method_node2 = $test->NewMethodNode( "METHOD2", $namespace[ kOFFSET_NID ], "Method 2", "This is the method term 2", "en" );
	echo( '<pre>' ); print_r( $method_node2 ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Create scale node.
	//
	echo( '<h4>Create scale node</h4>' );
	echo( '<h5>$node = $test->NewScaleNode( "SCALE", kTYPE_ENUM, $namespace, "Scale", "This is the scale term", "en" );</h5>' );
	$scale_node = $test->NewScaleNode( "SCALE", kTYPE_ENUM, $namespace, "Scale", "This is the scale term", "en" );
	echo( '<pre>' ); print_r( $scale_node ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Create enumeration node.
	//
	echo( '<h4>Create enumeration node</h4>' );
	echo( '<h5>$node = $test->NewEnumerationNode( "STR", $namespace, "String", "String data type code", "en" );</h5>' );
	$enum_node = $test->NewEnumerationNode( "STR", $namespace, "String", "String data type code", "en" );
	echo( '<pre>' ); print_r( $enum_node ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Instantiate enumeration node with category node.
	//
	echo( '<h4>Instantiate enumeration node with category node</h4>' );
	echo( '<h4><i>Notice that it will not be an enumeration node.</i></h4>' );
	echo( '<h5>$node = $test->NewEnumerationNode( (int) (string) $cat_node );</h5>' );
	$node = $test->NewEnumerationNode( (int) (string) $cat_node );
	echo( 'Template<pre>' ); print_r( $cat_node ); echo( '</pre>' );
	echo( 'Node<pre>' ); print_r( $node ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Instantiate enumeration node.
	//
	echo( '<h4>Instantiate enumeration node</h4>' );
	echo( '<h5>$node = $test->NewEnumerationNode( ":STR" );</h5>' );
	$node = $test->NewEnumerationNode( ":STR" );
	echo( '<pre>' ); print_r( $node ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );

	//
	// Category is subclass of ontology root node.
	//
	echo( '<h4>Category is subclass of ontology root node</h4>' );
	echo( '<h5>$edge = $test->SubclassOf( $cat_node, "NAMESPACE:ONTOLOGY" );</h5>' );
	$edge = $test->SubclassOf( $cat_node, "NAMESPACE:ONTOLOGY" );
	echo( '<pre>' ); print_r( $edge ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Trait is subclass of category node.
	//
	echo( '<h4>Trait is subclass of category node</h4>' );
	echo( '<h5>$edge = $test->SubclassOf( "NAMESPACE:TRAIT", $cat_node );</h5>' );
	$edge = $test->SubclassOf( "NAMESPACE:TRAIT", $cat_node );
	echo( '<pre>' ); print_r( $edge ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Method 1 is method-of of trait node.
	//
	echo( '<h4>Method 1 is method-of of trait node</h4>' );
	echo( '<h5>$edge1 = $test->MethodOf( "NAMESPACE:METHOD1", "NAMESPACE:TRAIT" );</h5>' );
	$edge1 = $test->MethodOf( "NAMESPACE:METHOD1", "NAMESPACE:TRAIT" );
	echo( '<pre>' ); print_r( $edge1 ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Method 2 is method-of of method 1 node.
	//
	echo( '<h4>Method 2 is method-of of method 1 node</h4>' );
	echo( '<h5>$edge2 = $test->MethodOf( "NAMESPACE:METHOD2", "NAMESPACE:METHOD1" );</h5>' );
	$edge2 = $test->MethodOf( "NAMESPACE:METHOD2", "NAMESPACE:METHOD1" );
	echo( '<pre>' ); print_r( $edge2 ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Scale is scale-of of method 2 node.
	//
	echo( '<h4>Scale is scale-of of method 2 node</h4>' );
	echo( '<h5>$edge3 = $test->ScaleOf( "NAMESPACE:SCALE", "NAMESPACE:METHOD2" );</h5>' );
	$edge3 = $test->ScaleOf( "NAMESPACE:SCALE", "NAMESPACE:METHOD2" );
	echo( '<pre>' ); print_r( $edge3 ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// String is enumeration-of of scale node.
	//
	echo( '<h4>String is enumeration-of of scale node</h4>' );
	echo( '<h5>$edge = $test->EnumOf( ":STR", "NAMESPACE:SCALE" );</h5>' );
	$edge = $test->EnumOf( ":STR", "NAMESPACE:SCALE" );
	echo( '<pre>' ); print_r( $edge ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );

	//
	// Create tag from elements.
	//
	echo( '<h4>Create tag from elements</h4>' );
	echo( '<h5>$count = $test->AddToTag( $tag, $trait_node );</h5>' );
	$count = $test->AddToTag( $tag, $trait_node );
	echo( '<h5>$count = $test->AddToTag( $tag, ":".kPREDICATE_METHOD_OF );</h5>' );
	$count = $test->AddToTag( $tag, ":".kPREDICATE_METHOD_OF );
	echo( '<h5>$count = $test->AddToTag( $tag, $method_node1 );</h5>' );
	$count = $test->AddToTag( $tag, $method_node1 );
	echo( '<h5>$count = $test->AddToTag( $tag, ":".kPREDICATE_METHOD_OF );</h5>' );
	$count = $test->AddToTag( $tag, ":".kPREDICATE_METHOD_OF );
	echo( '<h5>$count = $test->AddToTag( $tag, $method_node2 );</h5>' );
	$count = $test->AddToTag( $tag, $method_node2 );
	echo( '<h5>$count = $test->AddToTag( $tag, ":".kPREDICATE_SCALE_OF );</h5>' );
	$count = $test->AddToTag( $tag, ":".kPREDICATE_SCALE_OF );
	echo( '<h5>$count = $test->AddToTag( $tag, $scale_node );</h5>' );
	$count = $test->AddToTag( $tag, $scale_node );
	echo( '<h5>$status = $test->AddToTag( $tag, TRUE );</h5>' );
	$status = $test->AddToTag( $tag, TRUE );
	echo( '<pre>' ); print_r( $tag ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Wrong type of vertex.
	//
	try
	{
		echo( '<h4>Wrong type of vertex</h4>' );
		echo( '<h5>$tag = NULL;</h5>' );
		$tag = NULL;
		echo( '<h5>$count = $test->AddToTag( $tag, ":".kPREDICATE_SUBCLASS_OF );</h5>' );
		$count = $test->AddToTag( $tag, ":".kPREDICATE_SUBCLASS_OF );
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
	// Wrong type of predicate.
	//
	try
	{
		echo( '<h4>Wrong type of predicate</h4>' );
		echo( '<h5>$tag = NULL;</h5>' );
		$tag = NULL;
		echo( '<h5>$count = $test->AddToTag( $tag, $trait_node );</h5>' );
		$count = $test->AddToTag( $tag, $trait_node );
		echo( '<h5>$count = $test->AddToTag( $tag, $method_node1 );</h5>' );
		$count = $test->AddToTag( $tag, $method_node1 );
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
	// Resolve tag with ID.
	//
	echo( '<h4>Resolve tag with ID</h4>' );
	echo( '<h5>$tag = $test->ResolveTag( 1 );</h5>' );
	$tag = $test->ResolveTag( 1 );
	echo( '<pre>' ); print_r( $tag ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Resolve tag with trait term global identifier.
	//
	echo( '<h4>Resolve tag with trait term global identifier</h4>' );
	echo( '<h5>$tag = $test->ResolveTag( $test->ResolveTerm( "TRAIT", "NAMESPACE" ) );</h5>' );
	$tag = $test->ResolveTag( $test->ResolveTerm( "TRAIT", "NAMESPACE" ) );
	echo( '<pre>' ); print_r( $tag ); echo( '</pre>' );
	echo( '<hr />' );

	//
	// Resolve tag with method 1 term global identifier.
	//
	echo( '<h4>Resolve tag with method 1 term global identifier</h4>' );
	echo( '<h5>$tag = $test->ResolveTag( $test->ResolveTerm( "METHOD1", "NAMESPACE" ) );</h5>' );
	$tag = $test->ResolveTag( $test->ResolveTerm( "METHOD1", "NAMESPACE" ) );
	echo( '<pre>' ); print_r( $tag ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );

	//
	// Initialise ontology.
	//
	echo( '<h4>Initialise ontology</h4>' );
	echo( '<h5>define( "kDEFAULT_LANGUAGE", "en" );</h5>' );
	define( "kDEFAULT_LANGUAGE", "en" );
	echo( '<h5>$test->InitOntology();</h5>' );
	$test->InitOntology();
	echo( '<hr />' );

	//
	// Instantiate default term.
	//
	echo( '<h4>Instantiate default term</h4>' );
	echo( '<h5>$term = $test->ResolveTerm( kOFFSET_TERM, NULL, TRUE );</h5>' );
	$term = $test->ResolveTerm( kOFFSET_TERM, NULL, TRUE );
	echo( '<pre>' ); print_r( $term ); echo( '</pre>' );
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
