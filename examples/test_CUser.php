<?php

/**
 * {@link CUser.php Base} object test suite.
 *
 * This file contains routines to test and demonstrate the behaviour of the
 * base object {@link CUser class}.
 *
 *	@package	Test
 *	@subpackage	Framework
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 04/09/2012
 */

/*=======================================================================================
 *																						*
 *									test_CUser.php										*
 *																						*
 *======================================================================================*/

//
// Global includes.
//
require_once( 'includes.inc.php' );

//
// Class includes.
//
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CUser.php" );


/*=======================================================================================
 *	TEST CLASS																			*
 *======================================================================================*/
 
//
// Test class definition.
//
class MyClass extends CUser
{
	//
	// Utilities to show protected data.
	//
	public function inited()	{	return ( $this->_IsInited() ) ? 'Y' : 'N';		}
	public function dirty()		{	return ( $this->_IsDirty() ) ? 'Y' : 'N';		}
	public function committed()	{	return ( $this->_IsCommitted() ) ? 'Y' : 'N';	}
	public function encoded()	{	return ( $this->_IsEncoded() ) ? 'Y' : 'N';		}
	//
	// Resolve default container.
	//
	static function DefaultDatabase( CServer $theServer )
		{	return $theServer->Database( "TEST" );	}
	static function DefaultContainer( CDatabase $theDatabase )
		{	return $theDatabase->Container( "CUser" );	}
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
		echo( '<hr />' );
	}

	//
	// Insert unitialised object.
	//
	try
	{
		echo( '<h4>Insert uninitialized object</h4>' );
		echo( '<h5>$user = new MyClass();</h5>' );
		$user = new MyClass();
		echo( 'Inited['.$user->inited()
					   .'] Dirty['.$user->dirty()
					   .'] Saved['.$user->committed()
					   .'] Encoded['.$user->encoded().']<br />' );
		echo( '<h5>$status = $user->Insert( $database );</h5>' );
		$status = $user->Insert( $database );
		echo( '<h3><font color="red">Should have raised an exception</font></h3>' );
		echo( '<pre>' ); print_r( $user ); echo( '</pre>' );
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
	// Load manager.
	//
	echo( '<h4>Load manager</h4>' );
	echo( '<h5>$manager = new MyClass();</h5>' );
	$manager = new MyClass();
	echo( '<h5>$manager->Name( "Milko Škofič" );</h5>' );
	$manager->Name( "Milko Škofič" );
	echo( '<h5>$manager->Code( "MANAGER" );</h5>' );
	$manager->Code( "MANAGER" );
	echo( '<h5>$manager->Pass( "PASS" );</h5>' );
	$manager->Pass( "PASS" );
	echo( '<h5>$manager->Mail( "m.skofic@cgiar.org" );</h5>' );
	$manager->Mail( "m.skofic@cgiar.org" );
	echo( '<h5>$manager->Profile( "ADMIN", TRUE );</h5>' );
	$manager->Profile( "ADMIN", TRUE );
	echo( '<h5>$manager->Profile( "DATASET", TRUE );</h5>' );
	$manager->Profile( "DATASET", TRUE );
	echo( '<h5>$manager->Profile( "CURATE", TRUE );</h5>' );
	$manager->Profile( "CURATE", TRUE );
	echo( '<h5>$manager->Domain( "EURISCO", TRUE );</h5>' );
	$manager->Domain( "EURISCO", TRUE );
	echo( '<pre>' ); print_r( $manager ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Load user.
	//
	echo( '<h4>Load user</h4>' );
	echo( '<h5>$user = new MyClass();</h5>' );
	$user = new MyClass();
	echo( '<h5>$user->Name( "Ungabunga" );</h5>' );
	$user->Name( "Ungabunga" );
	echo( '<h5>$user->Code( "USER" );</h5>' );
	$user->Code( "USER" );
	echo( '<h5>$user->Pass( "PASS" );</h5>' );
	$user->Pass( "PASS" );
	echo( '<h5>$user->Mail( u.bunga@cgiar.org" );</h5>' );
	$user->Mail( "u.bunga@cgiar.org" );
	echo( '<h5>$user->Profile( "DATASET", TRUE );</h5>' );
	$user->Profile( "DATASET", TRUE );
	echo( '<h5>$user->Profile( "CURATE", TRUE );</h5>' );
	$user->Profile( "CURATE", TRUE );
	echo( '<h5>$user->Manager( $manager );</h5>' );
	echo( '<h5>$user->Domain( "EURISCO", TRUE );</h5>' );
	$user->Domain( "EURISCO", TRUE );
	echo( '<h5>$user->Domain( "TIP", TRUE );</h5>' );
	$user->Domain( "TIP", TRUE );
	$user->Manager( $manager );
	echo( 'Inited['.$user->inited()
				   .'] Dirty['.$user->dirty()
				   .'] Saved['.$user->committed()
				   .'] Encoded['.$user->encoded().']<br />' );
	echo( '<h5>$status = $user->Insert( $database );</h5>' );
	$status = $user->Insert( $database );
	echo( 'User<pre>' ); print_r( $user ); echo( '</pre>' );
	echo( 'Manager<pre>' ); print_r( $manager ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Resolve user.
	//
	echo( '<h4>Resolve user</h4>' );
	echo( '<h5>$user = CUser::Resolve( $database, "MANAGER", TRUE );</h5>' );
	$user = MyClass::Resolve( $database, "MANAGER", TRUE );
	echo( '<pre>' ); print_r( $user ); echo( '</pre>' );
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
