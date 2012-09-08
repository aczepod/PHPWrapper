<?php namespace MyWrapper\Persistence;

/**
 * <i>CMongoServer</i> class definition.
 *
 * This file contains the class definition of <b>CMongoServer</b> which represents a
 * concrete instance of a {@link CServer} implementing a {@link Mongo}.
 *
 *	@package	MyWrapper
 *	@subpackage	Persistence
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 08/09/2012
 */

/*=======================================================================================
 *																						*
 *									CMongoServer.php									*
 *																						*
 *======================================================================================*/

/**
 * Offsets.
 *
 * This include file contains common offset definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_DEFINE."/Offsets.inc.php" );

/**
 * Exceptions.
 *
 * This include file contains the native exceptions class definitions.
 */
use \Exception as Exception;

/**
 * Mongo.
 *
 * This includes the Mongo class definitions.
 */
use \Mongo as Mongo;

/**
 * Ancestor.
 *
 * This includes the ancestor class definitions.
 */
use \MyWrapper\Framework\CServer as CServer;

/**
 * <h3>Server object ancestor</h3>
 *
 * This class implements a server object that represents a {@link Mongo} instance. This object
 * can be used to generate Mongo database objects.
 *
 *	@package	MyWrapper
 *	@subpackage	Persistence
 */
class CMongoServer extends CServer
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
	 * The method accepts the same parameters as the {@link Mongo} constructor, the first
	 * one represents the server URL, the second represents the connection options.
	 *
	 * The method will first attempt to instantiate the {@link Mongo} object, it will then
	 * store it in the connection data member.
	 *
	 * If no parameter is provided, the method will assume the Mongo to connect to localhost
	 * on port 27017 and to initiate the connection.
	 *
	 * @param mixed					$theConnection		Server URL.
	 * @param mixed					$theOptions			Connection options.
	 *
	 * @access public
	 *
	 * @uses Connection()
	 */
	public function __construct( $theConnection = NULL, $theOptions = NULL )
	{
		//
		// Set default URL.
		//
		if( $theConnection === NULL )
			$theConnection = "mongodb://localhost:27017";
		
		//
		// Set default options.
		//
		if( $theOptions === NULL )
			$theOptions = array( "connect" => TRUE );
		
		//
		// Instantiate connection.
		//
		$connection = new Mongo( $theConnection, $theOptions );

		//
		// Parse and store URL components.
		//
		$components = parse_url( $theConnection );
		if( count( $components ) )
			$this->exchangeArray( $components );
		
		//
		// Store server name.
		//
		$this->offsetSet( kOFFSET_NAME, $theConnection );
		
		//
		// Bypass parent member accessor method.
		//
		$this->mConnection = $connection;
		
		//
		// Call parent constructor, just in case.
		//
		parent::__construct();
		
		//
		// Set inited state.
		//
		$this->_IsInited( TRUE );
		
	} // Constructor.

	 
	/*===================================================================================
	 *	__toString																		*
	 *==================================================================================*/

	/**
	 * <h4>Return connection name</h4>
	 *
	 * In this class the method will return the server's connection URL, which corresponds
	 * to the {@link kOFFSET_NAME} offset.
	 *
	 * @access public
	 * @return string				The connection name.
	 */
	public function __toString()
	{
		//
		// Handle connection string.
		//
		if( $this->offsetExists( kOFFSET_NAME ) )
			return $this->offsetGet( kOFFSET_NAME );								// ==>
		
		return '';																	// ==>
	
	} // __toString.

		

/*=======================================================================================
 *																						*
 *								PUBLIC MEMBER INTERFACE									*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	Connection																		*
	 *==================================================================================*/

	/**
	 * <h4>Manage native connection</h4>
	 *
	 * We overload this method to ensure the provided value is an instance of {@link Mongo},
	 * if this is not the case, the method will raise an exception.
	 *
	 * The method will attempt to parse the provided server URL and store the results in the
	 * array part of the object. For more information on the parsed elements consult the PHP
	 * {@link parse_url()} function.
	 *
	 * @param mixed					$theValue			Native connection or operation.
	 * @param boolean				$getOld				<tt>TRUE</tt> get old value.
	 *
	 * @access public
	 * @return mixed				<i>New</i> or <i>old</i> native connection.
	 *
	 * @throws Exception
	 */
	public function Connection( $theValue = NULL, $getOld = FALSE )
	{
		//
		// Check new value.
		//
		if( ($theValue !== NULL)
		 && ($theValue !== FALSE) )
		{
			//
			// Check value type.
			//
			if( ! $theValue instanceof Mongo )
				throw new Exception
					( "Invalid connection type",
					  kERROR_PARAMETER );										// !@! ==>
		
		} // New value.
		
		//
		// Set connection.
		//
		$save = parent::Connection( $theValue, $getOld );
		
		//
		// Handle changes.
		//
		if( $theValue !== NULL )
		{
			//
			// Handle new value.
			//
			if( $theValue !== FALSE )
			{
				//
				// Parse and store URL components.
				//
				$components = parse_url( (string) $theValue );
				if( count( $components ) )
					$this->exchangeArray( $components );
				
				//
				// Store server name.
				//
				$this->offsetSet( kOFFSET_NAME, (string) $theValue );
			
			} // New value.
			
			//
			// Remove value.
			//
			else
				$this->exchangeArray( Array() );
		
		} // Made changes.
		
		return $save;																// ==>

	} // Connection.

		

/*=======================================================================================
 *																						*
 *								PUBLIC CONNECTION INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	Database																		*
	 *==================================================================================*/

	/**
	 * <h4>Generate a database object</h4>
	 *
	 * In this class we return {@link CMongoDatabase} instances, the provided parameter is
	 * interpreted as the database name.
	 *
	 * If you omit the parameter, the method will raise an exception, in derived classes you
	 * can overload the method to provide a default database name.
	 *
	 * If the object does not have its native connection, the method will also raise an
	 * exception.
	 *
	 * @param string				$theDatabase		Database name.
	 *
	 * @access public
	 * @return mixed				The database object.
	 *
	 * @throws Exception
	 *
	 * @uses _IsInited()
	 */
	public function Database( $theDatabase = NULL )
	{
		//
		// Check database name.
		//
		if( $theDatabase === NULL )
			throw new Exception
				( "Missing database name",
				  kERROR_MISSING );												// !@! ==>
			
		//
		// Check inited status.
		//
		if( $this->_IsInited() )
			return new CMongoDatabase( $this, $theDatabase );						// ==>

		throw new Exception
			( "Object is not ready",
			  kERROR_STATE );													// !@! ==>
	
	} // Database.

	 

} // class CMongoServer.


?>
