<?php namespace MyWrapper\Persistence;

/**
 * <i>CPersistentDocument</i> class definition.
 *
 * This file contains the class definition of <b>CPersistentDocument</b> which represents
 * the ancestor of all persistent document classes.
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
 * Containers.
 *
 * This includes the containers ancestor class definitions.
 */
use MyWrapper\Framework\CContainer;

/**
 * Ancestor.
 *
 * This includes the ancestor class definitions.
 */
use MyWrapper\Framework\CStatusDocument;

/**
 * <h3>Persistent document ancestor</h3>
 *
 * A persistent document object is a document object that knows how to persist in derived
 * concrete instances of the {@link CContainer} class. This class adds a single default
 * offset, {@link kTAG_LID}, which represents the database native unique identifier. All
 * objects derived from this class are uniquely identified by this offset.
 *
 * This class implements a series of persistence methods:
 *
 * <ul>
 *	<li>{@link NewObject()}: This static method can be used to instantiate an object by
 *		retrieving it from a container.
 *	<li>{@link Insert()}: This method will insert the object into a container, if the object
 *		already exists, the method will raise an exception.
 *	<li>{@link Update()}: This method will update the object in a container, if the object
 *		does not exist, the method will raise an exception.
 *	<li>{@link Replace()}: This method will either insert, if the object is not found in the
 *		container, or update, if the object exists in the container.
 *	<li>{@link Restore()}: This method will load the object from the container and restore
 *		its data, the method expects the object to have its local unique identifier,
 *		{@link kTAG_LID}, set, or it will raise an exception.
 *	<li>{@link Delete()}: This method will delete the object from a container.
 * </ul>
 *
 * These methods take advantage of a protected interface which can be used to process the
 * object before, {@link _Precommit()}, and after, {@link Postcommit()} it is committed,
 * these are the methods that derived classes should overload to implement custom workflows.
 *
 * In this class we set the {@link _IsCommitted()} status and reset the {@link _IsDirty()}
 * status whenever the object is stored or loaded from a container, and reset both when the
 * object is deleted.
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
	 *	NewObject																		*
	 *==================================================================================*/

	/**
	 * <h4>Instantiate an object from a container</h4>
	 *
	 * This method will retrieve a document from the provided container, instantiate this
	 * class with it and return the object; if the document was not located in the
	 * container, the method will return <tt>NULL</tt>.
	 *
	 * The method expects two parameters:
	 *
	 * <ul>
	 *	<li><tt>$theContainer</tt>: A concrete instance of the {@link CContainer} class.
	 *	<li><tt>$theIdentifier</tt>: The key of the object in the container, by default the
	 *		{@link kTAG_LID} offset.
	 * </ul>
	 *
	 * @param CContainer			$theContainer		Container.
	 * @param mixed					$theIdentifier		Identifier.
	 *
	 * @static
	 * @return mixed				The retrieved object.
	 */
	static function NewObject( CContainer $theContainer, $theIdentifier )
	{
		//
		// Init local storage.
		//
		$object = array( kTAG_LID => $theIdentifier );
		
		//
		// Retrieve object.
		//
		if( $theContainer->ManageObject( $object ) )
		{
			//
			// Instantiate class.
			//
			$object = new self( $object );
			
			//
			// Post-commit.
			//
			$object->_Postcommit( $theContainer );
			
			return $object;															// ==>
		
		} // Located.
		
		return NULL;																// ==>
	
	} // NewObject.
		


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
	 * container in which the object should be stored. This parameter must be a concrete
	 * instance of the {@link CContainer} class.
	 *
	 * The method may set the local unique identifier attribute ({@link kTAG_LID}) if not
	 * provided.
	 *
	 * The operation will only be performed if the object has the {@link _IsDirty()} status
	 * set or if it does not have its {@link _IsCommitted()} status set, in this event the
	 * method will return <tt>NULL</tt>.
	 *
	 * The method will return the object's local unique identifier attribute
	 * ({@link kTAG_LID}), or raise an exception if an error occurs.
	 *
	 * Note that derived classes should overload the {@link _Precommit()} and
	 * {@link _Postcommit()} methods, rather than overloading this one.
	 *
	 * @param CContainer			$theContainer		Container.
	 *
	 * @access public
	 * @return mixed				The object's local identifier.
	 *
	 * @uses _IsDirty()
	 * @uses _IsCommitted()
	 * @uses _Precommit()
	 * @uses _Postcommit()
	 *
	 * @see kFLAG_PERSIST_INSERT
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
			// Set operation.
			//
			$op = kFLAG_PERSIST_INSERT;
			
			//
			// Pre-commit.
			//
			$this->_Precommit( $theContainer, $op );
			
			//
			// Commit object.
			//
			$status = $theContainer->ManageObject( $this, NULL, $op );
			
			//
			// Post-commit.
			//
			$this->_Postcommit( $theContainer, $op );
			
			return $status;															// ==>
		
		} // Dirty or not yet committed.
		
		return NULL;																// ==>
	
	} // Insert.

	 
	/*===================================================================================
	 *	Update																			*
	 *==================================================================================*/

	/**
	 * <h4>Update the object in a container</h4>
	 *
	 * This method will update the current object into the provided container, if the object
	 * cannot be found in the container, the method will raise an exception.
	 *
	 * The method expects a single parameter, <tt>$theContainer</tt>, which represents the
	 * container in which the object should be stored. This container must be a concrete
	 * instance of the {@link CContainer} class.
	 *
	 * Once the object has been stored, it will have its {@link _IsCommitted()} status set
	 * and its {@link _IsDirty()} status reset.
	 *
	 * The method will raise an exception if the object has not the {@link _IsInited()}
	 * status set.
	 *
	 * Note that derived classes should overload the {@link _Precommit()} and
	 * {@link _Postcommit()} methods, rather than overloading this one.
	 *
	 * @param CContainer			$theContainer		Container.
	 *
	 * @access public
	 *
	 * @throws \Exception
	 *
	 * @uses _IsDirty()
	 * @uses _IsCommitted()
	 * @uses _Precommit()
	 * @uses _Postcommit()
	 *
	 * @see kFLAG_PERSIST_UPDATE
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
			// Set operation.
			//
			$op = kFLAG_PERSIST_UPDATE;
			
			//
			// Pre-commit.
			//
			$this->_Precommit( $theContainer, $op );
			
			//
			// Commit object.
			//
			if( ! $theContainer->ManageObject( $this, NULL, $op ) )
				throw new \Exception
					( "Object not found",
					  kERROR_NOT_FOUND );										// !@! ==>
			
			//
			// Post-commit.
			//
			$this->_Postcommit( $theContainer, $op );
		
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
	 * The method may set the local unique identifier attribute ({@link kTAG_LID}) if not
	 * provided.
	 *
	 * The method will return the object's local unique identifier attribute
	 * ({@link kTAG_LID}) or <tt>NULL</tt> if the operation was not necessary.
	 *
	 * Note that derived classes should overload the {@link _Precommit()} and
	 * {@link _Postcommit()} methods, rather than overloading this one.
	 *
	 * @param CContainer			$theContainer		Container.
	 *
	 * @access public
	 * @return mixed				The object's local identifier.
	 *
	 * @uses _IsDirty()
	 * @uses _IsCommitted()
	 * @uses _Precommit()
	 * @uses _Postcommit()
	 *
	 * @see kFLAG_PERSIST_REPLACE
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
			// Set operation.
			//
			$op = kFLAG_PERSIST_REPLACE;
			
			//
			// Pre-commit.
			//
			$this->_Precommit( $theContainer, $op );
			
			//
			// Commit object.
			//
			$status = $theContainer->ManageObject( $this, NULL, $op );
			
			//
			// Post-commit.
			//
			$this->_Postcommit( $theContainer, $op );
			
			return $status;															// ==>
		
		} // Dirty or not yet committed.
		
		return NULL;																// ==>
	
	} // Replace.

	 
	/*===================================================================================
	 *	Restore																			*
	 *==================================================================================*/

	/**
	 * <h4>Restore the object from a container</h4>
	 *
	 * This method will load the current object with data from a document in a container.
	 *
	 * The method expects a single parameter, <tt>$theContainer</tt>, which represents the
	 * container in which the object is stored.
	 *
	 * The current object must have its local unique identifier offset, {@link kTAG_LID},
	 * set, or it must have all the necessary elements in order to generate this identifier.
	 *
	 * The method will return <tt>TRUE</tt> if the operation was successful, <tt>NULL</tt>
	 * if the object is not present in the container, or raise an exception if an error
	 * occurs.
	 *
	 * If the operation succeeds, the {@link _IsDirty()} status will be reset and the
	 * {@link _IsCommitted()} status will be set.
	 *
	 * Note that derived classes should overload the {@link _Postcommit()} method, rather
	 * than overloading this one, also note that the {@link _Precommit()} method is
	 * obviously not called here.
	 *
	 * @param CContainer			$theContainer		Container.
	 *
	 * @access public
	 * @return mixed				The operation status.
	 *
	 * @throws \Exception
	 *
	 * @uses _Postcommit()
	 *
	 * @see kTAG_LID
	 */
	public function Restore( CContainer $theContainer )
	{
		//
		// Use local identifier.
		//
		if( $this->offsetExists( kTAG_LID ) )
		{
			//
			// Clone.
			//
			$clone = $this->getArrayCopy();
			
			//
			// Load.
			//
			if( $theContainer->ManageObject( $clone ) )
			{
				//
				// Load data.
				//
				$this->exchangeArray( $clone );
				
				//
				// Post-load.
				//
				$this->_Postcommit( $theContainer );
				
				return TRUE;														// ==>
			
			} // Found object.
			
			return NULL;															// ==>
		
		} // Has identifier.
		
		throw new \Exception
			( "Missing object identifier",
			  kERROR_STATE );													// !@! ==>
	
	} // Restore.

	 
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
	 * Once the object has been deleted, it will have its {@link _IsCommitted()} status and
	 * its {@link _IsDirty()} status reset.
	 *
	 * The method will return <tt>TRUE</tt> if the object was deleted or <tt>FALSE</tt> if
	 * the object was not found in the container.
	 *
	 * Note that derived classes should overload the {@link _Precommit()} and
	 * {@link _Postcommit()} methods, rather than overloading this one.
	 *
	 * @param CContainer			$theContainer		Container.
	 *
	 * @access public
	 * @return boolean				<tt>TRUE</tt> deleted, <tt>FALSE</tt> not found.
	 *
	 * @uses _Postcommit()
	 */
	public function Delete( CContainer $theContainer )
	{
		//
		// Delete object.
		//
		if( $theContainer->ManageObject( $this, NULL, kFLAG_PERSIST_DELETE ) )
		{
			//
			// Post-load.
			//
			$this->_Postcommit( $theContainer );
			
			return TRUE;															// ==>
		
		} // Deleted.
		
		return FALSE;																// ==>
	
	} // Delete.
		


/*=======================================================================================
 *																						*
 *							PROTECTED PERSISTENCE INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_Precommit																		*
	 *==================================================================================*/

	/**
	 * <h4>Prepare the object before committing</h4>
	 *
	 * This method will be called before the object gets committed, its main duty is to
	 * check whether the object has all the required elements and to set all default data.
	 * 
	 * The method accepts two parameters:
	 *
	 * <ul>
	 *	<li><tt>$theContainer</tt>: The container in which the object is to be committed.
	 *	<li><tt>$theModifiers</tt>: The commit options provided as a bitfield in which the
	 *		following values are considered:
	 *	 <ul>
	 *		<li><tt>{@link kFLAG_PERSIST_INSERT}</tt>: Insert operation.
	 *		<li><tt>{@link kFLAG_PERSIST_UPDATE}</tt>: Update operation.
	 *		<li><tt>{@link kFLAG_PERSIST_REPLACE}</tt>: Replace operation.
	 *		<li><tt>{@link kFLAG_PERSIST_MODIFY}</tt>: Modification operation.
	 *		<li><tt>{@link kFLAG_PERSIST_DELETE}</tt>: Delete operation.
	 *	 </ul>
	 * </ul>
	 *
	 * If the conditions for committing the object are not met, the method should raise an
	 * exception.
	 *
	 * Derived classes can overload this method to implement custom behaviour.
	 *
	 * In this class we do nothing.
	 *
	 * @param CContainer			$theContainer		Container.
	 * @param bitfield				$theModifiers		Commit options.
	 *
	 * @access protected
	 */
	protected function _Precommit( CContainer $theContainer,
											  $theModifiers = kFLAG_DEFAULT )			   {}

	 
	/*===================================================================================
	 *	_Postcommit																		*
	 *==================================================================================*/

	/**
	 * <h4>Prepare the object after committing</h4>
	 *
	 * This method will be called after the object gets committed, its main duty is to
	 * update the object status and normalise eventual elements.
	 * 
	 * The method accepts two parameters:
	 *
	 * <ul>
	 *	<li><tt>$theContainer</tt>: The container in which the object was committed.
	 *	<li><tt>$theModifiers</tt>: The commit options provided as a bitfield in which the
	 *		following values are considered:
	 *	 <ul>
	 *		<li><tt>{@link kFLAG_PERSIST_INSERT}</tt>: Insert operation.
	 *		<li><tt>{@link kFLAG_PERSIST_UPDATE}</tt>: Update operation.
	 *		<li><tt>{@link kFLAG_PERSIST_REPLACE}</tt>: Replace operation.
	 *		<li><tt>{@link kFLAG_PERSIST_MODIFY}</tt>: Modification operation.
	 *		<li><tt>{@link kFLAG_PERSIST_DELETE}</tt>: Delete operation.
	 *	 </ul>
	 * </ul>
	 *
	 * Derived classes can overload this method to implement custom behaviour.
	 *
	 * In this class we reset the {@link _IsDirty()} status after committing or loading the
	 * object, set the {@link _IsCommitted()} status after committing and resetting it after
	 * deleting.
	 *
	 * @param CContainer			$theContainer		Container.
	 * @param bitfield				$theModifiers		Commit options.
	 *
	 * @access protected
	 */
	protected function _Postcommit( CContainer $theContainer,
											   $theModifiers = kFLAG_DEFAULT )
	{
		//
		// Handle commit and load.
		//
		if( ($theModifiers & kFLAG_PERSIST_WRITE_MASK)	// Commit,
		 || (! ($theModifiers & kFLAG_PERSIST_MASK)) )	// load.
		{
			//
			// Reset the dirty flag.
			//
			$this->_IsDirty( FALSE );
			
			//
			// Set the committed flag.
			//
			$this->_IsCommitted( TRUE );
		
		} // Insert, update, replace, reset and modify (not used).
		
		//
		// Handle delete.
		//
		elseif( ($theModifiers & kFLAG_PERSIST_MASK) == kFLAG_PERSIST_DELETE )
			$this->_IsCommitted( FALSE );
	
	} // _Postcommit.

	 

} // class CPersistentDocument.


?>
