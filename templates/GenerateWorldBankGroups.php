<?php

/**
 * Generate the World Bank country groups update XML file.
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
 *								GenerateWorldBankGroups.php								*
 *																						*
 *======================================================================================*/

//
// Global includes.
//
require_once( 'includes.inc.php' );

//
// Local includes.
//
require_once( 'local.inc.php' );

/**
 * ADODB library.
 */
require_once( "/Library/WebServer/Library/adodb/adodb.inc.php" );

/**
 * ADODB iterators.
 */
require_once( "/Library/WebServer/Library/adodb/adodb-iterator.inc.php" );

/**
 * ADODB exceptions.
 */
require_once( "/Library/WebServer/Library/adodb/adodb-exceptions.inc.php" );

//
// Class includes.
//
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/COntology.php" );

/*=======================================================================================
 *	LOCAL DEFINITIONS																	*
 *======================================================================================*/

/**
 * Source DSN.
 *
 * This defines the source data source name.
 */
define( "kDSN",	"MySQLi://WEB-SERVICES:webservicereader@192.168.181.1/ANCILLARY?fetchmode=2" );

/**
 * Destination file path.
 *
 * This defines the path of the final file.
 */
define( "kFILE",	"/Library/WebServer/Library/PHPWrapper/data/COUNTRY_WORLD_BANK.xml" );

/**
 * Groups table.
 *
 * This defines the groups table name.
 */
define( "kGROUPS",	"tmp" );

/**
 * List table.
 *
 * This defines the list of economies table name.
 */
define( "kLIST",	"tmp_list" );


/*=======================================================================================
 *	TEST																				*
 *======================================================================================*/
 
//
// Init local storage.
//
$dsn = kDSN;
$path = kFILE;
$groups = kGROUPS;
$list = kLIST;
 
//
// Init local storage.
//
$file = <<<EOT
<?xml version="1.0" encoding="utf-8"?>
<ONTOLOGY
    xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
    xsi:noNamespaceSchemaLocation="file:/Library/WebServer/Library/PHPWrapper/defines/Ontology.xsd">
    
    <!-- ISO -->
    
	<UNIT>

EOT;

//
// Test class.
//
try
{
	//
	// Open MySQL connection.
	//
	echo( "==> Opening MySQL connection.\n" );
	$_SESSION[ 'SQL' ] = NewADOConnection( $dsn );
	$ok = $_SESSION[ 'SQL' ]->Execute( "SET CHARACTER SET 'UTF8'" );
	$ok->Close();
	
	//
	// Open ontology connection.
	//
	echo( "==> Opening Ontology connection.\n" );
	$_SESSION[ 'ONT' ] = New CMongoServer();
	$tmp = explode( ':', kDEFAULT_GRAPH );
	$_SESSION[ 'ONT' ]->Graph( new CNeo4jGraph( $tmp[ 0 ], $tmp[ 1 ] ) );
	$_SESSION[ 'DB' ] = $_SESSION[ 'ONT' ]->Database( kDEFAULT_DATABASE );
	
	//
	// Dereference containers.
	//
	$nodes = $_SESSION[ 'DB' ]->Container( COntologyNode::DefaultContainerName() );
	
	//
	// Get list of countries and groups.
	//
	echo( "==> Iterating countries.\n" );
	$query = "SELECT DISTINCT `Country` FROM `$groups`";
	$rs = $_SESSION[ 'SQL' ]->GetCol( $query );
	foreach( $rs as $country )
	{
		//
		// Handle exceptions.
		//
		switch( $country )
		{
			case 'CHI':
			case 'KSV':
				$code = NULL;
				break;
				
			case 'ADO':
				$code = 'AND';
				break;
				
			case 'WBG':
				$code = 'PSE';
				break;
				
			case 'IMY':
				$code = 'IMN';
				break;
			
			default:
				$code = $country;
				break;
		}
		
		//
		// Skip.
		//
		if( $code === NULL )
			continue;														// =>
		
		//
		// Locate country.
		//
		$query = new CMongoQuery();
		$query->AppendStatement( CQueryStatement::Missing( kTAG_NODE ) );
		$query->AppendStatement( CQueryStatement::Equals( kTAG_LID, $code ) );
		$query->AppendStatement( CQueryStatement::Prefix( kTAG_GID, "ISO:3166:" ) );
		$rs = $nodes->Query( $query );
		
		//
		// Set term global identifier.
		//
		$count = $rs->count( FALSE );
		if( $count > 1 )
		{
			foreach( $rs as $record )
			{
				$gid = $record[ kTAG_GID ];
				if( substr( $gid, 0, 11 ) == 'ISO:3166:1:' )
					break;
			}
			
			if( substr( $gid, 0, 11 ) != 'ISO:3166:1:' )
				throw new Exception( "Country not found [$gid]" );				// !@! ==>
		}
		else
		{
			foreach( $rs as $record )
				$gid = $record[ kTAG_GID ];
		}
		
		//
		// Inform.
		//
		echo( "    $gid\n" );
		
		//
		// Add unit.
		//
		$file .= <<<EOT
    	<TERM modify="$gid">
    		<element tag="WBI:VERSION">July 2012</element>
    		<element tag="WBI:GROUP">

EOT;
		
		//
		// Locate lending group.
		//
		$query = "SELECT `LendingCategory` FROM `$list` WHERE `Country` = '$country'";
		$group = $_SESSION[ 'SQL' ]->GetOne( $query );
		if( strlen( $group ) )
		{
			//
			// Inform.
			//
			echo( "            WBI:LENDING:$group\n" );
			
			//
			// Add group.
			//
			$file .= <<<EOT
    			<item>WBI:LENDING:$group</item>

EOT;
		}
		
		//
		// Locate country groups.
		//
		$query = "SELECT DISTINCT `Group` FROM `$groups` WHERE `Country` = '$country'";
		$rs = $_SESSION[ 'SQL' ]->GetCol( $query );
		foreach( $rs as $group )
		{
			//
			// Inform.
			//
			echo( "            WBI:INCOME:$group\n" );
			
			//
			// Add group.
			//
			$file .= <<<EOT
    			<item>WBI:INCOME:$group</item>

EOT;
		}
		
		//
		// Close unit.
		//
		$file .= <<<EOT
    		</element>
    	</TERM>

EOT;
	}
	
	//
	// Close file.
	//
	$file .= <<<EOT
	</UNIT>
</ONTOLOGY>
EOT;
	
	//
	// Write file.
	//
	file_put_contents( $path, $file );

	echo( "\n==> Done!\n" );
}

//
// Catch exceptions.
//
catch( Exception $error )
{
	echo( (string) $error );
}

//
// Close MySQL databases.
//
if( isset( $_SESSION[ 'SQL' ] ) )
	$_SESSION[ 'SQL' ]->Close();

?>
