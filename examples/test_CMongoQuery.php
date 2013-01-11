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
require_once( 'includes.inc.php' );

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
	
	//
	// Load test data.
	//
	echo( '<h4>Load test data</h4>' );
	$data = array
	(
		array( "A" => "a", "X" => "x", "Name" => "Uno", "Value" => 1, "string" => "Milko", "list" => array( 1, 2, 3 ) ),
		array( "A" => "a", "Y" => "y", "Name" => "Due", "Value" => 2, "string" => "milko", "list" => array( 1, 3 ) ),
		array( "B" => "b", "X" => "x", "Name" => "Tre", "Value" => 3, "string" => "milkO", "list" => array( 2, 3 ) ),
		array( "B" => "b", "Y" => "y", "Name" => "Quattro", "Value" => 4, "string" => "miLko" ),
		array( "A" => "a", "X" => "x", "Y" => "y", "Name" => "Cinque", "Value" => 5, "string" => "Milko Skofic" ),
		array( "A" => "a", "B" => "b", "X" => "x", "Y" => "y", "Name" => "Sei", "Value" => 6, "string" => "milko skofic" )
	);
	echo( '<pre>' ); print_r( $data ); echo( '</pre>' );
	$container->Connection()->batchInsert( $data );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Insert disabled statement.
	//
	try
	{
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
		$rs = $container->Query( $query );
		if( $count = $rs->count() )
		{
			echo( "<pre>" );
			print_r( iterator_to_array( $rs ) );
			echo( '</pre>' );
		}
		echo( '<h2>SHOULD HAVE RAISED AN EXCEPTION</h2>' );
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
	// Insert equals statement.
	//
	echo( '<h4>Insert equals statement</h4>' );
	echo( '<h5>$query = new CMongoQuery();</h5>' );
	$query = new CMongoQuery();
	echo( '<h5>$stmt = CQueryStatement::Equals( "string", "Milko" );</h5>' );
	$stmt = CQueryStatement::Equals( "string", "Milko" );
	echo( '<h5>$query->AppendStatement( $stmt );</h5>' );
	$query->AppendStatement( $stmt );
	echo( '<h5>$converted = $query->Export( $container );</h5>' );
	$converted = $query->Export( $container );
	echo( '<b>Query</b>: <pre>' ); print_r( $query ); echo( '</pre>' );
	echo( '<b>Converted</b>: <pre>' ); print_r( $converted ); echo( '</pre>' );
	$rs = $container->Query( $query );
	echo( '<b>Found: '.$rs->count().'</b><pre>' ); print_r( iterator_to_array( $rs ) ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Insert not equals statement.
	//
	echo( '<h4>Insert not equals statement</h4>' );
	echo( '<h5>$query = new CMongoQuery();</h5>' );
	$query = new CMongoQuery();
	echo( '<h5>$stmt = CQueryStatement::NotEquals( "string", "Milko" );</h5>' );
	$stmt = CQueryStatement::NotEquals( "string", "Milko" );
	echo( '<h5>$query->AppendStatement( $stmt );</h5>' );
	$query->AppendStatement( $stmt );
	echo( '<h5>$converted = $query->Export( $container );</h5>' );
	$converted = $query->Export( $container );
	echo( '<b>Query</b>: <pre>' ); print_r( $query ); echo( '</pre>' );
	echo( '<b>Converted</b>: <pre>' ); print_r( $converted ); echo( '</pre>' );
	$rs = $container->Query( $query );
	echo( '<b>Found: '.$rs->count().'</b><pre>' ); print_r( iterator_to_array( $rs ) ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Insert like statement.
	//
	echo( '<h4>Insert like statement</h4>' );
	echo( '<h5>$query = new CMongoQuery();</h5>' );
	$query = new CMongoQuery();
	echo( '<h5>$stmt = CQueryStatement::Like( "string", "milko" );</h5>' );
	$stmt = CQueryStatement::Like( "string", "milko" );
	echo( '<h5>$query->AppendStatement( $stmt );</h5>' );
	$query->AppendStatement( $stmt );
	echo( '<h5>$converted = $query->Export( $container );</h5>' );
	$converted = $query->Export( $container );
	echo( '<b>Query</b>: <pre>' ); print_r( $query ); echo( '</pre>' );
	echo( '<b>Converted</b>: <pre>' ); print_r( $converted ); echo( '</pre>' );
	$rs = $container->Query( $query );
	echo( '<b>Found: '.$rs->count().'</b><pre>' ); print_r( iterator_to_array( $rs ) ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Insert prefix statement.
	//
	echo( '<h4>Insert prefix statement</h4>' );
	echo( '<h5>$query = new CMongoQuery();</h5>' );
	$query = new CMongoQuery();
	echo( '<h5>$stmt = CQueryStatement::Prefix( "string", "M" );</h5>' );
	$stmt = CQueryStatement::Prefix( "string", "M" );
	echo( '<h5>$query->AppendStatement( $stmt );</h5>' );
	$query->AppendStatement( $stmt );
	echo( '<h5>$converted = $query->Export( $container );</h5>' );
	$converted = $query->Export( $container );
	echo( '<b>Query</b>: <pre>' ); print_r( $query ); echo( '</pre>' );
	echo( '<b>Converted</b>: <pre>' ); print_r( $converted ); echo( '</pre>' );
	$rs = $container->Query( $query );
	echo( '<b>Found: '.$rs->count().'</b><pre>' ); print_r( iterator_to_array( $rs ) ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Insert case insensitive prefix statement.
	//
	echo( '<h4>Insert case insensitive prefix statement</h4>' );
	echo( '<h5>$query = new CMongoQuery();</h5>' );
	$query = new CMongoQuery();
	echo( '<h5>$stmt = CQueryStatement::PrefixNoCase( "string", "M" );</h5>' );
	$stmt = CQueryStatement::PrefixNoCase( "string", "M" );
	echo( '<h5>$query->AppendStatement( $stmt );</h5>' );
	$query->AppendStatement( $stmt );
	echo( '<h5>$converted = $query->Export( $container );</h5>' );
	$converted = $query->Export( $container );
	echo( '<b>Query</b>: <pre>' ); print_r( $query ); echo( '</pre>' );
	echo( '<b>Converted</b>: <pre>' ); print_r( $converted ); echo( '</pre>' );
	$rs = $container->Query( $query );
	echo( '<b>Found: '.$rs->count().'</b><pre>' ); print_r( iterator_to_array( $rs ) ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Insert contains statement.
	//
	echo( '<h4>Insert contains statement</h4>' );
	echo( '<h5>$query = new CMongoQuery();</h5>' );
	$query = new CMongoQuery();
	echo( '<h5>$stmt = CQueryStatement::Contains( "string", "o s" );</h5>' );
	$stmt = CQueryStatement::Contains( "string", "o s" );
	echo( '<h5>$query->AppendStatement( $stmt );</h5>' );
	$query->AppendStatement( $stmt );
	echo( '<h5>$converted = $query->Export( $container );</h5>' );
	$converted = $query->Export( $container );
	echo( '<b>Query</b>: <pre>' ); print_r( $query ); echo( '</pre>' );
	echo( '<b>Converted</b>: <pre>' ); print_r( $converted ); echo( '</pre>' );
	$rs = $container->Query( $query );
	echo( '<b>Found: '.$rs->count().'</b><pre>' ); print_r( iterator_to_array( $rs ) ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Insert case insensitive contains statement.
	//
	echo( '<h4>Insert case insensitive contains statement</h4>' );
	echo( '<h5>$query = new CMongoQuery();</h5>' );
	$query = new CMongoQuery();
	echo( '<h5>$stmt = CQueryStatement::ContainsNoCase( "string", "o s" );</h5>' );
	$stmt = CQueryStatement::ContainsNoCase( "string", "o s" );
	echo( '<h5>$query->AppendStatement( $stmt );</h5>' );
	$query->AppendStatement( $stmt );
	echo( '<h5>$converted = $query->Export( $container );</h5>' );
	$converted = $query->Export( $container );
	echo( '<b>Query</b>: <pre>' ); print_r( $query ); echo( '</pre>' );
	echo( '<b>Converted</b>: <pre>' ); print_r( $converted ); echo( '</pre>' );
	$rs = $container->Query( $query );
	echo( '<b>Found: '.$rs->count().'</b><pre>' ); print_r( iterator_to_array( $rs ) ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Insert suffix statement.
	//
	echo( '<h4>Insert suffix statement</h4>' );
	echo( '<h5>$query = new CMongoQuery();</h5>' );
	$query = new CMongoQuery();
	echo( '<h5>$stmt = CQueryStatement::Suffix( "string", "skofic" );</h5>' );
	$stmt = CQueryStatement::Suffix( "string", "skofic" );
	echo( '<h5>$query->AppendStatement( $stmt );</h5>' );
	$query->AppendStatement( $stmt );
	echo( '<h5>$converted = $query->Export( $container );</h5>' );
	$converted = $query->Export( $container );
	echo( '<b>Query</b>: <pre>' ); print_r( $query ); echo( '</pre>' );
	echo( '<b>Converted</b>: <pre>' ); print_r( $converted ); echo( '</pre>' );
	$rs = $container->Query( $query );
	echo( '<b>Found: '.$rs->count().'</b><pre>' ); print_r( iterator_to_array( $rs ) ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Insert case insensitive suffix statement.
	//
	echo( '<h4>Insert case insensitive suffix statement</h4>' );
	echo( '<h5>$query = new CMongoQuery();</h5>' );
	$query = new CMongoQuery();
	echo( '<h5>$stmt = CQueryStatement::SuffixNoCase( "string", "skofic" );</h5>' );
	$stmt = CQueryStatement::SuffixNoCase( "string", "skofic" );
	echo( '<h5>$query->AppendStatement( $stmt );</h5>' );
	$query->AppendStatement( $stmt );
	echo( '<h5>$converted = $query->Export( $container );</h5>' );
	$converted = $query->Export( $container );
	echo( '<b>Query</b>: <pre>' ); print_r( $query ); echo( '</pre>' );
	echo( '<b>Converted</b>: <pre>' ); print_r( $converted ); echo( '</pre>' );
	$rs = $container->Query( $query );
	echo( '<b>Found: '.$rs->count().'</b><pre>' ); print_r( iterator_to_array( $rs ) ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Insert regular expression statement.
	//
	echo( '<h4>Insert regular expression statement</h4>' );
	echo( '<h5>$query = new CMongoQuery();</h5>' );
	$query = new CMongoQuery();
	echo( '<h5>$stmt = CQueryStatement::Regex( "string", "/^milko$/i" );</h5>' );
	$stmt = CQueryStatement::Regex( "string", "/^milko$/i" );
	echo( '<h5>$query->AppendStatement( $stmt );</h5>' );
	$query->AppendStatement( $stmt );
	echo( '<h5>$converted = $query->Export( $container );</h5>' );
	$converted = $query->Export( $container );
	echo( '<b>Query</b>: <pre>' ); print_r( $query ); echo( '</pre>' );
	echo( '<b>Converted</b>: <pre>' ); print_r( $converted ); echo( '</pre>' );
	$rs = $container->Query( $query );
	echo( '<b>Found: '.$rs->count().'</b><pre>' ); print_r( iterator_to_array( $rs ) ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Insert less than statement.
	//
	echo( '<h4>Insert less than statement</h4>' );
	echo( '<h5>$query = new CMongoQuery();</h5>' );
	$query = new CMongoQuery();
	echo( '<h5>$stmt = CQueryStatement::Less( "Value", 3 );</h5>' );
	$stmt = CQueryStatement::Less( "Value", 3 );
	echo( '<h5>$query->AppendStatement( $stmt );</h5>' );
	$query->AppendStatement( $stmt );
	echo( '<h5>$converted = $query->Export( $container );</h5>' );
	$converted = $query->Export( $container );
	echo( '<b>Query</b>: <pre>' ); print_r( $query ); echo( '</pre>' );
	echo( '<b>Converted</b>: <pre>' ); print_r( $converted ); echo( '</pre>' );
	$rs = $container->Query( $query );
	echo( '<b>Found: '.$rs->count().'</b><pre>' ); print_r( iterator_to_array( $rs ) ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Insert less than or equal statement.
	//
	echo( '<h4>Insert less than or equal statement</h4>' );
	echo( '<h5>$query = new CMongoQuery();</h5>' );
	$query = new CMongoQuery();
	echo( '<h5>$stmt = CQueryStatement::LessEqual( "Value", 2 );</h5>' );
	$stmt = CQueryStatement::LessEqual( "Value", 2 );
	echo( '<h5>$query->AppendStatement( $stmt );</h5>' );
	$query->AppendStatement( $stmt );
	echo( '<h5>$converted = $query->Export( $container );</h5>' );
	$converted = $query->Export( $container );
	echo( '<b>Query</b>: <pre>' ); print_r( $query ); echo( '</pre>' );
	echo( '<b>Converted</b>: <pre>' ); print_r( $converted ); echo( '</pre>' );
	$rs = $container->Query( $query );
	echo( '<b>Found: '.$rs->count().'</b><pre>' ); print_r( iterator_to_array( $rs ) ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Insert greater than statement.
	//
	echo( '<h4>Insert greater than statement</h4>' );
	echo( '<h5>$query = new CMongoQuery();</h5>' );
	$query = new CMongoQuery();
	echo( '<h5>$stmt = CQueryStatement::Great( "Value", 4 );</h5>' );
	$stmt = CQueryStatement::Great( "Value", 4 );
	echo( '<h5>$query->AppendStatement( $stmt );</h5>' );
	$query->AppendStatement( $stmt );
	echo( '<h5>$converted = $query->Export( $container );</h5>' );
	$converted = $query->Export( $container );
	echo( '<b>Query</b>: <pre>' ); print_r( $query ); echo( '</pre>' );
	echo( '<b>Converted</b>: <pre>' ); print_r( $converted ); echo( '</pre>' );
	$rs = $container->Query( $query );
	echo( '<b>Found: '.$rs->count().'</b><pre>' ); print_r( iterator_to_array( $rs ) ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Insert greater than or equal statement.
	//
	echo( '<h4>Insert greater than or equal statement</h4>' );
	echo( '<h5>$query = new CMongoQuery();</h5>' );
	$query = new CMongoQuery();
	echo( '<h5>$stmt = CQueryStatement::GreatEqual( "Value", 5 );</h5>' );
	$stmt = CQueryStatement::GreatEqual( "Value", 5 );
	echo( '<h5>$query->AppendStatement( $stmt );</h5>' );
	$query->AppendStatement( $stmt );
	echo( '<h5>$converted = $query->Export( $container );</h5>' );
	$converted = $query->Export( $container );
	echo( '<b>Query</b>: <pre>' ); print_r( $query ); echo( '</pre>' );
	echo( '<b>Converted</b>: <pre>' ); print_r( $converted ); echo( '</pre>' );
	$rs = $container->Query( $query );
	echo( '<b>Found: '.$rs->count().'</b><pre>' ); print_r( iterator_to_array( $rs ) ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Insert range inclusive statement.
	//
	echo( '<h4>Insert range inclusive statement</h4>' );
	echo( '<h5>$query = new CMongoQuery();</h5>' );
	$query = new CMongoQuery();
	echo( '<h5>$stmt = CQueryStatement::RangeInclusive( "Value", 3, 5 );</h5>' );
	$stmt = CQueryStatement::RangeInclusive( "Value", 3, 5 );
	echo( '<h5>$query->AppendStatement( $stmt );</h5>' );
	$query->AppendStatement( $stmt );
	echo( '<h5>$converted = $query->Export( $container );</h5>' );
	$converted = $query->Export( $container );
	echo( '<b>Query</b>: <pre>' ); print_r( $query ); echo( '</pre>' );
	echo( '<b>Converted</b>: <pre>' ); print_r( $converted ); echo( '</pre>' );
	$rs = $container->Query( $query );
	echo( '<b>Found: '.$rs->count().'</b><pre>' ); print_r( iterator_to_array( $rs ) ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Insert range exclusive statement.
	//
	echo( '<h4>Insert range exclusive statement</h4>' );
	echo( '<h5>$query = new CMongoQuery();</h5>' );
	$query = new CMongoQuery();
	echo( '<h5>$stmt = CQueryStatement::RangeExclusive( "Value", 3, 5 );</h5>' );
	$stmt = CQueryStatement::RangeExclusive( "Value", 3, 5 );
	echo( '<h5>$query->AppendStatement( $stmt );</h5>' );
	$query->AppendStatement( $stmt );
	echo( '<h5>$converted = $query->Export( $container );</h5>' );
	$converted = $query->Export( $container );
	echo( '<b>Query</b>: <pre>' ); print_r( $query ); echo( '</pre>' );
	echo( '<b>Converted</b>: <pre>' ); print_r( $converted ); echo( '</pre>' );
	$rs = $container->Query( $query );
	echo( '<b>Found: '.$rs->count().'</b><pre>' ); print_r( iterator_to_array( $rs ) ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Insert not exists statement.
	//
	echo( '<h4>Insert not exists statement</h4>' );
	echo( '<h5>$query = new CMongoQuery();</h5>' );
	$query = new CMongoQuery();
	echo( '<h5>$stmt = CQueryStatement::Missing( "A" );</h5>' );
	$stmt = CQueryStatement::Missing( "A" );
	echo( '<h5>$query->AppendStatement( $stmt );</h5>' );
	$query->AppendStatement( $stmt );
	echo( '<h5>$converted = $query->Export( $container );</h5>' );
	$converted = $query->Export( $container );
	echo( '<b>Query</b>: <pre>' ); print_r( $query ); echo( '</pre>' );
	echo( '<b>Converted</b>: <pre>' ); print_r( $converted ); echo( '</pre>' );
	$rs = $container->Query( $query );
	echo( '<b>Found: '.$rs->count().'</b><pre>' ); print_r( iterator_to_array( $rs ) ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Insert exists statement.
	//
	echo( '<h4>Insert exists statement</h4>' );
	echo( '<h5>$query = new CMongoQuery();</h5>' );
	$query = new CMongoQuery();
	echo( '<h5>$stmt = CQueryStatement::Exists( "B" );</h5>' );
	$stmt = CQueryStatement::Exists( "B" );
	echo( '<h5>$query->AppendStatement( $stmt );</h5>' );
	$query->AppendStatement( $stmt );
	echo( '<h5>$converted = $query->Export( $container );</h5>' );
	$converted = $query->Export( $container );
	echo( '<b>Query</b>: <pre>' ); print_r( $query ); echo( '</pre>' );
	echo( '<b>Converted</b>: <pre>' ); print_r( $converted ); echo( '</pre>' );
	$rs = $container->Query( $query );
	echo( '<b>Found: '.$rs->count().'</b><pre>' ); print_r( iterator_to_array( $rs ) ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Insert member of statement.
	//
	echo( '<h4>Insert member of statement</h4>' );
	echo( '<h5>$query = new CMongoQuery();</h5>' );
	$query = new CMongoQuery();
	echo( '<h5>$stmt = CQueryStatement::Member( "Name", array( "Uno", "Tre", "Sei" ) );</h5>' );
	$stmt = CQueryStatement::Member( "Name", array( "Uno", "Tre", "Sei" ) );
	echo( '<h5>$query->AppendStatement( $stmt );</h5>' );
	$query->AppendStatement( $stmt );
	echo( '<h5>$converted = $query->Export( $container );</h5>' );
	$converted = $query->Export( $container );
	echo( '<b>Query</b>: <pre>' ); print_r( $query ); echo( '</pre>' );
	echo( '<b>Converted</b>: <pre>' ); print_r( $converted ); echo( '</pre>' );
	$rs = $container->Query( $query );
	echo( '<b>Found: '.$rs->count().'</b><pre>' ); print_r( iterator_to_array( $rs ) ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Insert not member of statement.
	//
	echo( '<h4>Insert not member of statement</h4>' );
	echo( '<h5>$query = new CMongoQuery();</h5>' );
	$query = new CMongoQuery();
	echo( '<h5>$stmt = CQueryStatement::NotMember( "Name", array( "Uno", "Tre", "Sei" ) );</h5>' );
	$stmt = CQueryStatement::NotMember( "Name", array( "Uno", "Tre", "Sei" ) );
	echo( '<h5>$query->AppendStatement( $stmt );</h5>' );
	$query->AppendStatement( $stmt );
	echo( '<h5>$converted = $query->Export( $container );</h5>' );
	$converted = $query->Export( $container );
	echo( '<b>Query</b>: <pre>' ); print_r( $query ); echo( '</pre>' );
	echo( '<b>Converted</b>: <pre>' ); print_r( $converted ); echo( '</pre>' );
	$rs = $container->Query( $query );
	echo( '<b>Found: '.$rs->count().'</b><pre>' ); print_r( iterator_to_array( $rs ) ); echo( '</pre>' );
	echo( '<hr />' );
	
	//
	// Insert all statement.
	//
	echo( '<h4>Insert all statement</h4>' );
	echo( '<h5>$query = new CMongoQuery();</h5>' );
	$query = new CMongoQuery();
	echo( '<h5>$stmt = CQueryStatement::All( "list", array( 1, 2, 3 ) );</h5>' );
	$stmt = CQueryStatement::All( "list", array( 1, 2, 3 ) );
	echo( '<h5>$query->AppendStatement( $stmt );</h5>' );
	$query->AppendStatement( $stmt );
	echo( '<h5>$converted = $query->Export( $container );</h5>' );
	$converted = $query->Export( $container );
	echo( '<b>Query</b>: <pre>' ); print_r( $query ); echo( '</pre>' );
	echo( '<b>Converted</b>: <pre>' ); print_r( $converted ); echo( '</pre>' );
	$rs = $container->Query( $query );
	echo( '<b>Found: '.$rs->count().'</b><pre>' ); print_r( iterator_to_array( $rs ) ); echo( '</pre>' );
	echo( '<hr />' );
	echo( '<hr />' );
	
	//
	// Test query chaining.
	//
	echo( '<h4>Test query chaining</h4>' );
	$queryA = new CMongoQuery();
	$queryA->AppendStatement( CQueryStatement::Equals( "A", "a" ), kOPERATOR_OR );
	$queryA->AppendStatement( CQueryStatement::Equals( "B", "b" ), kOPERATOR_OR );
	$queryA = $queryA->getArrayCopy();
	$queryB = new CMongoQuery();
	$queryB->AppendStatement( CQueryStatement::Equals( "A", "a" ), kOPERATOR_AND );
	$queryB->AppendStatement( CQueryStatement::Equals( "B", "b" ), kOPERATOR_AND );
	$queryB = $queryB->getArrayCopy();
	$query1 = new CMongoQuery();
	$query1->AppendStatement( CQueryStatement::Equals( "X", "x" ), kOPERATOR_OR );
	$query1->AppendStatement( CQueryStatement::Equals( "Y", "y" ), kOPERATOR_OR );
	$query1 = $query1->getArrayCopy();
	$query2 = new CMongoQuery();
	$query2->AppendStatement( CQueryStatement::Equals( "X", "x" ), kOPERATOR_AND );
	$query2->AppendStatement( CQueryStatement::Equals( "Y", "y" ), kOPERATOR_AND );
	$query2 = $query2->getArrayCopy();
	
	$queriesA = array( $queryA, $queryB );
	$queriesN = array( $query1, $query2 );
	$conditions = array( kOPERATOR_OR, kOPERATOR_AND );
	
	foreach( $queriesA as $qA )
	{
		foreach( $conditions as $c )
		{
			foreach( $queriesN as $qn )
			{
				$q = new CMongoQuery( $qA );
				$q->AppendStatement( $qn, $c );
				echo( "<h5><table><tr><th>".key( $qA )."</th><th>$c</th><th>".key( $qn )."</th></tr></table></h5><br>" );
				echo( '<b>Current</b>: <pre>' ); print_r( $qA ); echo( '</pre>' );
				echo( '<b>Condition</b>: <pre>' ); print_r( $c ); echo( '</pre>' );
				echo( '<b>Statement</b>: <pre>' ); print_r( $qn ); echo( '</pre>' );
				echo( '<b>Result</b>: <pre>' ); print_r( $q ); echo( '</pre>' );
				$converted = $q->Export( $container );
				echo( '<b>Converted</b>: <pre>' ); print_r( $converted ); echo( '</pre>' );
				$rs = $container->Query( $q );
				echo( "<b><i>".$rs->count().'</i></b><br>' );
				echo( '<hr />' );
			}
		}
	}
	echo( '<hr />' );
	
	//
	// Test NAND.
	//
	echo( '<h4>Test NAND</h4>' );
	echo( '<h5>$query = new CMongoQuery();</h5>' );
	$query = new CMongoQuery();
	echo( '<h5>$stmt = CQueryStatement::Equals( "A", "a" );</h5>' );
	$stmt = CQueryStatement::Equals( "A", "a" );
	echo( '<h5>$query->AppendStatement( $stmt, kOPERATOR_NAND );</h5>' );
	$query->AppendStatement( $stmt, kOPERATOR_NAND );
	echo( '<h5>$stmt = CQueryStatement::Equals( "X", "x" );</h5>' );
	$stmt = CQueryStatement::Equals( "X", "x" );
	echo( '<h5>$query->AppendStatement( $stmt, kOPERATOR_NAND );</h5>' );
	$query->AppendStatement( $stmt, kOPERATOR_NAND );
	echo( '<h5>$converted = $query->Export( $container );</h5>' );
	$converted = $query->Export( $container );
	echo( '<b>Query</b>: <pre>' ); print_r( $query ); echo( '</pre>' );
	echo( '<b>Converted</b>: <pre>' ); print_r( $converted ); echo( '</pre>' );
	$rs = $container->Query( $query );
	echo( '<b>Found: '.$rs->count().'</b><pre>' ); print_r( iterator_to_array( $rs ) ); echo( '</pre>' );
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
