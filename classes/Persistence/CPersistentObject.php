<?php namespace MyWrapper\Persistence;

/**
 * <i>CPersistentObject</i> class definition.
 *
 * This file contains the class definition of <b>CPersistentObject</b> which represents
 * the ancestor of all persistent object classes.
 *
 *	@package	MyWrapper
 *	@subpackage	Persistence
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 04/09/2012
 */

/*=======================================================================================
 *																						*
 *								CPersistentObject.php									*
 *																						*
 *======================================================================================*/

/**
 * Ancestor.
 *
 * This includes the ancestor class definitions.
 */
use MyWrapper\Framework\CPersistentDocument;

/**
 * <h3>Persistent object ancestor</h3>
 *
 * This class extends its {@link CPersistentDocument} ancestor to manage a series of
 * predefined object attributes.
 *
 * Concrete instances derived from this class are uniquely identified by a string which is
 * extracted from a combination of the object attributes. This string is returned by a
 * protected method, {@link _index()}, and set as an attribute of the object with the
 * {@link kTAG_GID} offset. The object's local unique identifier, {@link kTAG_LID}, and
 * native key is set by a protected method, {@link _id()}, this method must either use the
 * string returned by {@link _insed()} as-is, or hash the value to make it shorter.
 *
 * Instances derived from this class set by default another offset, {@link kTAG_CLASS},
 * which records the class name: this will be used by the static {@link Create()} method to
 * instantiate the correct class when retrieving objects from a container.
 *
 *	@package	MyWrapper
 *	@subpackage	Persistence
 */
class CPersistentObject extends CPersistentDocument
{
		

/*=======================================================================================
 *																						*
 *								STATIC PERSISTENCE INTERFACE							*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	Create																			*
	 *==================================================================================*/

	/**
	 * <h4>Create an object from a container</h4>
	 *
	 * We override this method to handle the {@link kTAG_CLASS} offset: if found in the
	 * retrieved object, it will be used to instantiate the correct class. If the offset is
	 * missing, the instantiated object will be of this class.
	 *
	 * If the object could not be located, the method will return <tt>NULL</tt>.
	 *
	 * @param CContainer			$theContainer		Container.
	 * @param mixed					$theIdentifier		Identifier.
	 *
	 * @static
	 * @return mixed				The retrieved object.
	 */
	static function Create( CContainer $theContainer, $theIdentifier )
	{
		//
		// Retrieve object.
		//
		if( $theContainer->ManageObject( $object, $theIdentifier ) )
		{
			//
			// Handle custom class.
			//
			if( array_key_exists( kTAG_CLASS, $object ) )
			{
				//
				// Save class name.
				//
				$class = $object[ kTAG_CLASS ];
				
				//
				// Instantiate class.
				//
				$object = new $class( $object );
			
			} // Custom class.
			
			//
			// Handle default class.
			//
			else
				$object = new self( $object );
			
			//
			// Set committed status.
			//
			$object->_IsCommitted( TRUE );
			
			return $object;															// ==>
		
		} // Located.
		
		return NULL;																// ==>
	
	} // Create.
		


/*=======================================================================================
 *																						*
 *								PUBLIC PERSISTENCE INTERFACE							*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	Insert																			*
	 *==================================================================================*/

	/**
	 * <h4>Insert the object into a container</h4>
	 *
	 * We overload this method to prepare the object before it gets committed, or this we
	 * call the {@link _PrepareInsert()} protected interface before calling the parent
	 * method.
	 *
	 * @param CContainer			$theContainer		Container.
	 *
	 * @access public
	 * @return mixed				The object's local identifier.
	 *
	 * @uses _PrepareInsert()
	 */
	public function Insert( CContainer $theContainer )
	{
		//
		// Check if necessary.
		//
		if( $this->_IsDirty()
		 || (! $this->_IsCommitted()) )
		{
			//
			// Only if inited.
			//
			if( $this->_IsInited() )
			{
				//
				// Commit object.
				//
				$status = $theContainer->ManageObject( $this, NULL, kFLAG_PERSIST_INSERT );
				
				//
				// Set commit status.
				//
				$this->_IsCommitted( TRUE );
				
				//
				// Reset dirty status.
				//
				$this->_IsDirty( FALSE );
				
				return $status;														// ==>
			
			} // Object is ready.
			
			throw new \Exception
				( "The object is not initialised",
				  kERROR_STATE );												// !@! ==>
		
		} // Dirty or not yet committed.
		
		return NULL;																// ==>
	
	} // Insert.

	 
	/*===================================================================================
	 *	Update																			*
	 *==================================================================================*/

	/**
	 * <h4>Update the object from a container</h4>
	 *
	 * This method will update the current object into the provided container, if the object
	 * cannot be found in the container, the method will raise an exception.
	 *
	 * The method expects a single parameter, <tt>$theContainer</tt>, which represents the
	 * container in which the object should be stored. This container must be a concrete
	 * instance of the {@link CContainer} class.
	 *
	 * The operation will only be performed if the object is not yet committed or if the
	 * object has its {@link _IsDirty()} dirty status set, if not, the method will do
	 * nothing.
	 *
	 * Once the object has been stored, it will have its {@link _IsCommitted()} status set
	 * and its {@link _IsDirty()} status reset.
	 *
	 * The method will raise an exception if the object has not the {@link _IsInited()}
	 * status set.
	 *
	 * @param CContainer			$theContainer		Container.
	 *
	 * @access public
	 *
	 * @uses _IsDirty()
	 * @uses _IsInited()
	 * @uses _IsCommitted()
	 */
	public function Update( CContainer $theContainer )
	{
		//
		// Check if necessary.
		//
		if( $this->_IsDirty()
		 || (! $this->_IsCommitted()) )
		{
			//
			// Only if inited.
			//
			if( ! $this->_IsInited() )
				throw new \Exception
					( "The object is not initialised",
					  kERROR_STATE );											// !@! ==>
			
			//
			// Commit object.
			//
			if( ! $theContainer->ManageObject( $this, NULL, kFLAG_PERSIST_UPDATE ) )
				throw new \Exception
					( "Object not found",
					  kERROR_NOT_FOUND );										// !@! ==>
		
			//
			// Set commit status.
			//
			$this->_IsCommitted( TRUE );
			
			//
			// Reset dirty status.
			//
			$this->_IsDirty( FALSE );
		
		} // Dirty or not yet committed.
	
	} // Update.

	 
	/*===================================================================================
	 *	Replace																			*
	 *==================================================================================*/

	/**
	 * <h4>Replace the object into a container</h4>
	 *
	 * This method will insert the current object into the provided container, if not found,
	 * or update the object if already there.
	 *
	 * The method expects a single parameter, <tt>$theContainer</tt>, which represents the
	 * container in which the object should be stored. This container must be a concrete
	 * instance of the {@link CContainer} class.
	 *
	 * The operation will only be performed if the object is not yet committed or if the
	 * object has its {@link _IsDirty()} dirty status set, if not, the method will do
	 * nothing.
	 *
	 * Once the object has been stored, it will have its {@link _IsCommitted()} status set
	 * and its {@link _IsDirty()} status reset.
	 *
	 * The method will raise an exception if the object has not the {@link _IsInited()}
	 * status set.
	 *
	 * The method may set the local unique identifier attribute ({@link kTAG_LID}) if not
	 * provided.
	 *
	 * The method will return the object's local unique identifier attribute
	 * ({@link kTAG_LID}) or <tt>NULL</tt> if the operation is not necessary.
	 *
	 * @param CContainer			$theContainer		Container.
	 *
	 * @access public
	 * @return mixed				The object's local identifier.
	 *
	 * @uses _IsDirty()
	 * @uses _IsInited()
	 * @uses _IsCommitted()
	 */
	public function Replace( CContainer $theContainer )
	{
		//
		// Check if necessary.
		//
		if( $this->_IsDirty()
		 || (! $this->_IsCommitted()) )
		{
			//
			// Only if inited.
			//
			if( $this->_IsInited() )
			{
				//
				// Commit object.
				//
				$status = $theContainer->ManageObject( $this, NULL, kFLAG_PERSIST_REPLACE );
				
				//
				// Set commit status.
				//
				$this->_IsCommitted( TRUE );
				
				//
				// Reset dirty status.
				//
				$this->_IsDirty( FALSE );
				
				return $status;														// ==>
			
			} // Object is ready.
			
			throw new \Exception
				( "The object is not initialised",
				  kERROR_STATE );												// !@! ==>
		
		} // Dirty or not yet committed.
		
		return NULL;																// ==>
	
	} // Replace.

	 
	/*===================================================================================
	 *	Delete																			*
	 *==================================================================================*/

	/**
	 * <h4>Delete the object from a container</h4>
	 *
	 * This method will remove the current object from the provided container.
	 *
	 * The method expects a single parameter, <tt>$theContainer</tt>, which represents the
	 * container in which the object should be stored. This container must be a concrete
	 * instance of the {@link CContainer} class.
	 *
	 * The method will raise an exception if the object has not the {@link _IsInited()}
	 * status set.
	 *
	 * Once the object has been deleted, it will have its {@link _IsCommitted()} status and
	 * its {@link _IsDirty()} status reset.
	 *
	 * The method will return <tt>TRUE</tt> if the object was deleted or <tt>FALSE</tt> if
	 * the object was not found in the container.
	 *
	 * @param CContainer			$theContainer		Container.
	 *
	 * @access public
	 * @return boolean				<tt>TRUE</tt> deleted, <tt>FALSE</tt> not found.
	 *
	 * @uses _IsDirty()
	 * @uses _IsInited()
	 * @uses _IsCommitted()
	 */
	public function Delete( CContainer $theContainer )
	{
		//
		// Only if inited.
		//
		if( ! $this->_IsInited() )
			throw new \Exception
				( "The object is not initialised",
				  kERROR_STATE );												// !@! ==>
		
		//
		// Delete object.
		//
		if( $theContainer->ManageObject( $this, NULL, kFLAG_PERSIST_DELETE ) )
		{
			//
			// Reset commit status.
			//
			$this->_IsCommitted( FALSE );
			
			//
			// Reset dirty status.
			//
			$this->_IsDirty( FALSE );
		
		} // Deleted.
		
		return FALSE;																// ==>
	
	} // Delete.
		


/*=======================================================================================
 *																						*
 *								STATIC PERSISTENCE INTERFACE							*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	HashIndex																		*
	 *==================================================================================*/

	/**
	 * <h4>Hash index</h4>
	 *
	 * This method is used to obtain a value that can be used as a local unique identifier
	 * to store or locate an object. It expects a string in input as the one that would be
	 * returned by the {@link _index()} method and should return the value that would be
	 * used as the object's local unique identifier, {@link kTAG_LID}.
	 *
	 * By default the result of the {@link _index()} method is used as-is, derived classes
	 * should implement this method if they need a hashed value.
	 *
	 * @param string				$theValue			Value to hash.
	 *
	 * @static
	 * @return string
	 */
	static function HashIndex( $theValue )							{	return $theValue;	}
		


/*=======================================================================================
 *																						*
 *							PROTECTED IDENTIFICATION INTERFACE							*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_id																				*
	 *==================================================================================*/

	/**
	 * <h4>Return the object's local unique identifier</h4>
	 *
	 * This method should return the object's local unique identifier, this value will be
	 * stored in the {@link kTAG_LID} offset and represent the object's unique key or native
	 * primary key of the container.
	 *
	 * By default, this value must correspond in some way to the global unique identifier
	 * which is generated by the {@link _index()} protected method and optionally stored in
	 * the {@link kTAG_GID} offset. In general this method will return the value of
	 * {@link _index()} as-is, or hashed.
	 *
	 * This method will be called before committing the object to a container and only if
	 * the {@link kTAG_LID} offset does not yet exist.
	 *
	 * By default this method uses the static {@link HashIndex()} method to format the
	 * identifier, derived classes should overload the static method if they want to hash
	 * the id.
	 *
	 * @access protected
	 * @return mixed				The object's local unique identifier.
	 *
	 * @uses _index()
	 */
	protected function _id()			{	return self::HashIndex( $this->_index() );		}

	 
	/*===================================================================================
	 *	_index																			*
	 *==================================================================================*/

	/**
	 * <h4>Return the object's global unique identifier</h4>
	 *
	 * This method should return the object's global unique identifier, this value is
	 * represented by a string which is generally extracted from selected attributes of the
	 * object and must represent the unique key of the object.
	 *
	 * This string is optionally stored in the {@link kTAG_GID} offset of the object and is
	 * used unchanged or hashed to generate the object's local unique identifier returned by
	 * the {@link _id()} method.
	 *
	 * If this method returns <tt>NULL</tt>, it means that the local unique identifier is
	 * generated by the container that will store the object, in that case the
	 * {@link kTAG_GID} will most likely not be used.
	 *
	 * This method should only be called when generating the object identifier for the first
	 * time and the object must be in an {@link _IsInited()} state, or this method will
	 * raise an exception.
	 *
	 * This method will be called before committing the object to a container and only if
	 * the {@link kTAG_GID} offset does not yet exist.
	 *
	 * This class has no predefined attributes, so by default it will let the container
	 * generate the identifier.
	 *
	 * @access protected
	 * @return string|NULL			The object's global unique identifier.
	 *
	 * @uses _index()
	 */
	protected function _index()											{	return NULL;	}
		


/*=======================================================================================
 *																						*
 *							PROTECTED PERSISTENCE INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_PrepareInsert																	*
	 *==================================================================================*/

	/**
	 * <h4>Prepare the object before inserting</h4>
	 *
	 * This method will be called before the object gets inserted, its main duty is to:
	 *
	 * <ul>
	 *	<li><i>Fill identifiers</i>: The {@link kTAG_LID} and {@link kTAG_GID} offsets will
	 *		be set if not yet filled.
	 *	<li><i>Fill class name</i>: The {@link kTAG_CLASS} will be updated with the current
	 *		class name.
	 * </ul>
	 *
	 * This operation should only be performed the first time the object is committed, by
	 * default this information should not change once generated.
	 *
	 * @access protected
	 * @return mixed				The object's local unique identifier.
	 *
	 * @uses _index()
	 */
	protected function _PrepareInsert()
	{
		//
		// Check object status.
		//
		if( ! $this->_IsInited() )
			throw new \Exception
				( "The object is not initialised",
				  kERROR_STATE );												// !@! ==>
	
		//
		// Set local identifier.
		//
		if( ! $this->offsetExists( kTAG_LID ) )
			$this->offsetSet( kTAG_LID, $this->_id() );
	
		//
		// Set global identifier.
		//
		if( ! $this->offsetExists( kTAG_GID ) )
			$this->offsetSet( kTAG_GID, $this->_index() );
	
	} // _PrepareInsert.

	 

} // class CPersistentObject.


?>
