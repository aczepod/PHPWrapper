<?php

/**
 * <i>CMongoDatabase</i> class definition.
 *
 * This file contains the class definition of <b>CMongoDatabase</b> which represents a
 * concrete instance of a {@link CDatabase} implementing a {@link MongoDB}.
 *
 *	@package	MyWrapper
 *	@subpackage	Persistence
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 08/09/2012
 */

/*=======================================================================================
 *																						*
 *									CMongoDatabase.php									*
 *																						*
 *======================================================================================*/

/**
 * Ancestor.
 *
 * This includes the ancestor class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CDatabase.php" );

/**
 * <h4>Database object ancestor</h4>
 *
 * This class implements a database object that represents a {@link MongoDB} instance. This
 * object can be used to generate Mongo container objects.
 *
 *	@package	MyWrapper
 *	@subpackage	Persistence
 */
class CMongoDatabase extends CDatabase
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
	 * The method accepts the same parameters as the {@link MongoDB} constructor, the first
	 * one represents the server object, the second represents the database name, if the
	 * latter is missing, the method will raise an exception.
	 *
	 * The method will also accept a server object in the first parameter, in that case
	 * the second parameter will be ignored.
	 *
	 * The method will first attempt to instantiate the {@link MongoDB} object, it will
	 * then store it in the connection data member.
	 *
	 * @param mixed					$theConnection		Server or database.
	 * @param mixed					$theOptions			Database name.
	 *
	 * @access public
	 *
	 * @uses Connection()
	 */
	public function __construct( $theConnection = NULL, $theOptions = NULL )
	{
		//
		// Check server.
		//
		if( $theConnection !== NULL )
		{
			//
			// Handle database.
			//
			if( $theConnection instanceof self )
				parent::__construct( $theConnection->Connection() );
			
			//
			// Handle Mongo database.
			//
			elseif( $theConnection instanceof MongoDB )
				parent::__construct( $theConnection );
			
			//
			// Handle server.
			//
			else
			{
				//
				// Check database name.
				//
				if( $theOptions === NULL )
					throw new Exception
						( "Missing database name",
						  kERROR_MISSING );										// !@! ==>
				
				//
				// Handle server class.
				//
				if( $theConnection instanceof CMongoServer )
					$theConnection = $theConnection->Connection();
				
				//
				// Check Mongo server class.
				//
				if( $theConnection instanceof Mongo )
					parent::__construct
						( $theConnection->selectDB( (string) $theOptions ) );
				
				else
					throw new Exception
						( "Invalid server connection type",
						  kERROR_PARAMETER );									// !@! ==>
			
			} // Provided server.
		
		} // Provided server.
		
		//
		// Call parent constructor, just in case.
		//
		else
			parent::__construct();
		
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
		// Handle native database.
		//
		if( ($database = $this->Connection()) !== NULL )
			return (string) $database;												// ==>
		
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
	 * We overload this method to ensure the provided value is an instance of
	 * {@link Mongo}, if this is not the case, the method will raise an exception.
	 *
	 * The method will attempt to parse the provided server URL and store the results in the
	 * array part of the object. For more information on the parsed elements consult the PHP
	 * {@link parse_url()} function.
	 *
	 * Although the database name can be obtained from the native connection, we still store
	 * it in the {@link kOFFSET_NAME} offset for consistency with other connection objects.
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
			if( ! $theValue instanceof MongoDB )
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
				$this->offsetSet( kOFFSET_NAME, (string) $theValue );
			
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
	 *	Drop																			*
	 *==================================================================================*/

	/**
	 * <h4>Delete a database</h4>
	 *
	 * In this class we drop the database.
	 *
	 * @access public
	 */
	public function Drop()
	{
		//
		// Check if inited.
		//
		if( ($db = $this->Connection()) !== NULL )
			$db->Drop();
	
	} // Drop.

	 
	/*===================================================================================
	 *	Container																		*
	 *==================================================================================*/

	/**
	 * <h4>Generate a container object</h4>
	 *
	 * In this class we return {@link CMongoContainer} instances, the provided parameter is
	 * interpreted as the container name.
	 *
	 * If you omit the parameter, the method will raise an exception, in derived classes you
	 * can overload the method to provide a default container name.
	 *
	 * If the object does not have its native connection, the method will also raise an
	 * exception.
	 *
	 * @param string				$theContainer		Container name.
	 *
	 * @access public
	 * @return mixed				The container object.
	 *
	 * @throws Exception
	 *
	 * @uses _IsInited()
	 */
	public function Container( $theContainer = NULL )
	{
		//
		// Check container name.
		//
		if( $theContainer === NULL )
			throw new Exception
				( "Missing container name",
				  kERROR_MISSING );												// !@! ==>
			
		//
		// Check inited status.
		//
		if( $this->_IsInited() )
		{
			//
			// Instantiate database.
			//
			$cn = new CMongoContainer( $this, $theContainer );
			
			//
			// Set parent reference.
			//
			$cn[ kOFFSET_PARENT ] = $this;
			
			return $cn;																// ==>
		
		} // Object not initialised.

		throw new Exception
			( "Object is not ready",
			  kERROR_STATE );													// !@! ==>
	
	} // Container.

	 

} // class CMongoDatabase.


?>
