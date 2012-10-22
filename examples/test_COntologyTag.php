<?php

/**
 * {@link COntologyTag.php Base} object test suite.
 *
 * This file contains routines to test and demonstrate the behaviour of the
 * base object {@link COntologyTag class}.
 *
 *	@package	Test
 *	@subpackage	Framework
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 17/09/2012
 */

/*=======================================================================================
 *																						*
 *								test_COntologyTag.php									*
 *																						*
 *======================================================================================*/

//
// Global includes.
//
require_once( '/Library/WebServer/Library/PHPWrapper/includes.inc.php' );

//
// Class includes.
//
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/COntologyTag.php" );


/*=======================================================================================
 *	TEST CLASS																			*
 *======================================================================================*/
 
//
// Test class definition.
//
class MyClass extends COntologyTag
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
	$namespace = new COntologyTerm();
	$namespace[ kTAG_LID ] = "NAMESPACE";
	echo( '<pre>' ); print_r( $namespace ); echo( '</pre>' );
	
	//
	// Create predicate term.
	//
	echo( '<h4>Create predicate term</h4>' );
	$termPredicate = new COntologyTerm();
	$termPredicate[ kTAG_NAMESPACE ] = $namespace;
	$termPredicate[ kTAG_LID ] = "PREDICATE";
	echo( '<pre>' ); print_r( $termPredicate ); echo( '</pre>' );
	
	//
	// Create trait term.
	//
	echo( '<h4>Create trait term</h4>' );
	$termTrait = new COntologyTerm();
	$termTrait[ kTAG_NAMESPACE ] = $namespace;
	$termTrait[ kTAG_LID ] = "TRAIT";
	echo( '<pre>' ); print_r( $termTrait ); echo( '</pre>' );
	
	//
	// Create method term.
	//
	echo( '<h4>Create method term</h4>' );
	$termMethod = new COntologyTerm();
	$termMethod[ kTAG_NAMESPACE ] = $namespace;
	$termMethod[ kTAG_LID ] = "METHOD";
	echo( '<pre>' ); print_r( $termMethod ); echo( '</pre>' );
	
	//
	// Create scale term.
	//
	echo( '<h4>Create scale term</h4>' );
	$termScale = new COntologyTerm();
	$termScale[ kTAG_NAMESPACE ] = $namespace;
	$termScale[ kTAG_LID ] = "SCALE";
	echo( '<pre>' ); print_r( $termScale ); echo( '</pre>' );
	
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
	$nodeScale->Type( kTYPE_ENUM, TRUE );
	echo( '<pre>' ); print_r( $nodeScale ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Insert unitialised object.
	//
	try
	{
		echo( '<h4>Insert uninitialized object</h4>' );
		echo( '<h5>$tag = new MyClass();</h5>' );
		$tag = new MyClass();
		echo( '<h5>$status = $namespace->Insert( $database );</h5>' );
		$status = $tag->Insert( $database );
		echo( '<h3><font color="red">Should have raised an exception</font></h3>' );
		echo( '<pre>' ); print_r( $tag ); echo( '</pre>' );
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
	// Instantiate tag with trait node.
	//
	echo( '<h4>Instantiate tag with trait node</h4>' );
	echo( '<h5>$tag = new MyClass();</h5>' );
	$tag = new MyClass();
	echo( '<h5>$tag->PushItem( $nodeTrait );</h5>' );
	$tag->PushItem( $nodeTrait );
	echo( 'Inited['.$tag->inited()
				   .'] Dirty['.$tag->dirty()
				   .'] Saved['.$tag->committed()
				   .'] Encoded['.$tag->encoded().']<br />' );
	echo( '<pre>' ); print_r( $tag ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Append node item to path.
	//
	try
	{
		echo( '<h4>Append node item to path</h4>' );
		echo( '<h5>$tag = new MyClass();</h5>' );
		$tag = new MyClass();
		echo( '<h5>$tag->PushItem( $nodeTrait );</h5>' );
		$tag->PushItem( $nodeTrait );
		echo( '<h5>$tag->PushItem( $nodeMethod );</h5>' );
		$tag->PushItem( $nodeMethod );
		echo( '<h3><font color="red">Should have raised an exception</font></h3>' );
		echo( '<pre>' ); print_r( $tag ); echo( '</pre>' );
		echo( '<hr />' );
	}
	catch( Exception $error )
	{
		echo( '<h5>Expected exception</h5>' );
		echo( '<pre>'.(string) $error.'</pre>' );
		echo( '<hr>' );
	}
	
	//
	// Save incomplete path.
	//
	try
	{
		echo( '<h4>Save incomplete path</h4>' );
		echo( '<h5>$tag = new MyClass();</h5>' );
		$tag = new MyClass();
		echo( '<h5>$tag->PushItem( $nodeTrait );</h5>' );
		$tag->PushItem( $nodeTrait );
		echo( '<h5>$tag->PushItem( $termPredicate );</h5>' );
		$tag->PushItem( $termPredicate );
		echo( '<h5>$status = $tag->Insert( $database );</h5>' );
		$status = $tag->Insert( $database );
		echo( '<h3><font color="red">Should have raised an exception</font></h3>' );
		echo( '<pre>' ); print_r( $tag ); echo( '</pre>' );
		echo( '<hr />' );
	}
	catch( \Exception $error )
	{
		echo( '<h5>Expected exception</h5>' );
		echo( '<pre>'.(string) $error.'</pre>' );
		echo( '<hr>' );
	}
	echo( '<hr />' );
	
	//
	// Insert complete tag.
	//
	echo( '<h4>Insert complete tag</h4>' );
	echo( '<h5>$tag = new MyClass();</h5>' );
	$tag = new MyClass();
	echo( '<h5>$tag->PushItem( $nodeTrait );</h5>' );
	$tag->PushItem( $nodeTrait );
	echo( '<h5>$tag->PushItem( $termPredicate );</h5>' );
	$tag->PushItem( $termPredicate );
	echo( '<h5>$tag->PushItem( $nodeMethod );</h5>' );
	$tag->PushItem( $nodeMethod );
	echo( '<h5>$tag->PushItem( $termPredicate );</h5>' );
	$tag->PushItem( $termPredicate );
	echo( '<h5>$tag->PushItem( $nodeScale );</h5>' );
	$tag->PushItem( $nodeScale );
	echo( '<h5>$status = $tag->Insert( $database );</h5>' );
	$status = $tag->Insert( $database );
	echo( 'Inited['.$tag->inited()
				   .'] Dirty['.$tag->dirty()
				   .'] Saved['.$tag->committed()
				   .'] Encoded['.$tag->encoded().']<br />' );
	echo( '<h5>$nodeTrait->Restore( $database );</h5>' );
	$nodeTrait->Restore( $database );
	echo( '<h5>$nodeMethod->Restore( $database );</h5>' );
	$nodeMethod->Restore( $database );
	echo( '<h5>$nodeScale->Restore( $database );</h5>' );
	$nodeScale->Restore( $database );
	echo( 'Tag<pre>' ); print_r( $tag ); echo( '</pre>' );
	echo( 'Trait node<pre>' ); print_r( (array) $nodeTrait ); echo( '</pre>' );
	echo( 'Trait term<pre>' ); print_r( $nodeTrait->LoadTerm( $database ) ); echo( '</pre>' );
	echo( 'Method node<pre>' ); print_r( (array) $nodeMethod ); echo( '</pre>' );
	echo( 'Method term<pre>' ); print_r( $nodeMethod->LoadTerm( $database ) ); echo( '</pre>' );
	echo( 'Scale node<pre>' ); print_r( (array) $nodeScale ); echo( '</pre>' );
	echo( 'Scale term<pre>' ); print_r( $nodeScale->LoadTerm( $database ) ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Get trait node.
	//
	echo( '<h4>Get trait node</h4>' );
	echo( '<h5>$node = $tag->GetTraitNode();</h5>' );
	$node = $tag->GetTraitNode();
	echo( '<pre>' ); print_r( $node ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Get trait term.
	//
	echo( '<h4>Get trait term</h4>' );
	echo( '<h5>$node = $tag->GetTraitTerm();</h5>' );
	$term = $tag->GetTraitTerm();
	echo( '<pre>' ); print_r( $term ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Get scale node.
	//
	echo( '<h4>Get scale node</h4>' );
	echo( '<h5>$node = $tag->GetScaleNode();</h5>' );
	$node = $tag->GetScaleNode();
	echo( '<pre>' ); print_r( $node ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Get scale term.
	//
	echo( '<h4>Get scale term</h4>' );
	echo( '<h5>$term = $tag->GetScaleTerm();</h5>' );
	$term = $tag->GetScaleTerm();
	echo( '<pre>' ); print_r( $term ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Get method nodes.
	//
	echo( '<h4>Get method nodes</h4>' );
	echo( '<h5>$nodes = $tag->GetMethodNodes();</h5>' );
	$nodes = $tag->GetMethodNodes();
	echo( '<pre>' ); print_r( $nodes ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Get method terms.
	//
	echo( '<h4>Get method terms</h4>' );
	echo( '<h5>$terms = $tag->GetMethodTerms();</h5>' );
	$terms = $tag->GetMethodTerms();
	echo( '<pre>' ); print_r( $terms ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Delete tag.
	//
	echo( '<h4>Delete tag</h4>' );
	echo( '<h5>$status = $tag->Delete( $database );</h5>' );
	$status = $tag->Delete( $database );
	echo( 'Inited['.$tag->inited()
				   .'] Dirty['.$tag->dirty()
				   .'] Saved['.$tag->committed()
				   .'] Encoded['.$tag->encoded().']<br />' );
	echo( '<h5>$nodeTrait->Restore( $database );</h5>' );
	$nodeTrait->Restore( $database );
	echo( '<h5>$nodeMethod->Restore( $database );</h5>' );
	$nodeMethod->Restore( $database );
	echo( '<h5>$nodeScale->Restore( $database );</h5>' );
	$nodeScale->Restore( $database );
	echo( 'Tag<pre>' ); print_r( $tag ); echo( '</pre>' );
	echo( 'Trait node<pre>' ); print_r( (array) $nodeTrait ); echo( '</pre>' );
	echo( 'Trait term<pre>' ); print_r( $nodeTrait->LoadTerm( $database ) ); echo( '</pre>' );
	echo( 'Method node<pre>' ); print_r( (array) $nodeMethod ); echo( '</pre>' );
	echo( 'Method term<pre>' ); print_r( $nodeMethod->LoadTerm( $database ) ); echo( '</pre>' );
	echo( 'Scale node<pre>' ); print_r( (array) $nodeScale ); echo( '</pre>' );
	echo( 'Scale term<pre>' ); print_r( $nodeScale->LoadTerm( $database ) ); echo( '</pre>' );
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
