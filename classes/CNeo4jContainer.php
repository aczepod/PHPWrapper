<?php

/**
 * <i>CNeo4jContainer</i> class definition.
 *
 * This file contains the class definition of <b>CNeo4jContainer</b> which implements a
 * graph container.
 *
 *	@package	MyWrapper
 *	@subpackage	Persistence
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 29/10/2012
 */

/*=======================================================================================
 *																						*
 *									CNeo4jContainer.php									*
 *																						*
 *======================================================================================*/

/**
 * Local definitions.
 *
 * This include file contains common offset definitions.
 */
require_once( "CNeo4jContainer.inc.php" );

/**
 * Ancestor.
 *
 * This includes the ancestor class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CConnection.php" );

/**
 * <h4>Graph container</h4>
 *
 * This class wraps the {@link CConnection} class family around a Neo4j graph database
 * client.
 *
 * The connection property will hold a Neo4j client.
 *
 *	@package	MyWrapper
 *	@subpackage	Persistence
 */
class CNeo4jContainer extends CConnection
{
		

/*=======================================================================================
 *																						*
 *											MAGIC										*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	__construct																		*
	 *==================================================================================*/

	/**
	 * <h4>Instantiate class</h4>
	 *
	 * You instantiate the class by providing a native connection, or the host and port.
	 * In the latter case the first parameter represents the host and the second the port.
	 *
	 * If you do not provide any parameter the default {@link kGRAPH_DEF_HOST} host and
	 * {@link kGRAPH_DEF_PORT} port.
	 *
	 * @param mixed					$theConnection		Native connection.
	 * @param mixed					$theOptions			Connection options.
	 *
	 * @access public
	 *
	 * @uses Connection()
	 */
	public function __construct( $theConnection = NULL, $theOptions = NULL )
	{
		//
		// Build new container.
		//
		if( ! ($theConnection instanceof Everyman\Neo4j\Client) )
		{
			//
			// Init host.
			//
			if( $theConnection === NULL )
				$theConnection = kGRAPH_DEF_HOST;
			
			//
			// Init port.
			//
			if( $theOptions === NULL )
				$theOptions = kGRAPH_DEF_PORT;
			
			//
			// Set connection name.
			//
			$this->offsetSet( kOFFSET_NAME, "$theConnection:$theOptions" );
			
			//
			// Instantiate client.
			//
			$theConnection = new Everyman\Neo4j\Client( $theConnection, $theOptions );
		
		} // New container.
		
		//
		// Call parent method.
		//
		parent::__construct( $theConnection );
		
	} // Constructor.

	 
	/*===================================================================================
	 *	__toString																		*
	 *==================================================================================*/

	/**
	 * <h4>Return connection name</h4>
	 *
	 * This method should return the current connection's name.
	 *
	 * In this class we return the host and port names.
	 *
	 * @access public
	 * @return string				The connection name.
	 */
	public function __toString()			{	return $this->offsetGet( kOFFSET_NAME );	}

	 

} // class CNeo4jContainer.


?>
