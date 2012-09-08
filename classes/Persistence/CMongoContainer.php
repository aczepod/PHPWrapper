<?php namespace MyWrapper\Persistence;

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
 * Base offsets.
 *
 * This include file contains the base offset definitions.
 */
require_once( 'CPersistentDocument.inc.php' );

/**
 * Exceptions.
 *
 * This include file contains the native exceptions class definitions.
 */
use \Exception as Exception;

/**
 * Array object.
 *
 * This include file contains the array object class definitions.
 */
use \ArrayObject as ArrayObject;

/**
 * Mongo.
 *
 * This includes the Mongo class definitions.
 */
use \Mongo as Mongo;

/**
 * MongoDB.
 *
 * This includes the MongoDB class definitions.
 */
use \MongoDB as MongoDB;

/**
 * Native collection.
 *
 * This include file contains the native collection class definitions.
 */
use \MongoCollection as MongoCollection;

/**
 * Binary data.
 *
 * This include file contains the binary data class definitions.
 */
use \MongoBinData as MongoBinData;

/**
 * Ancestor.
 *
 * This include file contains the parent class definitions.
 */
use \MyWrapper\Framework\CContainer as CContainer;

/**
 * <h3>Mongo persistent objects data store</h3>
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
			if( ! $theValue instanceof MongoCollection )
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
	 * @param bitfield				$theModifiers		Options.
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
		// Get options mask.
		//
		$modifiers = $theModifiers & kFLAG_PERSIST_MASK;
		
		//
		// Handle retrieve.
		//
		if( ! $modifiers )
		{
			//
			// Determine criteria.
			//
			if( $theIdentifier !== NULL )
				$criteria = array( kOFFSET_NID => $theIdentifier );
			elseif( is_array( $theObject )
				 && array_key_exists( kOFFSET_NID, $theObject ) )
				$criteria = array( kOFFSET_NID => $theObject[ kOFFSET_NID ] );
			elseif( ($theObject instanceof ArrayObject)
				 && $theObject->offsetExists( kOFFSET_NID ) )
				$criteria = array( kOFFSET_NID => $theObject->offsetGet( kOFFSET_NID ) );
			else
				throw new Exception
					( "Missing object identifier",
					  kERROR_STATE );											// !@! ==>
			
			//
			// Locate object.
			//
			$theObject = $container->findOne( $criteria );
			
			return ( $theObject !== NULL );											// ==>
		
		} // Retrieve.
		
		//
		// Init options.
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
				$theObject[ kOFFSET_NID ] = $theIdentifier;
			
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
			
			return $theObject[ kOFFSET_NID ];										// ==>
		
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
				$criteria = array( kOFFSET_NID => $theIdentifier );
			elseif( array_key_exists( kOFFSET_NID, (array) $theObject ) )
				$criteria = array( kOFFSET_NID => $theObject[ kOFFSET_NID ] );
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
				$criteria = array( kOFFSET_NID => $theIdentifier );
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
				$theObject[ kOFFSET_NID ] = $theIdentifier;
			
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
			
			return $theObject[ kOFFSET_NID ];										// ==>
		
		} // Replace.
		
		//
		// Handle modify.
		//
		if( $modifiers == kFLAG_PERSIST_MODIFY )
		{
			//
			// Check identifier.
			//
			if( $theIdentifier === NULL )
				throw new Exception
					( "Missing object identifier",
					  kERROR_MISSING );											// !@! ==>
			
			//
			// Use provided identifier.
			//
			$criteria = array( kOFFSET_NID => $theIdentifier );
			
			//
			// Use provided object as modification data.
			//
			$modify = (array) $theObject;
			
			//
			// Set default commit options.
			//
			$options[ 'upsert' ] = FALSE;		// Don't create new objects.
			$options[ 'multiple' ] = FALSE;		// Operate on first object.
			
			//
			// Update.
			//
			$status = $container->update( $criteria, $modify, $options );
			
			//
			// Check status.
			//
			if( ! $status[ 'ok' ] )
				throw new Exception
					( $status[ 'errmsg' ],
					  kERROR_COMMIT );											// !@! ==>
			
			//
			// Handle updated object.
			//
			if( $status[ 'updatedExisting' ] )
			{
				//
				// Set object.
				//
				$theObject = $container->findOne( $criteria );
				
				return TRUE;														// ==>
			
			} // Found object.
			
			return NULL;															// ==>
		
		} // Modify.
		
		//
		// Handle delete.
		//
		if( $modifiers == kFLAG_PERSIST_DELETE )
		{
			//
			// Determine criteria.
			//
			if( $theIdentifier !== NULL )
				$criteria = array( kOFFSET_NID => $theIdentifier );
			elseif( array_key_exists( kOFFSET_NID, (array) $theObject ) )
				$criteria = array( kOFFSET_NID => $theObject[ kOFFSET_NID ] );
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

		

/*=======================================================================================
 *																						*
 *								PUBLIC CONVERSION INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	ConvertBinary																	*
	 *==================================================================================*/

	/**
	 * <h4>Convert a binary string</h4>
	 *
	 * This method will take care of converting binary data to and from Mongo data stores,
	 * we use here the {@link MongoBinData} class.
	 *
	 * This method can be used by the {@link CPersistentObject::_id()} method when
	 * generating a hashed identifier.
	 *
	 * @param mixed					$theValue			Binary value.
	 * @param boolean				$theSense			<tt>TRUE</tt> encode for database.
	 *
	 * @static
	 * @return mixed				The encoded or decoded binary string.
	 */
	static function ConvertBinary( $theValue, $theSense = TRUE )
	{
		if( $theSense )
			return new MongoBinData( $theValue );									// ==>
		
		return $theValue->bin;														// ==>
	
	} // ConvertBinary.

	 

} // class CMongoContainer.


?>
