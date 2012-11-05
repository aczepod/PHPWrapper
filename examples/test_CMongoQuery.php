<?php
	
/**
 * {@link CMongoQuery.php Query} object test suite.
 *
 * This file contains routines to test and demonstrate the behaviour of the
 * base object {@link CMongoQuery class}.
 *
 *	@package	Test
 *	@subpackage	Persistence
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 20/09/2012
 */

/*=======================================================================================
 *																						*
 *									test_CMongoQuery.php								*
 *																						*
 *======================================================================================*/

//
// Global includes.
//
require_once( '/Library/WebServer/Library/PHPWrapper/includes.inc.php' );

//
// Query statements.
//
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CQueryStatement.php" );

//
// Class includes.
//
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CMongoQuery.php" );


/*=======================================================================================
 *	TEST QUERY STATEMENT OBJECT															*
 *======================================================================================*/
 
//
// TRY BLOCK.
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
	echo( '$container = $database->Container( "CMongoQuery" );<br />' );
	$container = $database->Container( "CMongoQuery" );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Insert disabled statement.
	//
	echo( '<h4>Insert disabled statement</h4>' );
	echo( '<h5>$query = new CMongoQuery();</h5>' );
	$query = new CMongoQuery();
	echo( '<h5>$stmt = CQueryStatement::Disabled( "SUBJECT", "2010-01-15 00:00:00", kTYPE_STAMP );</h5>' );
	$stmt = CQueryStatement::Disabled( "SUBJECT", "2010-01-15 00:00:00", kTYPE_STAMP );
	echo( '<h5>$query->AppendStatement( $stmt );</h5>' );
	$query->AppendStatement( $stmt );
	echo( '<h5>$converted = $query->Export( $container );</h5>' );
	$converted = $query->Export( $container );
	echo( '<b>Query</b>: <pre>' ); print_r( $query ); echo( '</pre>' );
	echo( '<b>Converted</b>: <pre>' ); print_r( $converted ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Insert equals statement.
	//
	echo( '<h4>Insert equals statement</h4>' );
	echo( '<h5>$query = new CMongoQuery();</h5>' );
	$query = new CMongoQuery();
	echo( '<h5>$stmt = CQueryStatement::Equals( "SUBJECT", 10.75 );</h5>' );
	$stmt = CQueryStatement::Equals( "SUBJECT", 10.75 );
	echo( '<h5>$query->AppendStatement( $stmt );</h5>' );
	$query->AppendStatement( $stmt );
	echo( '<h5>$converted = $query->Export( $container );</h5>' );
	$converted = $query->Export( $container );
	echo( '<b>Query</b>: <pre>' ); print_r( $query ); echo( '</pre>' );
	echo( '<b>Converted</b>: <pre>' ); print_r( $converted ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Insert not equals statement.
	//
	echo( '<h4>Insert not equals statement</h4>' );
	echo( '<h5>$query = new CMongoQuery();</h5>' );
	$query = new CMongoQuery();
	echo( '<h5>$stmt = CQueryStatement::NotEquals( "SUBJECT", 10 );</h5>' );
	$stmt = CQueryStatement::NotEquals( "SUBJECT", 10 );
	echo( '<h5>$query->AppendStatement( $stmt );</h5>' );
	$query->AppendStatement( $stmt );
	echo( '<h5>$converted = $query->Export( $container );</h5>' );
	$converted = $query->Export( $container );
	echo( '<b>Query</b>: <pre>' ); print_r( $query ); echo( '</pre>' );
	echo( '<b>Converted</b>: <pre>' ); print_r( $converted ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Insert like statement.
	//
	echo( '<h4>Insert like statement</h4>' );
	echo( '<h5>$query = new CMongoQuery();</h5>' );
	$query = new CMongoQuery();
	echo( '<h5>$stmt = CQueryStatement::Like( "SUBJECT", 120 );</h5>' );
	$stmt = CQueryStatement::Like( "SUBJECT", 120 );
	echo( '<h5>$query->AppendStatement( $stmt );</h5>' );
	$query->AppendStatement( $stmt );
	echo( '<h5>$converted = $query->Export( $container );</h5>' );
	$converted = $query->Export( $container );
	echo( '<b>Query</b>: <pre>' ); print_r( $query ); echo( '</pre>' );
	echo( '<b>Converted</b>: <pre>' ); print_r( $converted ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Insert prefix statement.
	//
	echo( '<h4>Insert prefix statement</h4>' );
	echo( '<h5>$query = new CMongoQuery();</h5>' );
	$query = new CMongoQuery();
	echo( '<h5>$stmt = CQueryStatement::Prefix( "SUBJECT", "Start" );</h5>' );
	$stmt = CQueryStatement::Prefix( "SUBJECT", "Start" );
	echo( '<h5>$query->AppendStatement( $stmt );</h5>' );
	$query->AppendStatement( $stmt );
	echo( '<h5>$converted = $query->Export( $container );</h5>' );
	$converted = $query->Export( $container );
	echo( '<b>Query</b>: <pre>' ); print_r( $query ); echo( '</pre>' );
	echo( '<b>Converted</b>: <pre>' ); print_r( $converted ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Insert case insensitive prefix statement.
	//
	echo( '<h4>Insert prefix statement</h4>' );
	echo( '<h5>$query = new CMongoQuery();</h5>' );
	$query = new CMongoQuery();
	echo( '<h5>$stmt = CQueryStatement::PrefixNoCase( "SUBJECT", "start" );</h5>' );
	$stmt = CQueryStatement::PrefixNoCase( "SUBJECT", "start" );
	echo( '<h5>$query->AppendStatement( $stmt );</h5>' );
	$query->AppendStatement( $stmt );
	echo( '<h5>$converted = $query->Export( $container );</h5>' );
	$converted = $query->Export( $container );
	echo( '<b>Query</b>: <pre>' ); print_r( $query ); echo( '</pre>' );
	echo( '<b>Converted</b>: <pre>' ); print_r( $converted ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Insert contains statement.
	//
	echo( '<h4>Insert contains statement</h4>' );
	echo( '<h5>$query = new CMongoQuery();</h5>' );
	$query = new CMongoQuery();
	echo( '<h5>$stmt = CQueryStatement::Contains( "SUBJECT", "Something" );</h5>' );
	$stmt = CQueryStatement::Contains( "SUBJECT", "Something" );
	echo( '<h5>$query->AppendStatement( $stmt );</h5>' );
	$query->AppendStatement( $stmt );
	echo( '<h5>$converted = $query->Export( $container );</h5>' );
	$converted = $query->Export( $container );
	echo( '<b>Query</b>: <pre>' ); print_r( $query ); echo( '</pre>' );
	echo( '<b>Converted</b>: <pre>' ); print_r( $converted ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Insert case insensitive contains statement.
	//
	echo( '<h4>Insert case insensitive contains statement</h4>' );
	echo( '<h5>$query = new CMongoQuery();</h5>' );
	$query = new CMongoQuery();
	echo( '<h5>$stmt = CQueryStatement::ContainsNoCase( "SUBJECT", "something" );</h5>' );
	$stmt = CQueryStatement::ContainsNoCase( "SUBJECT", "something" );
	echo( '<h5>$query->AppendStatement( $stmt );</h5>' );
	$query->AppendStatement( $stmt );
	echo( '<h5>$converted = $query->Export( $container );</h5>' );
	$converted = $query->Export( $container );
	echo( '<b>Query</b>: <pre>' ); print_r( $query ); echo( '</pre>' );
	echo( '<b>Converted</b>: <pre>' ); print_r( $converted ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Insert suffix statement.
	//
	echo( '<h4>Insert suffix statement</h4>' );
	echo( '<h5>$query = new CMongoQuery();</h5>' );
	$query = new CMongoQuery();
	echo( '<h5>$stmt = CQueryStatement::Suffix( "SUBJECT", "Ends" );</h5>' );
	$stmt = CQueryStatement::Suffix( "SUBJECT", "Ends" );
	echo( '<h5>$query->AppendStatement( $stmt );</h5>' );
	$query->AppendStatement( $stmt );
	echo( '<h5>$converted = $query->Export( $container );</h5>' );
	$converted = $query->Export( $container );
	echo( '<b>Query</b>: <pre>' ); print_r( $query ); echo( '</pre>' );
	echo( '<b>Converted</b>: <pre>' ); print_r( $converted ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Insert case insensitive suffix statement.
	//
	echo( '<h4>Insert case insensitive suffix statement</h4>' );
	echo( '<h5>$query = new CMongoQuery();</h5>' );
	$query = new CMongoQuery();
	echo( '<h5>$stmt = CQueryStatement::SuffixNoCase( "SUBJECT", "ends" );</h5>' );
	$stmt = CQueryStatement::SuffixNoCase( "SUBJECT", "ends" );
	echo( '<h5>$query->AppendStatement( $stmt );</h5>' );
	$query->AppendStatement( $stmt );
	echo( '<h5>$converted = $query->Export( $container );</h5>' );
	$converted = $query->Export( $container );
	echo( '<b>Query</b>: <pre>' ); print_r( $query ); echo( '</pre>' );
	echo( '<b>Converted</b>: <pre>' ); print_r( $converted ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Insert regular expression statement.
	//
	echo( '<h4>Insert regular expression statement</h4>' );
	echo( '<h5>$query = new CMongoQuery();</h5>' );
	$query = new CMongoQuery();
	echo( '<h5>$stmt = CQueryStatement::Regex( "SUBJECT", "/^pippo$/i" );</h5>' );
	$stmt = CQueryStatement::Regex( "SUBJECT", "/^pippo$/i" );
	echo( '<h5>$query->AppendStatement( $stmt );</h5>' );
	$query->AppendStatement( $stmt );
	echo( '<h5>$converted = $query->Export( $container );</h5>' );
	$converted = $query->Export( $container );
	echo( '<b>Query</b>: <pre>' ); print_r( $query ); echo( '</pre>' );
	echo( '<b>Converted</b>: <pre>' ); print_r( $converted ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Insert less than statement.
	//
	echo( '<h4>Insert less than statement</h4>' );
	echo( '<h5>$query = new CMongoQuery();</h5>' );
	$query = new CMongoQuery();
	echo( '<h5>$stmt = CQueryStatement::Less( "SUBJECT", 25 );</h5>' );
	$stmt = CQueryStatement::Less( "SUBJECT", 25 );
	echo( '<h5>$query->AppendStatement( $stmt );</h5>' );
	$query->AppendStatement( $stmt );
	echo( '<h5>$converted = $query->Export( $container );</h5>' );
	$converted = $query->Export( $container );
	echo( '<b>Query</b>: <pre>' ); print_r( $query ); echo( '</pre>' );
	echo( '<b>Converted</b>: <pre>' ); print_r( $converted ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Insert less than or equal statement.
	//
	echo( '<h4>Insert less than or equal statement</h4>' );
	echo( '<h5>$query = new CMongoQuery();</h5>' );
	$query = new CMongoQuery();
	echo( '<h5>$stmt = CQueryStatement::LessEqual( "SUBJECT", "2010-01-15 23:15:47", kTYPE_STAMP );</h5>' );
	$stmt = CQueryStatement::LessEqual( "SUBJECT", "2010-01-15 23:15:47", kTYPE_STAMP );
	echo( '<h5>$query->AppendStatement( $stmt );</h5>' );
	$query->AppendStatement( $stmt );
	echo( '<h5>$converted = $query->Export( $container );</h5>' );
	$converted = $query->Export( $container );
	echo( '<b>Query</b>: <pre>' ); print_r( $query ); echo( '</pre>' );
	echo( '<b>Converted</b>: <pre>' ); print_r( $converted ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Insert greater than statement.
	//
	echo( '<h4>Insert greater than statement</h4>' );
	echo( '<h5>$query = new CMongoQuery();</h5>' );
	$query = new CMongoQuery();
	echo( '<h5>$stmt = CQueryStatement::Great( "SUBJECT", 25.4 );</h5>' );
	$stmt = CQueryStatement::Great( "SUBJECT", 25.4 );
	echo( '<h5>$query->AppendStatement( $stmt );</h5>' );
	$query->AppendStatement( $stmt );
	echo( '<h5>$converted = $query->Export( $container );</h5>' );
	$converted = $query->Export( $container );
	echo( '<b>Query</b>: <pre>' ); print_r( $query ); echo( '</pre>' );
	echo( '<b>Converted</b>: <pre>' ); print_r( $converted ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Insert greater than or equal statement.
	//
	echo( '<h4>Insert greater than or equal statement</h4>' );
	echo( '<h5>$query = new CMongoQuery();</h5>' );
	$query = new CMongoQuery();
	echo( '<h5>$stmt = CQueryStatement::GreatEqual( "SUBJECT", "2010-01-15 23:15:47", kTYPE_STAMP );</h5>' );
	$stmt = CQueryStatement::GreatEqual( "SUBJECT", "2010-01-15 23:15:47", kTYPE_STAMP );
	echo( '<h5>$query->AppendStatement( $stmt );</h5>' );
	$query->AppendStatement( $stmt );
	echo( '<h5>$converted = $query->Export( $container );</h5>' );
	$converted = $query->Export( $container );
	echo( '<b>Query</b>: <pre>' ); print_r( $query ); echo( '</pre>' );
	echo( '<b>Converted</b>: <pre>' ); print_r( $converted ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Insert range inclusive statement.
	//
	echo( '<h4>Insert range inclusive statement</h4>' );
	echo( '<h5>$query = new CMongoQuery();</h5>' );
	$query = new CMongoQuery();
	echo( '<h5>$stmt = CQueryStatement::RangeInclusive( "SUBJECT", 10, 20 );</h5>' );
	$stmt = CQueryStatement::RangeInclusive( "SUBJECT", 10, 20 );
	echo( '<h5>$query->AppendStatement( $stmt );</h5>' );
	$query->AppendStatement( $stmt );
	echo( '<h5>$converted = $query->Export( $container );</h5>' );
	$converted = $query->Export( $container );
	echo( '<b>Query</b>: <pre>' ); print_r( $query ); echo( '</pre>' );
	echo( '<b>Converted</b>: <pre>' ); print_r( $converted ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Insert range exclusive statement.
	//
	echo( '<h4>Insert range exclusive statement</h4>' );
	echo( '<h5>$query = new CMongoQuery();</h5>' );
	$query = new CMongoQuery();
	echo( '<h5>$stmt = CQueryStatement::RangeExclusive( "SUBJECT", 10, 20 );</h5>' );
	$stmt = CQueryStatement::RangeExclusive( "SUBJECT", 10, 20 );
	echo( '<h5>$query->AppendStatement( $stmt );</h5>' );
	$query->AppendStatement( $stmt );
	echo( '<h5>$converted = $query->Export( $container );</h5>' );
	$converted = $query->Export( $container );
	echo( '<b>Query</b>: <pre>' ); print_r( $query ); echo( '</pre>' );
	echo( '<b>Converted</b>: <pre>' ); print_r( $converted ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Insert not exists statement.
	//
	echo( '<h4>Insert not exists statement</h4>' );
	echo( '<h5>$query = new CMongoQuery();</h5>' );
	$query = new CMongoQuery();
	echo( '<h5>$stmt = CQueryStatement::Missing( "SUBJECT" );</h5>' );
	$stmt = CQueryStatement::Missing( "SUBJECT" );
	echo( '<h5>$query->AppendStatement( $stmt );</h5>' );
	$query->AppendStatement( $stmt );
	echo( '<h5>$converted = $query->Export( $container );</h5>' );
	$converted = $query->Export( $container );
	echo( '<b>Query</b>: <pre>' ); print_r( $query ); echo( '</pre>' );
	echo( '<b>Converted</b>: <pre>' ); print_r( $converted ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Insert exists statement.
	//
	echo( '<h4>Insert exists statement</h4>' );
	echo( '<h5>$query = new CMongoQuery();</h5>' );
	$query = new CMongoQuery();
	echo( '<h5>$stmt = CQueryStatement::Exists( "SUBJECT" );</h5>' );
	$stmt = CQueryStatement::Exists( "SUBJECT" );
	echo( '<h5>$query->AppendStatement( $stmt );</h5>' );
	$query->AppendStatement( $stmt );
	echo( '<h5>$converted = $query->Export( $container );</h5>' );
	$converted = $query->Export( $container );
	echo( '<b>Query</b>: <pre>' ); print_r( $query ); echo( '</pre>' );
	echo( '<b>Converted</b>: <pre>' ); print_r( $converted ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Insert member of statement.
	//
	echo( '<h4>Insert member of statement</h4>' );
	echo( '<h5>$query = new CMongoQuery();</h5>' );
	$query = new CMongoQuery();
	echo( '<h5>$stmt = CQueryStatement::Member( "SUBJECT", array( 1, 2, 3 ) );</h5>' );
	$stmt = CQueryStatement::Member( "SUBJECT", array( 1, 2, 3 ) );
	echo( '<h5>$query->AppendStatement( $stmt );</h5>' );
	$query->AppendStatement( $stmt );
	echo( '<h5>$converted = $query->Export( $container );</h5>' );
	$converted = $query->Export( $container );
	echo( '<b>Query</b>: <pre>' ); print_r( $query ); echo( '</pre>' );
	echo( '<b>Converted</b>: <pre>' ); print_r( $converted ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Insert member of statement.
	//
	echo( '<h4>Insert member of statement</h4>' );
	echo( '<h5>$query = new CMongoQuery();</h5>' );
	$query = new CMongoQuery();
	echo( '<h5>$stmt = CQueryStatement::NotMember( "SUBJECT", array( 10.7, 2.5, 4 ) );</h5>' );
	$stmt = CQueryStatement::NotMember( "SUBJECT", array( 10.7, 2.5, 4 ) );
	echo( '<h5>$query->AppendStatement( $stmt );</h5>' );
	$query->AppendStatement( $stmt );
	echo( '<h5>$converted = $query->Export( $container );</h5>' );
	$converted = $query->Export( $container );
	echo( '<b>Query</b>: <pre>' ); print_r( $query ); echo( '</pre>' );
	echo( '<b>Converted</b>: <pre>' ); print_r( $converted ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Insert all statement.
	//
	echo( '<h4>Insert all statement</h4>' );
	echo( '<h5>$query = new CMongoQuery();</h5>' );
	$query = new CMongoQuery();
	echo( '<h5>$stmt = CQueryStatement::All( "SUBJECT", array( new MongoDate(), new MongoDate( strtotime( "2010-01-15 00:00:00" ) ) ), kTYPE_STAMP );</h5>' );
	$stmt = CQueryStatement::All( "SUBJECT", array( new MongoDate(), new MongoDate( strtotime( "2010-01-15 00:00:00" ) ) ), kTYPE_STAMP );
	echo( '<h5>$query->AppendStatement( $stmt );</h5>' );
	$query->AppendStatement( $stmt );
	echo( '<h5>$converted = $query->Export( $container );</h5>' );
	$converted = $query->Export( $container );
	echo( '<b>Query</b>: <pre>' ); print_r( $query ); echo( '</pre>' );
	echo( '<b>Converted</b>: <pre>' ); print_r( $converted ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Test data conversions.
	//
	echo( '<h4>Test data conversions</h4>' );
	echo( '<h5>$query = new CMongoQuery();</h5>' );
	$query = new CMongoQuery();
	echo( '<h5>$stmt = CQueryStatement::Equals( "BINARY", new CDataTypeBinary( md5( "test", TRUE ) ) );</h5>' );
	$stmt = CQueryStatement::Equals( "SUBJECT", new CDataTypeBinary( md5( "test", TRUE ) ) );
	echo( '<h5>$query->AppendStatement( $stmt, kOPERATOR_OR );</h5>' );
	$query->AppendStatement( $stmt, kOPERATOR_OR );
	echo( '<h5>$stmt = CQueryStatement::Equals( "BIGINT", new CDataTypeInt64( 120 ), kTYPE_INT64 );</h5>' );
	$stmt = CQueryStatement::Equals( "BIGINT", new CDataTypeInt64( 120 ), kTYPE_INT64 );
	echo( '<h5>$query->AppendStatement( $stmt, kOPERATOR_OR );</h5>' );
	$query->AppendStatement( $stmt, kOPERATOR_OR );
	echo( '<h5>$stmt = CQueryStatement::Equals( "STAMP", new CDataTypeStamp( "12/07/2012" ) );</h5>' );
	$stmt = CQueryStatement::Equals( "BIGINT", new CDataTypeStamp( "12/07/2012" ) );
	echo( '<h5>$query->AppendStatement( $stmt, kOPERATOR_OR );</h5>' );
	$query->AppendStatement( $stmt, kOPERATOR_OR );
	echo( '<h5>$converted = $query->Export( $container );</h5>' );
	$converted = $query->Export( $container );
	echo( '<b>Query</b>: <pre>' ); print_r( $query ); echo( '</pre>' );
	echo( '<b>Converted</b>: <pre>' ); print_r( $converted ); echo( '</pre>' );
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
