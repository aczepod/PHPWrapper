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
require_once( '/Library/WebServer/Library/PHPWrapper/includes.inc.php' );

//
// Containers.
//
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/Persistence/CMongoContainer.php" );
use \MyWrapper\Persistence\CMongoContainer as CMongoContainer;

//
// Terms.
//
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/Ontology/COntologyTerm.php" );
use \MyWrapper\Ontology\COntologyTerm as COntologyTerm;

//
// Class includes.
//
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/Ontology/COntologyNode.php" );
use \MyWrapper\Ontology\COntologyNode as COntologyNode;


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
	echo( '$collection = $db->selectCollection( "COntologyNode" );<br />' );
	$collection = $db->selectCollection( "COntologyNode" );
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
		echo( '<hr />' );
	}
	
	//
	// Create namespace term.
	//
	echo( '<h4>Create namespace term</h4>' );
	$namespace = new COntologyTerm();
	$namespace[ kOFFSET_LID ] = "NAMESPACE";
	$status = $namespace->Insert( $container );
	echo( '<pre>' ); print_r( $namespace ); echo( '</pre>' );
	
	//
	// Create term A.
	//
	echo( '<h4>Create term A</h4>' );
	$termA = new COntologyTerm();
	$termA[ kOFFSET_NAMESPACE ] = $namespace;
	$termA[ kOFFSET_LID ] = "A";
	$status = $termA->Insert( $container );
	echo( '<pre>' ); print_r( $termA ); echo( '</pre>' );
	
	//
	// Create term B.
	//
	echo( '<h4>Create term B</h4>' );
	$termB = new COntologyTerm();
	$termB[ kOFFSET_NAMESPACE ] = $namespace;
	$termB[ kOFFSET_LID ] = "B";
	$status = $termB->Insert( $container );
	echo( '<pre>' ); print_r( $termB ); echo( '</pre>' );
	
	//
	// Create term C.
	//
	echo( '<h4>Create term C</h4>' );
	$termC = new COntologyTerm();
	$termC[ kOFFSET_NAMESPACE ] = $namespace;
	$termC[ kOFFSET_LID ] = "C";
	$status = $termC->Insert( $container );
	echo( '<pre>' ); print_r( $termC ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );

	//
	// Insert unitialised object.
	//
	try
	{
		echo( '<h4>Insert uninitialized object</h4>' );
		echo( '<h5>$namespace = new MyClass();</h5>' );
		$node = new MyClass();
		echo( '<h5>$status = $namespace->Insert( $container );</h5>' );
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
	echo( '<h5>$node[ kOFFSET_TERM ] = $termA;</h5>' );
	$node[ kOFFSET_TERM ] = $termA;
	echo( 'Inited['.$node->inited()
				   .'] Dirty['.$node->dirty()
				   .'] Saved['.$node->committed()
				   .'] Encoded['.$node->encoded().']<br />' );
	echo( '<h5>$status = $node->Insert( $container );</h5>' );
	$status = $node->Insert( $container );
	echo( 'Node<pre>' ); print_r( $node ); echo( '</pre>' );
	echo( '<h5>$term = COntologyTerm::NewObject( $container, $node[ kOFFSET_TERM ] ); // Notice node reference.</h5>' );
	$term = COntologyTerm::NewObject( $container, $node[ kOFFSET_TERM ] );
	echo( 'Term<pre>' ); print_r( $term ); echo( '</pre>' );
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
	echo( '<h5>$status = $node->Replace( $container );</h5>' );
	$status = $node->Replace( $container );
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
	echo( '<h5>$status = $node->Replace( $container );</h5>' );
	$status = $node->Replace( $container );
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
	echo( '<h5>$status = $node->Replace( $container );</h5>' );
	$status = $node->Replace( $container );
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
	echo( '<h5>$status = $node->Replace( $container );</h5>' );
	$status = $node->Replace( $container );
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
	echo( '<h5>$status = $node->Replace( $container );</h5>' );
	$status = $node->Replace( $container );
	echo( '<pre>' ); print_r( $node ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Add type.
	//
	echo( '<h4>Add type</h4>' );
	echo( '<h5>$node->Type( $termC );</h5>' );
	$node->Type( $termC );
	echo( 'Inited['.$node->inited()
				   .'] Dirty['.$node->dirty()
				   .'] Saved['.$node->committed()
				   .'] Encoded['.$node->encoded().']<br />' );
	echo( '<h5>$status = $node->Replace( $container );</h5>' );
	$status = $node->Replace( $container );
	echo( '<pre>' ); print_r( $node ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr>' );

	//
	// Insert wrong term.
	//
	try
	{
		echo( '<h4>Insert wrong term</h4>' );
		echo( '<h5>$node[ kOFFSET_TERM ] = "pippo";</h5>' );
		$node[ kOFFSET_TERM ] = "pippo";
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
		echo( '<h5>$node[ kOFFSET_TERM ] = $node;</h5>' );
		$node[ kOFFSET_TERM ] = $node;
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
		echo( '<h5>$node[ kOFFSET_KIND ] = "pippo";</h5>' );
		$node[ kOFFSET_KIND ] = "pippo";
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
	echo( '<h5>$status = $node->Delete( $container );</h5>' );
	$status = $node->Delete( $container );
	echo( 'Inited['.$node->inited()
				   .'] Dirty['.$node->dirty()
				   .'] Saved['.$node->committed()
				   .'] Encoded['.$node->encoded().']<br />' );
	echo( 'Node<pre>' ); print_r( $node ); echo( '</pre>' );
	echo( '<h5>$term = COntologyTerm::NewObject( $container, $node[ kOFFSET_TERM ] ); // Notice node reference.</h5>' );
	$term = COntologyTerm::NewObject( $container, $node[ kOFFSET_TERM ] );
	echo( 'Term<pre>' ); print_r( $term ); echo( '</pre>' );
	echo( '<hr />' );
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
