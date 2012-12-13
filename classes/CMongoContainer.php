<?php

/**
 * <i>CMongoContainer</i> class definition.
 *
 * This file contains the class definition of <b>CMongoContainer</b> which implements a
 * concrete {@link MongoCollection} container.
 *
 *	@package	MyWrapper
 *	@subpackage	Persistence
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 03/09/2012
 */

/*=======================================================================================
 *																						*
 *									CMongoContainer.php									*
 *																						*
 *======================================================================================*/

/**
 * Mongo queries.
 *
 * This includes the Mongo query class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CMongoQuery.php" );

/**
 * Ancestor.
 *
 * This include file contains the parent class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CContainer.php" );

/**
 * <h4>Mongo persistent objects data store</h4>
 *
 * This <i>concrete</i> class implements a container that uses a {@link MongoCollection} to
 * store objects.
 *
 *	@package	MyWrapper
 *	@subpackage	Persistence
 */
class CMongoContainer extends CContainer
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
	 * The method accepts the same parameters as the {@link MongoCollection} constructor,
	 * the first one represents the database object, the second represents the container
	 * name, if the latter is missing, the method will raise an exception.
	 *
	 * The method will also accept a database object in the first parameter, in that case
	 * the second parameter will be ignored.
	 *
	 * The method will first attempt to instantiate the {@link MongoCollection} object, it
	 * will then store it in the connection data member.
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
			// Handle container.
			//
			if( $theConnection instanceof self )
				parent::__construct( $theConnection->Connection() );
			
			//
			// Handle Mongo collection.
			//
			elseif( $theConnection instanceof MongoCollection )
				parent::__construct( $theConnection );
			
			//
			// Handle database.
			//
			else
			{
				//
				// Check container name.
				//
				if( $theOptions === NULL )
					throw new Exception
						( "Missing container name",
						  kERROR_MISSING );										// !@! ==>
				
				//
				// Handle database class.
				//
				if( $theConnection instanceof CMongoDatabase )
					$theConnection = $theConnection->Connection();
				
				//
				// Check Mongo database class.
				//
				if( $theConnection instanceof MongoDB )
					parent::__construct
						( $theConnection->selectCollection( (string) $theOptions ) );
				
				else
					throw new Exception
						( "Invalid database connection type",
						  kERROR_PARAMETER );									// !@! ==>
			
			} // Provided database.
		
		} // Provided parameter.
		
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
	 * <h4>Return container name</h4>
	 *
	 * This method should return the current container's name.
	 *
	 * In this class we return the collection name.
	 *
	 * @access public
	 * @return string				The container name.
	 *
	 * @uses Connection()
	 */
	public function __toString()
	{
		//
		// Get container.
		//
		if( ($container = $this->Connection()) !== NULL )
			return $container->getName();											// ==>
		
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
	 * We overload this method to ensure that the provided container is a
	 * {@link MongoCollection} object.
	 *
	 * @param mixed					$theValue			Persistent container or operation.
	 * @param boolean				$getOld				<tt>TRUE</tt> get old value.
	 *
	 * @access public
	 * @return mixed				<i>New</i> or <i>old</i> native container.
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
			if( ! ($theValue instanceof MongoCollection) )
				throw new Exception
					( "Invalid container type",
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
				$this->offsetSet( kOFFSET_NAME, $theValue->getName() );
			
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
	 * <h4>Delete a container</h4>
	 *
	 * In this class we drop the collection.
	 *
	 * @access public
	 */
	public function Drop()
	{
		//
		// Check if inited.
		//
		if( ($collection = $this->Connection()) !== NULL )
			$collection->Drop();
	
	} // Drop.

	 
	/*===================================================================================
	 *	AddIndex																		*
	 *==================================================================================*/

	/**
	 * <h4>Add an index</h4>
	 *
	 * In this class we simply pass the parameter to the MongoCollection.
	 *
	 * @param array					$theIndex			Key/Sort list.
	 * @param array					$theOptions			List of index options.
	 *
	 * @access public
	 */
	public function AddIndex( $theIndex, $theOptions = Array() )
	{
		//
		// Check if inited.
		//
		if( ($collection = $this->Connection()) !== NULL )
			$collection->ensureIndex( $theIndex, $theOptions );
	
	} // AddIndex.

		

/*=======================================================================================
 *																						*
 *								PUBLIC PERSISTENCE INTERFACE							*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	ManageObject																	*
	 *==================================================================================*/

	/**
	 * <h4>Manage an object from the container</h4>
	 *
	 * We implement this method to handle MongoCollection object stores.
	 *
	 * For more information see {@link CContainer::ManageObject()}.
	 *
	 * <i>Note: the commit operations are performed by default with the <tt>safe</tt>
	 * option.</i>
	 *
	 * @param reference			   &$theObject			Object.
	 * @param mixed					$theIdentifier		Identifier.
	 * @param mixed					$theModifiers		Options or offsets list.
	 *
	 * @access public
	 * @return mixed				The native operation status.
	 *
	 * @throws Exception
	 *
	 * @uses Connection()
	 *
	 * @see kFLAG_PERSIST_MASK kFLAG_PERSIST_INSERT kFLAG_PERSIST_UPDATE
	 * @see kFLAG_PERSIST_REPLACE kFLAG_PERSIST_MODIFY kFLAG_PERSIST_DELETE
	 */
	public function ManageObject( &$theObject,
								   $theIdentifier = NULL,
								   $theModifiers = kFLAG_DEFAULT )
	{
		//
		// Get container.
		//
		$container = $this->Connection();
		if( ! ($container instanceof MongoCollection) )
			throw new Exception
				( "Missing or invalid native container",
				  kERROR_STATE );												// !@! ==>
		
		//
		// Handle retrieve.
		//
		if( is_array( $theModifiers )					// Offsets list,
		 || (! ($theModifiers & kFLAG_PERSIST_MASK)) )	// or retrieve operation.
		{
			//
			// Determine criteria.
			//
			if( $theIdentifier !== NULL )
				$criteria = array( kTAG_NID => $theIdentifier );
			elseif( is_array( $theObject )
				 && array_key_exists( kTAG_NID, $theObject ) )
				$criteria = array( kTAG_NID => $theObject[ kTAG_NID ] );
			elseif( ($theObject instanceof ArrayObject)
				 && $theObject->offsetExists( kTAG_NID ) )
				$criteria = array( kTAG_NID => $theObject->offsetGet( kTAG_NID ) );
			else
				throw new Exception
					( "Missing object identifier",
					  kERROR_STATE );											// !@! ==>
			
			//
			// Determine selected offsets.
			//
			$fields = Array();
			if( is_array( $theModifiers )
			 && count( $theModifiers ) )
			{
				foreach( $theModifiers as $offset )
					$fields[ $offset ] = TRUE;
			}
			
			//
			// Locate object.
			//
			$theObject = $container->findOne( $criteria, $fields );
			
			return ( $theObject !== NULL );											// ==>
		
		} // Retrieve
		
		//
		// Get options mask.
		//
		$modifiers = $theModifiers & kFLAG_PERSIST_MASK;
		
		//
		// Init commit options.
		//
		$options = array( 'safe' => TRUE );
		
		//
		// Handle insert.
		//
		if( $modifiers == kFLAG_PERSIST_INSERT )
		{
			//
			// Set identifier.
			//
			if( $theIdentifier !== NULL )
				$theObject[ kTAG_NID ] = $theIdentifier;
			
			//
			// Convert to object.
			// If you provide an array, the missing identifier will not be set by Mongo.
			//
			if( is_array( $theObject ) )
			{
				//
				// Convert.
				//
				$object = new ArrayObject( $theObject );
				
				//
				// Insert.
				//
				$status = $container->insert( $object, $options );
				
				//
				// Restore.
				//
				$theObject = $object->getArrayCopy();
			}
			else
				$status = $container->insert( $theObject, $options );
			
			//
			// Check status.
			//
			if( ! $status[ 'ok' ] )
				throw new Exception
					( $status[ 'errmsg' ],
					  kERROR_COMMIT );											// !@! ==>
			
			return $theObject[ kTAG_NID ];										// ==>
		
		} // Insert.
		
		//
		// Handle update.
		//
		if( $modifiers == kFLAG_PERSIST_UPDATE )
		{
			//
			// Set default commit options.
			//
			$options[ 'upsert' ] = FALSE;		// Don't create new objects.
			$options[ 'multiple' ] = FALSE;		// Operate on first object.
			
			//
			// Determine criteria.
			//
			if( $theIdentifier !== NULL )
				$criteria = array( kTAG_NID => $theIdentifier );
			elseif( is_array( $theObject )
				 && array_key_exists( kTAG_NID, $theObject ) )
				$criteria = array( kTAG_NID => $theObject[ kTAG_NID ] );
			elseif( ($theObject instanceof ArrayObject)
				 && $theObject->offsetExists( kTAG_NID ) )
				$criteria = array( kTAG_NID => $theObject->offsetGet( kTAG_NID ) );
			else
				throw new Exception
					( "Missing object identifier",
					  kERROR_STATE );											// !@! ==>
			
			//
			// Update.
			//
			$status = $container->update( $criteria, $theObject, $options );
			
			//
			// Check status.
			//
			if( ! $status[ 'ok' ] )
				throw new Exception
					( $status[ 'errmsg' ],
					  kERROR_COMMIT );											// !@! ==>
			
			return $status[ 'updatedExisting' ];									// ==>
		
		} // Update.
		
		//
		// Handle modify.
		//
		if( $modifiers == kFLAG_PERSIST_MODIFY )
		{
			//
			// Set default commit options.
			//
			$options[ 'upsert' ] = FALSE;		// Don't create new objects.
			$options[ 'multiple' ] = FALSE;		// Operate on first object.
			
			//
			// Determine criteria.
			//
			if( $theIdentifier !== NULL )
				$criteria = array( kTAG_NID => $theIdentifier );
			else
				throw new Exception
					( "Missing object identifier",
					  kERROR_STATE );											// !@! ==>
			
			//
			// Init modification matrix.
			//
			$modifications = Array();
			
			//
			// Handle increment.
			//
			if( ($theModifiers & kFLAG_MODIFY_MASK) == kFLAG_MODIFY_INCREMENT )
			{
				//
				// Iterate offsets.
				//
				foreach( $theObject as $offset => $value )
				{
					//
					// Consider only integers.
					//
					$inc = (int) $value;
					
					//
					// Build clause.
					//
					$modifications[ '$inc' ][ $offset ] = $inc;
				}
			
			} // Increment.
			
			//
			// Handle append.
			//
			elseif( ($theModifiers & kFLAG_MODIFY_MASK) == kFLAG_MODIFY_APPEND )
			{
				//
				// Iterate offsets.
				//
				foreach( $theObject as $offset => $value )
				{
					//
					// Convert array objects.
					//
					if( $value instanceof ArrayObject )
						$value = $value->getArrayCopy();
						
					//
					// Handle array value.
					//
					if( is_array( $value ) )
						$modifications[ '$pushAll' ][ $offset ] = $value;
					
					//
					// Handle scalar.
					//
					else
						$modifications[ '$push' ][ $offset ] = $value;
				}
			
			} // Append.
			
			//
			// Handle add to set.
			//
			elseif( ($theModifiers & kFLAG_MODIFY_MASK) == kFLAG_MODIFY_ADDSET )
			{
				//
				// Iterate offsets.
				//
				foreach( $theObject as $offset => $value )
				{
					//
					// Convert array objects.
					//
					if( $value instanceof ArrayObject )
						$value = $value->getArrayCopy();
						
					//
					// Handle array value.
					//
					if( is_array( $value ) )
						$modifications[ '$addToSet' ][ $offset ][ '$each' ] = $value;
					
					//
					// Handle scalar.
					//
					else
						$modifications[ '$addToSet' ][ $offset ] = $value;
				}
			
			} // Add to set.
			
			//
			// Handle pop.
			//
			elseif( ($theModifiers & kFLAG_MODIFY_MASK) == kFLAG_MODIFY_POP )
			{
				//
				// Iterate offsets.
				//
				foreach( $theObject as $offset => $value )
				{
					//
					// Consider only integers.
					//
					$inc = ( ((int) $value) > 0 ) ? 1 : -1;
					
					//
					// Pop.
					//
					$modifications[ '$pop' ][ $offset ] = $inc;
				}
			
			} // Pop.
			
			//
			// Handle pull.
			//
			elseif( ($theModifiers & kFLAG_MODIFY_MASK) == kFLAG_MODIFY_PULL )
			{
				//
				// Iterate offsets.
				//
				foreach( $theObject as $offset => $value )
				{
					//
					// Convert array objects.
					//
					if( $value instanceof ArrayObject )
						$value = $value->getArrayCopy();
						
					//
					// Handle array value.
					//
					if( is_array( $value ) )
						$modifications[ '$pullAll' ][ $offset ] = $value;
					
					//
					// Handle scalar.
					//
					else
						$modifications[ '$pull' ][ $offset ] = $value;
				}
			
			} // Pull.
			
			//
			// Handle set & unset.
			//
			else
			{
				//
				// Iterate offsets.
				//
				foreach( $theObject as $offset => $value )
				{
					//
					// Set offset.
					//
					if( $value !== NULL )
					{
						//
						// Convert array objects.
						//
						if( $value instanceof ArrayObject )
							$value = $value->getArrayCopy();
						
						//
						// Set.
						//
						$modifications[ '$set' ][ $offset ] = $value;
					}
					
					//
					// Unset offset.
					//
					else
						$modifications[ '$unset' ][ $offset ] = 1;
				}
			
			} // Set & unset.
			
			//
			// Update.
			//
			$status = $container->update( $criteria, $modifications, $options );
			
			//
			// Check status.
			//
			if( ! $status[ 'ok' ] )
				throw new Exception
					( $status[ 'errmsg' ],
					  kERROR_COMMIT );											// !@! ==>
			
			//
			// Load modified object.
			//
			$theObject = $container->findOne( $criteria );
			
			return $status[ 'updatedExisting' ];									// ==>
		
		} // Modify.
		
		//
		// Handle replace.
		//
		if( $modifiers == kFLAG_PERSIST_REPLACE )
		{
			//
			// Set identifier.
			//
			if( $theIdentifier !== NULL )
				$theObject[ kTAG_NID ] = $theIdentifier;
			
			//
			// Convert to object.
			// If you provide an array, the missing identifier will not be set by Mongo.
			//
			if( is_array( $theObject ) )
			{
				//
				// Convert.
				//
				$object = new ArrayObject( $theObject );
				
				//
				// Replace.
				//
				$status = $container->save( $object, $options );
				
				//
				// Restore.
				//
				$theObject = $object->getArrayCopy();
			}
			else
				$status = $container->save( $theObject, $options );
			
			//
			// Check status.
			//
			if( ! $status[ 'ok' ] )
				throw new Exception
					( $status[ 'errmsg' ],
					  kERROR_COMMIT );											// !@! ==>
			
			return $theObject[ kTAG_NID ];										// ==>
		
		} // Replace.
		
		//
		// Handle delete.
		//
		if( $modifiers == kFLAG_PERSIST_DELETE )
		{
			//
			// Determine criteria.
			//
			if( $theIdentifier !== NULL )
				$criteria = array( kTAG_NID => $theIdentifier );
			elseif( is_array( $theObject )
				 && array_key_exists( kTAG_NID, $theObject ) )
				$criteria = array( kTAG_NID => $theObject[ kTAG_NID ] );
			elseif( ($theObject instanceof ArrayObject)
				 && $theObject->offsetExists( kTAG_NID ) )
				$criteria = array( kTAG_NID => $theObject->offsetGet( kTAG_NID ) );
			else
				throw new Exception
					( "Missing object identifier",
					  kERROR_STATE );											// !@! ==>
			
			//
			// Set options.
			//
			$options[ 'justOne' ] = TRUE;
			
			//
			// Delete.
			//
			$status = $container->remove( $criteria, $options );
			if( ! $status[ 'ok' ] )
				throw new Exception
					( $status[ 'errmsg' ],
					  kERROR_COMMIT );											// !@! ==>
			
			return $status[ 'n' ];													// ==>
		
		} // Delete.
		
		throw new Exception
			( "Invalid operation options",
			  kERROR_PARAMETER );												// !@! ==>
		
	} // ManageObject.

	 
	/*===================================================================================
	 *	CheckObject																		*
	 *==================================================================================*/

	/**
	 * <h4>Check if object exists in container</h4>
	 *
	 * In this class we return the number of found objects.
	 *
	 * @param mixed					$theIdentifier		Identifier.
	 * @param string				$theOffset			Offset.
	 *
	 * @access public
	 * @return boolean				<tt>TRUE</tt> exists.
	 *
	 * @throws Exception
	 *
	 * @uses Connection()
	 */
	public function CheckObject( $theIdentifier, $theOffset = NULL )
	{
		//
		// Get container.
		//
		$container = $this->Connection();
		if( ! ($container instanceof MongoCollection) )
			throw new Exception
				( "Missing or invalid native container",
				  kERROR_STATE );												// !@! ==>
		
		//
		// Set default offset.
		//
		if( $theOffset === NULL )
			$theOffset = '_id';
		
		//
		// Set criteria.
		//
		$fields = array( '_id' => TRUE );
		$criteria = array( $theOffset => $theIdentifier );
		
		//
		// Make query.
		//
		$cursor = $container->find( $criteria, $fields );
		
		return $cursor->count();													// ==>
	
	} // CheckObject.

	 
	/*===================================================================================
	 *	Query																			*
	 *==================================================================================*/

	/**
	 * <h4>Perform a query</h4>
	 *
	 * This method will perform the provided query on the current container, please refer to
	 * the {@link CContainer::Query()} reference for more information.
	 *
	 * @param array					$theQuery			Query.
	 * @param array					$theFields			Fields set.
	 * @param array					$theSort			Sort order.
	 * @param integer				$theStart			Page start.
	 * @param integer				$theLimit			Page limit.
	 * @param boolean				$getFirst			TRUE means return first.
	 *
	 * @access public
	 * @return object				Native recordset.
	 */
	public function Query( $theQuery = NULL,
						   $theFields = NULL, $theSort = NULL,
						   $theStart = NULL, $theLimit = NULL,
						   $getFirst = FALSE )
	{
		//
		// Check if ready.
		//
		if( $this->_Ready() )
		{
			//
			// Handle query.
			//
			if( $theQuery !== NULL )
			{
				//
				// Cast query.
				//
				if( ! ($theQuery instanceof CMongoQuery) )
					$theQuery = new CMongoQuery( $theQuery );
				
				//
				// Convert to Mongo.
				//
				$theQuery = $theQuery->Export( $this );
			}
			else
				$theQuery = Array();
			
			//
			// Handle fieldset.
			//
			if( $theFields !== NULL )
			{
				//
				// Handle scalar.
				//
				if( ! is_array( $theFields ) )
					$theFields = array( $theFields );
				
				//
				// Init local storage.
				// Note that we are instantiating an object:
				// this is necessary, or Mongo will sometimes interpret
				// field names as integers if it thinks it is an array.
				//
				$selection = new ArrayObject();
				
				//
				// Exclude ID.
				//
				if( ! in_array( '_id', $theFields ) )
					$selection[ '_id' ] = FALSE;
				
				//
				// Iterate fields.
				//
				foreach( $theFields as $field )
					$selection[ (string) $field ] = TRUE;
			}
			else
				$selection = Array();
			
			//
			// Return first object.
			//
			if( $getFirst )
				return $this->Connection()->findOne( $theQuery, $selection );		// ==>
			
			//
			// Get cursor.
			//
			$cursor = $this->Connection()->find( $theQuery, $selection );
			
			//
			// Handle sort order.
			//
			if( $theSort !== NULL )
			{
				//
				// Handle scalar.
				//
				if( ! is_array( $theSort ) )
					$selection = new ArrayObject( array( $theSort => 1 ) );
				
				//
				// Handle list.
				//
				else
				{
					//
					// Init local storage.
					// Note that we are instantiating an object:
					// this is necessary, or Mongo will sometimes interpret
					// field names as integers if it thinks it is an array.
					//
					$selection = new ArrayObject();
					
					//
					// Normalise list.
					//
					foreach( $theSort as $field => $value )
					{
						//
						// Handle numerics.
						//
						if( is_numeric( $value ) )
						{
							if( $value > 0 )
								$selection[ (string) $field ] = 1;
							elseif( $value < 0 )
								$selection[ (string) $field ] = -1;
						
						} // Numeric value.
					}
					
				} // Provided an array.
				
				//
				// Sort results.
				//
				$cursor->sort( $selection );
			
			} // Provided sort order.
			
			//
			// Handle paging parameters.
			//
			if( $theLimit !== NULL )
			{
				//
				// Initialise page start.
				//
				if( $theStart === NULL )
					$theStart = 0;
				
				//
				// Initialise record start.
				//
				$start = ( $theStart )
					   ? ($theStart * $theLimit)
					   : 0;
				
				//
				// Position at start.
				//
				$cursor->skip( $start );
				
				//
				// Set limit.
				//
				$cursor->limit( $theLimit );
			
			} // Provided paging.
			
			return $cursor;															// ==>
		
		} // Object is ready.
		
		throw new Exception
			( "Unable to query: container is not ready",
			  kERROR_STATE );													// !@! ==>
	
	} // Query.

	 
	/*===================================================================================
	 *	Remove																			*
	 *==================================================================================*/

	/**
	 * <h4>Perform a deletion</h4>
	 *
	 * In this class we use the default Mongo WriteConcerns.
	 *
	 * @param array					$theQuery			Query.
	 *
	 * @access public
	 * @return integer				Number of affected elements.
	 */
	public function Remove( $theQuery = NULL )
	{
		//
		// Check if ready.
		//
		if( $this->_Ready() )
		{
			//
			// Handle query.
			//
			if( $theQuery !== NULL )
			{
				//
				// Cast query.
				//
				if( ! ($theQuery instanceof CMongoQuery) )
					$theQuery = new CMongoQuery( $theQuery );
				
				//
				// Convert to Mongo.
				//
				$theQuery = $theQuery->Export( $this );
			}
			else
				$theQuery = Array();
			
			//
			// Do it.
			//
			$status = $this->Connection()->remove( $theQuery );
			
			return ( $status[ 'n' ] )
				 ? $status[ 'n' ]													// ==>
				 : NULL;															// ==>
		
		} // Object is ready.
		
		throw new Exception
			( "Unable to remove: container is not ready",
			  kERROR_STATE );													// !@! ==>
	
	} // Remove.

		

/*=======================================================================================
 *																						*
 *								PUBLIC SEQUENCE INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	NextSequence																	*
	 *==================================================================================*/

	/**
	 * <h4>Return a sequence number</h4>
	 *
	 * We overload this method here to implement sequence numbers in mongo containers,
	 * please refer to the {@link CContainer::NextSequence()} documentation for more
	 * information.
	 *
	 * @param string				$theKey				Sequence key.
	 * @param mixed					$theContainer		Sequence container.
	 *
	 * @access public
	 * @return mixed				The sequence number or <tt>NULL</tt>.
	 *
	 * @throws Exception
	 */
	public function NextSequence( $theKey, $theContainer = NULL )
	{
		//
		// Check inited status.
		//
		if( $this->_IsInited() )
		{
			//
			// Init local storage.
			//
			$options = array( 'safe' => TRUE );
			$criteria = array( '_id' => $theKey );
			$container = ( $theContainer !== NULL )
					   ? ( ( $theContainer === TRUE )
					   	 ? $this->Connection()->db->selectCollection
					   	 	( kCONTAINER_SEQUENCE_NAME )
					   	 : $this->Connection()->db->selectCollection( $theContainer ) )
					   : $this->Connection();
			
			//
			// Read sequence number.
			//
			$seq = $container->findOne( $criteria );
			
			//
			// Handle first.
			//
			if( $seq === NULL )
			{
				//
				// Save next.
				//
				$ok = $container->save( array( '_id' => $theKey,
											   kOFFSET_SEQUENCE => 2 ),
										$options );
				if( $ok[ 'ok' ] )
					return 1;														// ==>
				
				throw new Exception
					( $ok[ 'errmsg' ],
					  kERROR_COMMIT );											// !@! ==>
			
			} // First sequence.
			
			//
			// Handle existing sequence.
			//
			else
			{
				//
				// Save sequence.
				//
				$number = $seq[ kOFFSET_SEQUENCE ]++;
				
				//
				// Increment sequence.
				//
				$ok = $container->save( $seq, $options );
				if( ! $ok[ 'ok' ] )
					throw new Exception
						( $ok[ 'errmsg' ],
						  kERROR_COMMIT );										// !@! ==>
				
				return $number;														// ==>
			
			} // Sequence exists.
		
		} // Object is inited.
		
		throw new Exception
			( "Object is not ready",
			  kERROR_STATE );													// !@! ==>
	
	} // NextSequence.

		

/*=======================================================================================
 *																						*
 *								STATIC QUERY INTERFACE									*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	NewQuery																		*
	 *==================================================================================*/

	/**
	 * <h4>Return an empty query</h4>
	 *
	 * In this class we return an empty {@link CMongoQuery} instance.
	 *
	 * @param mixed					$theQuery			Query data.
	 *
	 * @static
	 * @return CQuery				An empty query object.
	 */
	static function NewQuery( $theQuery = NULL ){	return new CMongoQuery( $theQuery );	}

		

/*=======================================================================================
 *																						*
 *								PUBLIC CONVERSION INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	UnserialiseData																	*
	 *==================================================================================*/

	/**
	 * Unserialise provided data element.
	 *
	 * This method should convert the provided structure into a custom data type compatible
	 * with the current container.
	 *
	 * This method is called by a public {@link UnserialiseObject()} interface which
	 * traverses an object and provides this method with all elements that satisfy the
	 * following conditions:
	 *
	 * <ul>
	 *	<li><tt>{@link CDataType}</tt>: All instances derived from this class are sent to
	 *		this method.
	 *	<li><tt>Array</tt> or <tt>ArrayObject</tt>: If the structure is composed of exactly
	 *		two offsets and these elements are {@link kTAG_CUSTOM_TYPE} and
	 *		{@link kTAG_CUSTOM_DATA}, it will be sent to this method.
	 * </ul>
	 *
	 * In this class we parse the following types and offsets:
	 *
	 * <ul>
	 *	<li><i>{@link CDataTypeMongoId} object or {@link kTYPE_MongoId} offset</i>: We
	 *		return a MongoId object.
	 *	<li><i>{@link CDataTypeMongoCode} object or {@link kTYPE_MongoCode} offset</i>: We
	 *		return a MongoCode object.
	 *	<li><i>{@link CDataTypeStamp} object or {@link kTYPE_STAMP} offset</i>: We return a
	 *		MongoDate object.
	 *	<li><i>{@link CDataTypeRegex} object or {@link kTYPE_REGEX_STRING} offset</i>: We return a
	 *		MongoRegex object.
	 *	<li><i>{@link CDataTypeInt32} object or {@link kTYPE_INT32} offset</i>: We return a
	 *		MongoInt32 object.
	 *	<li><i>{@link CDataTypeInt64} object or {@link kTYPE_INT64} offset</i>: We return a
	 *		MongoInt64 object.
	 *	<li><i>{@link CDataTypeBinary} object or {@link kTYPE_BINARY_STRING} offset</i>: We return
	 *		a MongoBinData object.
	 * </ul>
	 *
	 * The elements to be converted are provided by reference, which means that they have to
	 * be converted in place.
	 *
	 * This method can also be used in a different way: you can ask the method to convert
	 * the provided scalar to the corresponding Mongo custom type, for this you need to
	 * provide a scalar in the first parameter and a data type in the second.
	 *
	 * @param reference			   &$theElement			Element to encode.
	 * @param string				$theType			Data type.
	 *
	 * @access public
	 */
	public function UnserialiseData( &$theElement, $theType = NULL )
	{
		//
		// Check type.
		//
		if( is_array( $theElement )
		 || ($theElement instanceof ArrayObject) )
		{
			//
			// Parse by type.
			//
			$data = $theElement[ kTAG_CUSTOM_DATA ];
			switch( $theElement[ kTAG_CUSTOM_TYPE ] )
			{
				//
				// MongoId.
				//
				case kTYPE_MongoId:
					$theElement = new MongoId( (string) $data );
					break;
				
				//
				// MongoCode.
				//
				case kTYPE_MongoCode:
					if( is_array( $data )
					 || ($data instanceof ArrayObject) )
					{
						$tmp1 = $data[ kOBJ_TYPE_CODE_SRC ];
						$tmp2 = ( array_key_exists( kOBJ_TYPE_CODE_SCOPE, (array) $data ) )
							  ? $data[ kOBJ_TYPE_CODE_SCOPE ]
							  : Array();
						$theElement = new MongoCode( $tmp1, $tmp2 );
					}
					break;
				
				//
				// MongoDate.
				//
				case kTYPE_STAMP:
					if( is_array( $data )
					 || ($data instanceof ArrayObject) )
					{
						$tmp1 = $data[ kTAG_STAMP_SEC ];
						$tmp2 = ( array_key_exists( kTAG_STAMP_USEC, (array) $data ) )
							  ? $data[ kTAG_STAMP_USEC ]
							  : 0;
						$theElement = new MongoDate( $tmp1, $tmp2 );
					}
					break;
				
				//
				// MongoInt32.
				//
				case kTYPE_INT32:
					$theElement = new MongoInt32( $data );
					break;
				
				//
				// MongoInt64.
				//
				case kTYPE_INT64:
					$theElement = new MongoInt64( $data );
					break;
	
				//
				// MongoRegex.
				//
				case kTYPE_REGEX_STRING:
					$theElement = new MongoRegex( $data );
					break;
	
				//
				// MongoBinData.
				//
				case kTYPE_BINARY_STRING:
					$data = ( function_exists( 'hex2bin' ) )
						  ? hex2bin( $data )
						  : pack( 'H*', $data );
					$theElement = new MongoBinData( $data, 2 );
					break;
			
			} // Parsing by type.
		
		} // Element is a structure.
		
		//
		// Handle scalar conversion.
		//
		elseif( $theType !== NULL )
		{
			//
			// Parse by type.
			//
			switch( $theType )
			{
				case kTYPE_INT32:
					if( ! ($theElement instanceof MongoInt32) )
						$theElement = new MongoInt32( (string) $theElement );
					break;
					
				case kTYPE_INT64:
					if( ! ($theElement instanceof MongoInt64) )
						$theElement = new MongoInt64( (string) $theElement );
					break;
					
				case kTYPE_BINARY_STRING:
					if( ! ($theElement instanceof MongoBinData) )
						$theElement = new MongoBinData( (string) $theElement, 2 );
					break;
					
				case kTYPE_STAMP:
					if( ! ($theElement instanceof MongoDate) )
					{
						if( is_array( $theElement ) )
							$theElement
								= new MongoDate( array_shift( $theElement ),
												 ( ( count( $theElement ) )
												 ? array_shift( $theElement )
												 : 0 ) );
						elseif( is_integer( $theElement ) )
							$theElement = new MongoDate( $theElement, 0 );
						else
							$theElement = new MongoDate( strtotime( $theElement ) );
					}
					break;
			}
		
		} // Provided scalar and data type.
	
	} // UnserialiseData.

	 

} // class CMongoContainer.


?>
