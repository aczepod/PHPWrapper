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
require_once( 'includes.inc.php' );

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
define( 'kDEBUG_PARENT', 		FALSE );

/*=======================================================================================
 *	VERBOSE FLAG																		*
 *======================================================================================*/

/**
 * Verbnose flag.
 *
 * If set, the method will echo all created elements.
 */
define( "kOPTION_VERBOSE",		FALSE );


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
	echo( '<h5>$test = new MyClass();</h5>' );
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
	// Load default terms.
	//
	$dir = "/Library/WebServer/Library/PHPWrapper/defines";
	$files = array( "$dir/Namespaces.xml", "$dir/Terms.xml", "$dir/Categories.xml",
					"$dir/Attributes.xml", "$dir/Predicates.xml", "$dir/Types.xml",
					"$dir/Kinds.xml", "$dir/Operators.xml", "$dir/Status.xml",
					"$dir/Inputs.xml", "$dir/Term.xml", "$dir/Node.xml", "$dir/Edge.xml",
					"$dir/Tag.xml", "$dir/User.xml" );
	echo( '<h4>Load default terms</h4>' );
	echo( '<h5>$test = new MyClass( $database );</h5>' );
	$test = new MyClass( $database );
	echo( '<h5>$test->LoadXMLOntologyFile( $files );</h5>' );
	$test->LoadXMLOntologyFile( $files );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Test term insert.
	//
	echo( '<h5>$test = new MyClass( $database );</h5>' );
	$test = new MyClass( $database );
	echo( '<h5>$test->LoadXMLOntologyFile( "/Library/WebServer/Library/PHPWrapper/examples/TERM_INSERT.xml" );</h5>' );
	$test->LoadXMLOntologyFile( "/Library/WebServer/Library/PHPWrapper/examples/TERM_INSERT.xml" );
	echo( '<hr />' );
	
	//
	// Test term modify.
	//
	echo( '<h5>$test = new MyClass( $database );</h5>' );
	$test = new MyClass( $database );
	echo( '<h5>$test->LoadXMLOntologyFile( "/Library/WebServer/Library/PHPWrapper/examples/TERM_MODIFY.xml" );</h5>' );
	$test->LoadXMLOntologyFile( "/Library/WebServer/Library/PHPWrapper/examples/TERM_MODIFY.xml" );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Test node insert.
	//
	echo( '<h5>$test = new MyClass( $database );</h5>' );
	$test = new MyClass( $database );
	echo( '<h5>$test->LoadXMLOntologyFile( "/Library/WebServer/Library/PHPWrapper/examples/NODE_INSERT.xml" );</h5>' );
	$test->LoadXMLOntologyFile( "/Library/WebServer/Library/PHPWrapper/examples/NODE_INSERT.xml" );
	echo( '<hr />' );
	
	//
	// Test node modify.
	//
	echo( '<h5>$test = new MyClass( $database );</h5>' );
	$test = new MyClass( $database );
	echo( '<h5>$test->LoadXMLOntologyFile( "/Library/WebServer/Library/PHPWrapper/examples/NODE_MODIFY.xml" );</h5>' );
	$test->LoadXMLOntologyFile( "/Library/WebServer/Library/PHPWrapper/examples/NODE_MODIFY.xml" );
	echo( '<hr />' );
	echo( '<hr />' );

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
	echo( '<hr />' );

	//
	// Initialise ontology.
	//
	echo( '<h4>Initialise ontology</h4>' );
	echo( '<h5>define( "kDEFAULT_LANGUAGE", "en" );</h5>' );
	define( "kDEFAULT_LANGUAGE", "en" );
	echo( '$database->Drop();<br />' );
	$database->Drop();
	echo( '<h5>$test->InitOntology();</h5>' );
	$test->InitOntology();
	echo( '<hr />' );
	echo( '<hr />' );

	//
	// Export template array.
	//
	echo( '<h4>Export template array</h4>' );
	echo( '$database = $server->Database( "ONTOLOGY" );<br />' );
	$database = $server->Database( "ONTOLOGY" );
	echo( '<h5>$test = new MyClass( $database );</h5>' );
	$test = new MyClass( $database );
	echo( '<h5>$tmpl = $test->GetTemplateArray( "MCPD", kDEFAULT_LANGUAGE );</h5>' );
	$tmpl = $test->GetTemplateArray( "MCPD", kDEFAULT_LANGUAGE );
	echo( '<pre>' ); print_r( $tmpl ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );
}

//
// Catch exceptions.
//
catch( Exception $error )
{
	echo( CException::AsHTML( $error ) );
	echo( '<pre>'.(string) $error.'</pre>' );
	echo( '<hr>' );
}

echo( "\nDone!\n" );

?>
