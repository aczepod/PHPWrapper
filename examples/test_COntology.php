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
	// Create namespace term.
	//
	echo( '<h4>Create namespace term</h4>' );
	$namespace = new COntologyTerm();
	$namespace[ kOFFSET_LID ] = "NAMESPACE";
	echo( '<pre>' ); print_r( $namespace ); echo( '</pre>' );
	
	//
	// Create ontology term.
	//
	echo( '<h4>Create ontology term</h4>' );
	$termOnto = new COntologyTerm();
	$termOnto[ kOFFSET_NAMESPACE ] = $namespace;
	$termOnto[ kOFFSET_LID ] = "ONTOLOGY";
	echo( '<pre>' ); print_r( $termOnto ); echo( '</pre>' );
	
	//
	// Create category term.
	//
	echo( '<h4>Create category term</h4>' );
	$termCat = new COntologyTerm();
	$termCat[ kOFFSET_NAMESPACE ] = $namespace;
	$termCat[ kOFFSET_LID ] = "CATEGORY";
	echo( '<pre>' ); print_r( $termCat ); echo( '</pre>' );
	
	//
	// Create predicate term.
	//
	echo( '<h4>Create predicate term</h4>' );
	$termPredicate = new COntologyTerm();
	$termPredicate[ kOFFSET_NAMESPACE ] = $namespace;
	$termPredicate[ kOFFSET_LID ] = "PREDICATE";
	echo( '<pre>' ); print_r( $termPredicate ); echo( '</pre>' );
	
	//
	// Create trait term.
	//
	echo( '<h4>Create trait term</h4>' );
	$termTrait = new COntologyTerm();
	$termTrait[ kOFFSET_NAMESPACE ] = $namespace;
	$termTrait[ kOFFSET_LID ] = "TRAIT";
	echo( '<pre>' ); print_r( $termTrait ); echo( '</pre>' );
	
	//
	// Create method term.
	//
	echo( '<h4>Create method term</h4>' );
	$termMethod = new COntologyTerm();
	$termMethod[ kOFFSET_NAMESPACE ] = $namespace;
	$termMethod[ kOFFSET_LID ] = "METHOD";
	echo( '<pre>' ); print_r( $termMethod ); echo( '</pre>' );
	
	//
	// Create scale term.
	//
	echo( '<h4>Create scale term</h4>' );
	$termScale = new COntologyTerm();
	$termScale[ kOFFSET_NAMESPACE ] = $namespace;
	$termScale[ kOFFSET_LID ] = "SCALE";
	echo( '<pre>' ); print_r( $termScale ); echo( '</pre>' );
	
	//
	// Create ontology node.
	//
	echo( '<h4>Create ontology node</h4>' );
	$nodeOnto = new COntologyNode();
	$nodeOnto->Term( $termOnto );
	echo( '<pre>' ); print_r( $nodeOnto ); echo( '</pre>' );
	
	//
	// Create category node.
	//
	echo( '<h4>Create category node</h4>' );
	$nodeCat = new COntologyNode();
	$nodeCat->Term( $termCat );
	echo( '<pre>' ); print_r( $nodeCat ); echo( '</pre>' );
	
	//
	// Create trait node.
	//
	echo( '<h4>Create trait node</h4>' );
	$nodeTrait = new COntologyNode();
	$nodeTrait->Term( $termTrait );
	echo( '<pre>' ); print_r( $nodeTrait ); echo( '</pre>' );
	
	//
	// Create method node.
	//
	echo( '<h4>Create method node</h4>' );
	$nodeMethod = new COntologyNode();
	$nodeMethod->Term( $termMethod );
	echo( '<pre>' ); print_r( $nodeMethod ); echo( '</pre>' );
	
	//
	// Create scale node.
	//
	echo( '<h4>Create scale node</h4>' );
	$nodeScale = new COntologyNode();
	$nodeScale->Term( $termScale );
	echo( '<pre>' ); print_r( $nodeScale ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );

	//
	// Create ontology object.
	//
	echo( '<h4>Create ontology object</h4>' );
	echo( '<h5>$ontology = new MyClass( $database );</h5>' );
	$ontology = new MyClass( $database );
	echo( 'Inited['.$ontology->inited()
				   .'] Dirty['.$ontology->dirty()
				   .'] Saved['.$ontology->committed()
				   .'] Encoded['.$ontology->encoded().']<br />' );
	echo( '<i>Name: </i>'.(string) $ontology );
	echo( '<pre>' ); print_r( $ontology ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );

	//
	// Set root node.
	//
	echo( '<h4>Set ontology object</h4>' );
	echo( '<h5>$ontology->Root( $nodeOnto );</h5>' );
	$ontology->Root( $nodeOnto );
	echo( 'Inited['.$ontology->inited()
				   .'] Dirty['.$ontology->dirty()
				   .'] Saved['.$ontology->committed()
				   .'] Encoded['.$ontology->encoded().']<br />' );
	echo( '<i>Name: </i>'.(string) $ontology );
	echo( '<pre>' ); print_r( $ontology ); echo( '</pre>' );
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
