<?php
	
/**
 * {@link CMongoQueryStatement.php Query} object test suite.
 *
 * This file contains routines to test and demonstrate the behaviour of the
 * base object {@link CMongoQueryStatement class}.
 *
 *	@package	Test
 *	@subpackage	Persistence
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 20/09/2012
 */

/*=======================================================================================
 *																						*
 *							test_CMongoQueryStatement.php								*
 *																						*
 *======================================================================================*/

//
// Global includes.
//
require_once( '/Library/WebServer/Library/PHPWrapper/includes.inc.php' );

//
// Class includes.
//
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CMongoQueryStatement.php" );


/*=======================================================================================
 *	TEST QUERY STATEMENT OBJECT															*
 *======================================================================================*/
 
//
// TRY BLOCK.
//
try
{
	//
	// Instantiate empty query.
	//
	echo( '<i>$query = new CMongoQuery();</i><br>' );
	$query = new CQuery();
	echo( '<pre>' ); print_r( $query ); echo( '</pre>' );
	echo( '<hr>' );
	
	//
	// Instantiate empty object.
	//
	echo( '<i>$test = new CMongoQueryStatement();</i><br>' );
	$test = new CMongoQueryStatement();
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<hr>' );
	
	//
	// Instantiate typeless object.
	//
	echo( '<i>$test = new CMongoQueryStatement( "SUBJECT", kOPERATOR_EQUAL, kTYPE_STAMP, "2010-01-15 00:00:00" );</i><br>' );
	$test = new CMongoQueryStatement( "SUBJECT", kOPERATOR_EQUAL, kTYPE_STAMP, "2010-01-15 00:00:00" );
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<i>$query->AppendStatement( $test );</i><br>' );
	$query->AppendStatement( $test );
	echo( '<pre>' ); print_r( $query ); echo( '</pre>' );
	echo( '<hr>' );
	
	//
	// Instantiate disabled range statement.
	//
	echo( '<i>$test = CMongoQueryStatement::Disabled( "SUBJECT", kTYPE_INT32, 10, 20 );</i><br>' );
	$test = CMongoQueryStatement::Disabled( "SUBJECT", 10, NULL, 20 );
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<i>$query->AppendStatement( $test );</i><br>' );
	$query->AppendStatement( $test );
	echo( '<pre>' ); print_r( $query ); echo( '</pre>' );
	echo( '<hr>' );
	
	//
	// Instantiate disabled typed range statement.
	//
	echo( '<i>$test = CMongoQueryStatement::Disabled( "SUBJECT", "2010-01-15 00:00:00"), NULL, "2012-04-03 12:30:15" );</i><br>' );
	$test = CMongoQueryStatement::Disabled( "SUBJECT", 
									   "2010-01-15 00:00:00",
									   NULL,
									   "2012-04-03 12:30:15" );
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<i>$query->AppendStatement( $test, kOPERATOR_OR );</i><br>' );
	$query->AppendStatement( $test, kOPERATOR_OR );
	echo( '<pre>' ); print_r( $query ); echo( '</pre>' );
	echo( '<hr>' );
	
	//
	// Instantiate equality statement.
	//
	echo( '<i>$test = CMongoQueryStatement::Equals( "SUB", 10.2 );</i><br>' );
	$test = CMongoQueryStatement::Equals( "SUB", 10.2 );
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<i>$query->AppendStatement( $test );</i><br>' );
	$query->AppendStatement( $test );
	echo( '<hr>' );
	
	//
	// Instantiate inequality statement.
	//
	echo( '<i>$test = CMongoQueryStatement::NotEquals( "SUB", "123", kTYPE_INT32 );</i><br>' );
	$test = CMongoQueryStatement::NotEquals( "SUB", "123", kTYPE_INT32 );
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<i>$query->AppendStatement( $test );</i><br>' );
	$query->AppendStatement( $test );
	echo( '<hr>' );
	
	//
	// Instantiate LIKE statement.
	//
	echo( '<i>$test = CMongoQueryStatement::Like( "SUB", 123 );</i><br>' );
	$test = CMongoQueryStatement::Like( "SUB", 123 );
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<i>$query->AppendStatement( $test );</i><br>' );
	$query->AppendStatement( $test );
	echo( '<hr>' );
	
	//
	// Instantiate not LIKE statement.
	//
	echo( '<i>$test = CMongoQueryStatement::NotLike( "SUB", 123 );</i><br>' );
	$test = CMongoQueryStatement::NotLike( "SUB", 123 );
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<i>$query->AppendStatement( $test );</i><br>' );
	$query->AppendStatement( $test );
	echo( '<hr>' );
	
	//
	// Instantiate prefix statement.
	//
	echo( '<i>$test = CMongoQueryStatement::Prefix( "SUB", 123 );</i><br>' );
	$test = CMongoQueryStatement::Prefix( "SUB", 123 );
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<i>$query->AppendStatement( $test );</i><br>' );
	$query->AppendStatement( $test );
	echo( '<hr>' );
	
	//
	// Instantiate contains statement.
	//
	echo( '<i>$test = CMongoQueryStatement::Contains( "SUB", 123 );</i><br>' );
	$test = CMongoQueryStatement::Contains( "SUB", 123 );
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<i>$query->AppendStatement( $test );</i><br>' );
	$query->AppendStatement( $test );
	echo( '<hr>' );
	
	//
	// Instantiate suffix statement.
	//
	echo( '<i>$test = CMongoQueryStatement::Suffix( "SUB", 123 );</i><br>' );
	$test = CMongoQueryStatement::Suffix( "SUB", 123 );
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<hr>' );
	
	//
	// Instantiate regular expression statement.
	//
	echo( '<i>$test = CMongoQueryStatement::Regex( "SUB", \'/^pippo$/i\' );</i><br>' );
	$test = CMongoQueryStatement::Regex( "SUB", '/^pippo$/i' );
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<i>$query->AppendStatement( $test );</i><br>' );
	$query->AppendStatement( $test );
	echo( '<hr>' );
	
	//
	// Instantiate less than.
	//
	echo( '<i>$test = CMongoQueryStatement::Less( "SUB", 12.3 );</i><br>' );
	$test = CMongoQueryStatement::Less( "SUB", 12.3 );
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<i>$query->AppendStatement( $test );</i><br>' );
	$query->AppendStatement( $test );
	echo( '<hr>' );
	
	//
	// Instantiate less than or equal.
	//
	echo( '<i>$test = CMongoQueryStatement::LessEqual( "SUB", "baba" );</i><br>' );
	$test = CMongoQueryStatement::LessEqual( "SUB", 'baba' );
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<i>$query->AppendStatement( $test );</i><br>' );
	$query->AppendStatement( $test );
	echo( '<hr>' );
	
	//
	// Instantiate greater than.
	//
	echo( '<i>$test = CMongoQueryStatement::Great( "SUB", 12.3 );</i><br>' );
	$test = CMongoQueryStatement::Great( "SUB", 12.3 );
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<i>$query->AppendStatement( $test );</i><br>' );
	$query->AppendStatement( $test );
	echo( '<hr>' );
	
	//
	// Instantiate greater than or equal.
	//
	echo( '<i>$test = CMongoQueryStatement::GreatEqual( "SUB", "baba" );</i><br>' );
	$test = CMongoQueryStatement::GreatEqual( "SUB", "baba" );
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<i>$query->AppendStatement( $test );</i><br>' );
	$query->AppendStatement( $test );
	echo( '<hr>' );
	
	//
	// Instantiate range inclusive.
	//
	echo( '<i>$test = CMongoQueryStatement::RangeInclusive( "SUB", 10, 20 );</i><br>' );
	$test = CMongoQueryStatement::RangeInclusive( "SUB", 10, 20 );
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<i>$query->AppendStatement( $test );</i><br>' );
	$query->AppendStatement( $test );
	echo( '<hr>' );
	
	//
	// Instantiate range exclusive.
	//
	echo( '<i>$test = CMongoQueryStatement::RangeExclusive( "SUB", 10, 20 );</i><br>' );
	$test = CMongoQueryStatement::RangeExclusive( "SUB", 10, 20 );
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<i>$query->AppendStatement( $test );</i><br>' );
	$query->AppendStatement( $test );
	echo( '<hr>' );
	
	//
	// Instantiate NULL.
	//
	echo( '<i>$test = CMongoQueryStatement::Missing( "SUB" );</i><br>' );
	$test = CMongoQueryStatement::Missing( "SUB" );
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<i>$query->AppendStatement( $test );</i><br>' );
	$query->AppendStatement( $test );
	echo( '<hr>' );
	
	//
	// Instantiate not NULL.
	//
	echo( '<i>$test = CMongoQueryStatement::Exists( "SUB" );</i><br>' );
	$test = CMongoQueryStatement::Exists( "SUB" );
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<i>$query->AppendStatement( $test );</i><br>' );
	$query->AppendStatement( $test );
	echo( '<hr>' );
	
	//
	// Instantiate member.
	//
	echo( '<i>$test = CMongoQueryStatement::Member( "SUB", array( "2010-01-15 00:00:00", "2010-02-15 00:00:00", "2011-02-15 00:00:00" ) );</i><br>' );
	$test = CMongoQueryStatement::Member( "SUB", array( "2010-01-15 00:00:00", "2010-02-15 00:00:00", "2011-02-15 00:00:00" ) );
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<i>$query->AppendStatement( $test );</i><br>' );
	$query->AppendStatement( $test );
	echo( '<hr>' );
	
	//
	// Instantiate not member.
	//
	$list = array( new MongoDate( strtotime("2010-01-15 00:00:00") ),
				   new MongoDate( strtotime("2010-02-15 00:00:00") ),
				   new MongoDate( strtotime("2011-02-15 00:00:00") ),
				   new MongoDate() );
	echo( '<i>$test = CMongoQueryStatement::NotMember( "SUB", $list );</i><br>' );
	$test = CMongoQueryStatement::NotMember( "SUB", $list );
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<i>$query->AppendStatement( $test );</i><br>' );
	$query->AppendStatement( $test );
	echo( '<hr>' );
	
	//
	// Instantiate all.
	//
	$list = array( new MongoDate( strtotime("2010-01-15 00:00:00") ),
				   new MongoDate( strtotime("2010-02-15 00:00:00") ),
				   new MongoDate( strtotime("2011-02-15 00:00:00") ),
				   new MongoDate() );
	echo( '<i>$test = CMongoQueryStatement::All( "SUB", $list );</i><br>' );
	$test = CMongoQueryStatement::All( "SUB", $list );
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<i>$query->AppendStatement( $test );</i><br>' );
	$query->AppendStatement( $test );
	echo( '<hr>' );
	
	//
	// Instantiate not all.
	//
	$list = array( new MongoDate( strtotime("2010-01-15 00:00:00") ),
				   new MongoDate( strtotime("2010-02-15 00:00:00") ),
				   new MongoDate( strtotime("2011-02-15 00:00:00") ),
				   new MongoDate() );
	echo( '<i>$test = CMongoQueryStatement::NotAll( "SUB", $list );</i><br>' );
	$test = CMongoQueryStatement::NotAll( "SUB", $list );
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<i>$query->AppendStatement( $test );</i><br>' );
	$query->AppendStatement( $test );
	echo( '<hr>' );
	
	//
	// Instantiate expression.
	//
	echo( '<i>$test = CMongoQueryStatement::Expression( "SUB", \'E=MC2\' );</i><br>' );
	$test = CMongoQueryStatement::Expression( "SUB", 'E=MC2' );
	echo( '<pre>' ); print_r( $test ); echo( '</pre>' );
	echo( '<i>$query->AppendStatement( $test );</i><br>' );
	$query->AppendStatement( $test );
	echo( '<hr>' );
	
	echo( '<h3>DONE</h3>' );
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

?>
