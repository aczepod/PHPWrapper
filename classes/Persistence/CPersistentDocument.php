<?php namespace MyWrapper\Persistence;

/**
 * <i>CPersistentDocument</i> class definition.
 *
 * This file contains the class definition of <b>CPersistentDocument</b> which represents
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
 *								CPersistentDocument.php									*
 *																						*
 *======================================================================================*/

/**
 * Ancestor.
 *
 * This includes the ancestor class definitions.
 */
use MyWrapper\Framework\CStatusDocument;

/**
 * Containers.
 *
 * This includes the containers ancestor class definitions.
 */
use MyWrapper\Framework\CContainer;

/**
 * <h3>Persistent document ancestor</h3>
 *
 * This class implements a document object that knows how to persist in derived concrete
 * instances of the {@link CContainer} class.
 *
 * This class implements a series of persistence methods:
 *
 * <ul>
 *	<li>{@link Create()}: This static method can be used to instantiate an object by
 *		retrieving it from a container.
 *	<li>{@link Insert()}: This method will insert the object into a container, if the object
 *		already exists, the method will raise an exception.
 *	<li>{@link Update()}: This method will update the object into a container, if the object
 *		does not exists in the container, the method will raise an exception.
 *	<li>{@link Replace()}: This method will either insert, if the object is not there yet,
 *		or update, if it already exists, the object into a container.
 *	<li>{@link Delete()}: This method will delete the object from a container.
 * </ul>
 *
 * This class makes use of the status interface inherited from {@link CStatusDocument}: the
 * {@link _IsCommitted()} status is set when the object is loaded or committed to the
 * container, and the {@link _IsDirty()} status is used to determine whether the object
 * needs to be committed to a container; if the object is not in the {@link _IsInited()}
 * state, it cannot be committed.
 *
 *	@package	MyWrapper
 *	@subpackage	Persistence
 */
class CPersistentDocument extends CStatusDocument
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
	 * This method will retrieve an object the provided container, if the object contains
	 * the {@link kTAG_CLASS} offset, the method will attempt to instantiate that specific
	 * class, if not, the method will return an instance of this class. Note that the class
	 * provided in the {@link kTAG_CLASS} offset must derive from this class.
	 *
	 * The method expects two parameters:
	 *
	 * <ul>
	 *	<li><tt>$theContainer</tt>: A concrete instance of the {@link CContainer} class.
	 *	<li><tt>$theIdentifier</tt>: The key of the object in the container, by default the
	 *		{@link kTAG_LID} offset.
	 * </ul>
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
				
				//
				// Set committed status.
				//
				$object->_IsCommitted( TRUE );
				
				return $object;													// ==>
			
			} // Custom class.
			
			//
			// Instantiate class.
			//
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
	 * This method will insert the current object into the provided container, if a
	 * duplicate object already exists in the container, the method will raise an exception.
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
	 * ({@link kTAG_LID}), <tt>NULL</tt> if the operation is not necessary or raise an
	 * exception if an error occurs.
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

	 

} // class CPersistentDocument.


?>
