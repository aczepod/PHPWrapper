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
 * Ancestor.
 *
 * This include file contains the parent class definitions.
 */
use MyWrapper\Framework\CContainer;

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
	 * @uses Container()
	 */
	public function __toString()
	{
		//
		// Get container.
		//
		if( ($container = $this->Container()) !== NULL )
			return $container->getName();											// ==>
		
		return '';																	// ==>
	
	} // __toString.

		

/*=======================================================================================
 *																						*
 *								PUBLIC MEMBER INTERFACE									*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	Container																		*
	 *==================================================================================*/

	/**
	 * <h4>Manage persistent container</h4>
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
	public function Container( $theValue = NULL, $getOld = FALSE )
	{
		//
		// Handle retrieve or delete.
		//
		if( ($theValue === NULL)
		 || ($theValue === FALSE) )
			return parent::Container( $theValue, $getOld );							// ==>
		
		//
		// Check value.
		//
		if( $theValue instanceof \MongoCollection )
			return parent::Container( $theValue, $getOld );							// ==>
		
		throw new \Exception
			( "Invalid container type",
			  kERROR_PARAMETER );												// !@! ==>

	} // Container.

		

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
	 * For more information see {@link MyWrapper\Framework\CContainer::ManageObject()}.
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
	 * @uses Container()
	 */
	public function ManageObject( &$theObject,
								   $theIdentifier = NULL,
								   $theModifiers = kFLAG_DEFAULT )
	{
		//
		// Call parent method.
		//
		parent::ManageObject( $theObject, $theIdentifier, $theModifiers );
		
		//
		// Get container.
		//
		$container = $this->Container();
		if( ! ($container instanceof \MongoCollection) )
			throw new \Exception
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
				$criteria = array( kTAG_LID => $theIdentifier );
			elseif( is_array( $theObject )
				 && array_key_exists( kTAG_LID, $theObject ) )
				$criteria = array( kTAG_LID => $theObject[ kTAG_LID ] );
			elseif( ($theObject instanceof ArrayObject)
				 && $theObject->offsetExists( kTAG_LID ) )
				$criteria = array( kTAG_LID => $theObject->offsetGet( kTAG_LID ) );
			else
				throw new \Exception
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
				$theObject[ kTAG_LID ] = $theIdentifier;
			
			//
			// Convert to object.
			// If you provide an array, the missing identifier will not be set by Mongo.
			//
			if( is_array( $theObject ) )
			{
				//
				// Convert.
				//
				$object = new \ArrayObject( $theObject );
				
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
				throw new \Exception
					( $status[ 'errmsg' ],
					  kERROR_COMMIT );											// !@! ==>
			
			return $theObject[ kTAG_LID ];											// ==>
		
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
				$criteria = array( kTAG_LID => $theIdentifier );
			elseif( array_key_exists( kTAG_LID, (array) $theObject ) )
				$criteria = array( kTAG_LID => $theObject[ kTAG_LID ] );
			else
				throw new \Exception
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
				throw new \Exception
					( $status[ 'errmsg' ],
					  kERROR_COMMIT );											// !@! ==>
			
			return $status[ 'updatedExisting' ];									// ==>
		
		} // Update.
		
		//
		// Handle replace.
		//
		if( $modifiers == kFLAG_PERSIST_REPLACE )
		{
			//
			// Set identifier.
			//
			if( $theIdentifier !== NULL )
				$theObject[ kTAG_LID ] = $theIdentifier;
			
			//
			// Convert to object.
			// If you provide an array, the missing identifier will not be set by Mongo.
			//
			if( is_array( $theObject ) )
			{
				//
				// Convert.
				//
				$object = new \ArrayObject( $theObject );
				
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
				throw new \Exception
					( $status[ 'errmsg' ],
					  kERROR_COMMIT );											// !@! ==>
			
			return $theObject[ kTAG_LID ];											// ==>
		
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
				throw new \Exception
					( "Missing object identifier",
					  kERROR_MISSING );											// !@! ==>
			
			//
			// Use provided identifier.
			//
			$criteria = array( kTAG_LID => $theIdentifier );
			
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
				throw new \Exception
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
				$criteria = array( kTAG_LID => $theIdentifier );
			elseif( array_key_exists( kTAG_LID, (array) $theObject ) )
				$criteria = array( kTAG_LID => $theObject[ kTAG_LID ] );
			else
				throw new \Exception
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
				throw new \Exception
					( $status[ 'errmsg' ],
					  kERROR_COMMIT );											// !@! ==>
			
			return $status[ 'n' ];													// ==>
		
		} // Delete.
		
		throw new \Exception
			( "Invalid operation options",
			  kERROR_PARAMETER );												// !@! ==>
		
	} // ManageObject.

		

/*=======================================================================================
 *																						*
 *								PROTECTED MEMBER INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	&_Container																		*
	 *==================================================================================*/

	/**
	 * <h4>Get container reference</h4>
	 *
	 * This method can be used to retrieve a reference to the native container member, this
	 * can be useful when the native {@link Container()} is not an object passed by
	 * reference.
	 *
	 * @access protected
	 * @return mixed
	 */
	protected function &_Container()						{	return $this->mContainer;	}

	 

} // class CMongoContainer.


?>
