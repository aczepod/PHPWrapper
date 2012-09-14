<?php

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
 * Local definitions.
 *
 * This include file contains common offset definitions.
 */
require_once( "CPersistentDocument.inc.php" );

/**
 * Container.
 *
 * This includes the containers ancestor class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CContainer.php" );

/**
 * Ancestor.
 *
 * This includes the ancestor class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CStatusDocument.php" );

/**
 * <h3>Persistent document ancestor</h3>
 *
 * A persistent document object is a document object that knows how to persist in derived
 * concrete instances of the {@link CContainer} class. This class features a default offset,
 * {@link kOFFSET_NID}, which represents the database native unique identifier, or primary
 * key. All objects derived from this class are uniquely identified by this offset.
 *
 * This class implements a series of persistence methods:
 *
 * <ul>
 *	<li>{@link Insert()}: This method will insert the object into a container, if the object
 *		already exists, the method will raise an exception.
 *	<li>{@link Update()}: This method will update the object in a container, if the object
 *		does not exist, the method will raise an exception.
 *	<li>{@link Replace()}: This method will either insert, if the object is not found in the
 *		container, or update, if the object exists in the container.
 *	<li>{@link Restore()}: This method will load the object from the container and restore
 *		its data, the method expects the object to have its native unique identifier,
 *		{@link kOFFSET_NID}, set, or it will raise an exception.
 *	<li>{@link Delete()}: This method will delete the object from a container.
 *	<li>{@link NewObject()}: This static method can be used to instantiate an object by
 *		retrieving it from a container. The class of the object will be set according to
 *		the class used in the static call.
 * </ul>
 *
 * These methods take advantage of a protected interface which can be used to process the
 * object before, {@link _Precommit()}, and after, {@link Postcommit()} it is committed,
 * these are the methods that derived classes should overload to implement custom workflows.
 * In this class we use it to set the {@link _IsCommitted()} status and reset the
 * {@link _IsDirty()} status whenever the object is stored or loaded from a container, and
 * reset both when the object is deleted.
 *
 * The class also implements an interface to handle the {@link _IsInited()} status: a
 * protected method, {@link _Ready()}, can be used to return a boolean that indicates
 * whether the object has all the required components, this is performed in the
 * {@link _Postset()} and {@link _Postunset()} methods. For this reason we also overload the
 * constructor to initialise the {@link _IsInited()} status, by default the object is
 * initialised.
 *
 * The method implements an accessor method for the native unique identifier, {@link NID()}.
 *
 *	@package	MyWrapper
 *	@subpackage	Persistence
 */
class CPersistentDocument extends CStatusDocument
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
	 * We overload the inherited constructor to set the {@link _IsInited()} status according
	 * to the data set in the object.
	 *
	 * This constructor mirrors the {@link ArrayObject} constructor.
	 *
	 * @param mixed					$theInput			Input parameter.
	 * @param integer				$theFlags			Control flags.
	 * @param string				$theIterator		Control flags.
	 *
	 * @access public
	 *
	 * @uses _Ready()
	 * @uses _IsInited()
	 */
	public function __construct( $theInput = Array(),
								 $theFlags = 0,
								 $theIterator = 'ArrayIterator' )
	{
		//
		// Call parent constructor.
		//
		parent::__construct( $theInput, $theFlags, $theIterator );
		
		//
		// Initialise the initialise status.
		//
		$this->_IsInited( $this->_Ready() );
		
	} // Constructor.
		


/*=======================================================================================
 *																						*
 *								PUBLIC MEMBER INTERFACE									*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	NID																				*
	 *==================================================================================*/

	/**
	 * <h4>Manage native unique identifier</h4>
	 *
	 * The <i>native unique identifier</i>, {@link kOFFSET_NID}, represents the primary key
	 * of the object in the native format of the container in which the object is stored.
	 *
	 * The method accepts a parameter which represents either the identifier or the
	 * requested operation, depending on its value:
	 *
	 * <ul>
	 *	<li><tt>NULL</tt>: Return the current value.
	 *	<li><tt>FALSE</tt>: Delete the current value.
	 *	<li><i>other</i>: Set the value with the provided parameter.
	 * </ul>
	 *
	 * The second parameter is a boolean which if <tt>TRUE</tt> will return the <i>old</i>
	 * value when replacing containers; if <tt>FALSE</tt>, it will return the currently set
	 * value.
	 *
	 * Note that when the object has the {@link _IsCommitted()} status this offset will be
	 * locked and an exception will be raised.
	 *
	 * @param mixed					$theValue			Native identifier or operation.
	 * @param boolean				$getOld				<tt>TRUE</tt> get old value.
	 *
	 * @access public
	 * @return mixed				<i>New</i> or <i>old</i> native container.
	 *
	 * @uses ManageOffset()
	 *
	 * @see kOFFSET_NID
	 */
	public function NID( $theValue = NULL, $getOld = FALSE )
	{
		return ManageOffset( $this, kOFFSET_NID, $theValue, $getOld );				// ==>

	} // NID.

		

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
	 * The method expects a single parameter, <tt>$theConnection</tt>, which represents the
	 * container in which the object should be stored. This parameter should be a concrete
	 * instance of of {@link CContainer}, or a concrete instance of {@link CServer} or
	 * {@link CDatabase}, if the current class has implemented the container resolve
	 * interface with {@link DefaultDatabase} and {@link DefaultContainer()}.
	 *
	 * The method may set the native unique identifier attribute ({@link kOFFSET_NID}) if
	 * not provided.
	 *
	 * The operation will only be performed if the object has the {@link _IsDirty()} status
	 * set or if it does not have its {@link _IsCommitted()} status set, in this event the
	 * method will return <tt>NULL</tt>.
	 *
	 * The method will return the object's native unique identifier attribute
	 * ({@link kOFFSET_NID}), or raise an exception if an error occurs.
	 *
	 * Note that derived classes should overload the {@link _Precommit()} and
	 * {@link _Postcommit()} methods, rather than overloading this one.
	 *
	 * @param CConnection			$theConnection		Server, database or container.
	 *
	 * @access public
	 * @return mixed				The object's native identifier.
	 *
	 * @throws Exception
	 *
	 * @uses _IsDirty()
	 * @uses _IsCommitted()
	 * @uses DefaultDatabase()
	 * @uses DefaultContainer()
	 * @uses _Precommit()
	 * @uses _Postcommit()
	 *
	 * @see kFLAG_PERSIST_INSERT
	 */
	public function Insert( CConnection $theConnection )
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
			$this->_Precommit( $theConnection, $op );
			
			//
			// Commit object.
			//
			$status = $this
						->ResolveContainer( $theConnection, TRUE )
						->ManageObject( $this, NULL, $op );
			
			//
			// Post-commit.
			//
			$this->_Postcommit( $theConnection, $op );
			
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
	 * The method expects a single parameter, <tt>$theConnection</tt>, which represents the
	 * container in which the object should be stored. This parameter should be a concrete
	 * instance of of {@link CContainer}, or a concrete instance of {@link CServer} or
	 * {@link CDatabase}, if the current class has implemented the container resolve
	 * interface with {@link DefaultDatabase} and {@link DefaultContainer()}.
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
	 * @param CConnection			$theConnection		Server, database or container.
	 *
	 * @access public
	 *
	 * @throws Exception
	 *
	 * @uses _IsDirty()
	 * @uses _IsCommitted()
	 * @uses DefaultDatabase()
	 * @uses DefaultContainer()
	 * @uses _Precommit()
	 * @uses _Postcommit()
	 *
	 * @see kFLAG_PERSIST_UPDATE
	 */
	public function Update( CConnection $theConnection )
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
			$this->_Precommit( $theConnection, $op );
			
			//
			// Commit object.
			//
			if( ! $this
					->ResolveContainer( $theConnection, TRUE )
					->ManageObject( $this, NULL, $op ) )
				throw new Exception
					( "Object not found",
					  kERROR_NOT_FOUND );										// !@! ==>
			
			//
			// Post-commit.
			//
			$this->_Postcommit( $theConnection, $op );
		
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
	 * The method expects a single parameter, <tt>$theConnection</tt>, which represents the
	 * container in which the object should be stored. This parameter should be a concrete
	 * instance of of {@link CContainer}, or a concrete instance of {@link CServer} or
	 * {@link CDatabase}, if the current class has implemented the container resolve
	 * interface with {@link DefaultDatabase} and {@link DefaultContainer()}.
	 *
	 * The operation will only be performed if the object is not yet committed or if the
	 * object has its {@link _IsDirty()} dirty status set, if not, the method will do
	 * nothing.
	 *
	 * Once the object has been stored, it will have its {@link _IsCommitted()} status set
	 * and its {@link _IsDirty()} status reset.
	 *
	 * The method may set the native unique identifier attribute ({@link kOFFSET_NID}) if
	 * not provided.
	 *
	 * The method will return the object's native unique identifier attribute
	 * ({@link kOFFSET_NID}) or <tt>NULL</tt> if the operation was not necessary.
	 *
	 * Note that derived classes should overload the {@link _Precommit()} and
	 * {@link _Postcommit()} methods, rather than overloading this one.
	 *
	 * @param CConnection			$theConnection		Server, database or container.
	 *
	 * @access public
	 * @return mixed				The object's native identifier.
	 *
	 * @uses _IsDirty()
	 * @uses _IsCommitted()
	 * @uses DefaultDatabase()
	 * @uses DefaultContainer()
	 * @uses _Precommit()
	 * @uses _Postcommit()
	 *
	 * @see kFLAG_PERSIST_REPLACE
	 */
	public function Replace( CConnection $theConnection )
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
			$this->_Precommit( $theConnection, $op );
			
			//
			// Commit object.
			//
			$status = $this
						->ResolveContainer( $theConnection, TRUE )
						->ManageObject( $this, NULL, $op );
			
			//
			// Post-commit.
			//
			$this->_Postcommit( $theConnection, $op );
			
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
	 * The method expects a single parameter, <tt>$theConnection</tt>, which represents the
	 * container in which the object should be stored. This parameter should be a concrete
	 * instance of of {@link CContainer}, or a concrete instance of {@link CServer} or
	 * {@link CDatabase}, if the current class has implemented the container resolve
	 * interface with {@link DefaultDatabase} and {@link DefaultContainer()}.
	 *
	 * The current object must have its native unique identifier offset,
	 * {@link kOFFSET_NID}, set, or it must have all the necessary elements in order to
	 * generate this identifier.
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
	 * @param CConnection			$theConnection		Server, database or container.
	 *
	 * @access public
	 * @return mixed				The operation status.
	 *
	 * @throws Exception
	 *
	 * @uses DefaultDatabase()
	 * @uses DefaultContainer()
	 * @uses _Postcommit()
	 *
	 * @see kOFFSET_NID
	 */
	public function Restore( CConnection $theConnection )
	{
		//
		// Use native identifier.
		//
		if( $this->offsetExists( kOFFSET_NID ) )
		{
			//
			// Clone.
			//
			$clone = $this->getArrayCopy();
			
			//
			// Load.
			//
			if( $this
				->ResolveContainer( $theConnection, TRUE )
				->ManageObject( $clone ) )
			{
				//
				// Load data.
				//
				$this->exchangeArray( $clone );
				
				//
				// Post-load.
				//
				$this->_Postcommit( $theConnection );
				
				return TRUE;														// ==>
			
			} // Found object.
			
			return NULL;															// ==>
		
		} // Has identifier.
		
		throw new Exception
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
	 * The method expects a single parameter, <tt>$theConnection</tt>, which represents the
	 * container in which the object should be stored. This parameter should be a concrete
	 * instance of of {@link CContainer}, or a concrete instance of {@link CServer} or
	 * {@link CDatabase}, if the current class has implemented the container resolve
	 * interface with {@link DefaultDatabase} and {@link DefaultContainer()}.
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
	 * @param CConnection			$theConnection		Server, database or container.
	 *
	 * @access public
	 * @return boolean				<tt>TRUE</tt> deleted, <tt>FALSE</tt> not found.
	 *
	 * @uses DefaultDatabase()
	 * @uses DefaultContainer()
	 * @uses _Postcommit()
	 */
	public function Delete( CConnection $theConnection )
	{
		//
		// Set operation.
		//
		$op = kFLAG_PERSIST_DELETE;
		
		//
		// Delete object.
		//
		if( $this
			->ResolveContainer( $theConnection, TRUE )
			->ManageObject( $this, NULL, $op ) )
		{
			//
			// Post-load.
			//
			$this->_Postcommit( $theConnection, $op );
			
			return TRUE;															// ==>
		
		} // Deleted.
		
		return FALSE;																// ==>
	
	} // Delete.

		

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
	 * The method expects a single parameter, <tt>$theConnection</tt>, which represents the
	 * container in which the object should be stored. This parameter should be a concrete
	 * instance of of {@link CContainer}, or a concrete instance of {@link CServer} or
	 * {@link CDatabase}, if the current class has implemented the container resolve
	 * interface with {@link DefaultDatabase} and {@link DefaultContainer()}.
	 *
	 * The method expects two parameters:
	 *
	 * <ul>
	 *	<li><tt>$theConnection</tt>: The container in which the object should be stored.
	 *		This parameter should be a concrete instance of of {@link CContainer}, or a
	 *		concrete instance of {@link CServer} or {@link CDatabase}, if the current class
	 *		has implemented the container resolve interface with {@link DefaultDatabase} and
	 *		{@link DefaultContainer()}.
	 *	<li><tt>$theIdentifier</tt>: The key of the object in the container, by default the
	 *		{@link kOFFSET_NID} offset.
	 * </ul>
	 *
	 * If the object could not be located, the method will return <tt>NULL</tt>.
	 *
	 * Note that the resulting object will be of the class with which this static method was
	 * called.
	 *
	 * @param CConnection			$theConnection		Server, database or container.
	 * @param mixed					$theIdentifier		Identifier.
	 *
	 * @static
	 * @return mixed				The retrieved object.
	 */
	static function NewObject( CConnection $theConnection, $theIdentifier )
	{
		//
		// Init local storage.
		//
		$object = array( kOFFSET_NID => $theIdentifier );
		
		//
		// Retrieve object.
		//
		if( static::ResolveContainer( $theConnection, TRUE )->ManageObject( $object ) )
		{
			//
			// Instantiate class.
			// Note the static keyword?
			// If we used self, this would be the class generated;
			// with static, it will be the caller's class.
			//
			$object = new static( $object );
			
			//
			// Post-commit.
			//
			$object->_Postcommit( $theConnection );
			
			return $object;															// ==>
		
		} // Located.
		
		return NULL;																// ==>
	
	} // NewObject.

		

/*=======================================================================================
 *																						*
 *								STATIC CONNECTION INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	DefaultDatabase																	*
	 *==================================================================================*/

	/**
	 * <h4>Return the object default database</h4>
	 *
	 * This static method should be used to get the the class default database given a
	 * server. It expects a {@link CServer} derived object and should return a
	 * {@link CDatabase} derived object.
	 *
	 * If the class does not feature a default database, this method should return
	 * <tt>NULL</tt>.
	 *
	 * By default we assume no default containers.
	 *
	 * @param CServer				$theServer			Server object.
	 *
	 * @static
	 * @return CDatabase			The default database.
	 */
	static function DefaultDatabase( CServer $theServer )				{	return NULL;	}

	 
	/*===================================================================================
	 *	DefaultContainer																*
	 *==================================================================================*/

	/**
	 * <h4>Return the object default container</h4>
	 *
	 * This static method should be used to get the the class default container given a
	 * database. It expects a {@link CDatabase} derived object and should return a
	 * {@link CContainer} derived object.
	 *
	 * If the class does not feature a default container, this method should return
	 * <tt>NULL</tt>.
	 *
	 * By default we assume no default containers.
	 *
	 * @param CDatabase				$theDatabase		Database object.
	 *
	 * @static
	 * @return CContainer			The default container.
	 */
	static function DefaultContainer( CDatabase $theDatabase )			{	return NULL;	}

	 
	/*===================================================================================
	 *	ResolveContainer																*
	 *==================================================================================*/

	/**
	 * <h4>Resolve the container</h4>
	 *
	 * This method can be used to get a {@link CContainer} given an instance of
	 * {@link CServer} or {@link CDatabase}. It will take advantage of the
	 * {@link DefaultDatabase()} and {@link DefaultContainer()} methods to obtain the value.
	 *
	 * The first argument of this method is the connection object, the second is a boolean
	 * which determines whether the method should raise an exception if the container cannot
	 * be resolved.
	 *
	 * The method will return an exception regardless of the value of the second parameter
	 * if the first parameter is neither a {@link CServer} or {@link CDatabase} derived
	 * instance.
	 *
	 * @param CConnection			$theConnection		Connection object.
	 * @param boolean				$doException		<tt>TRUE</tt> raise exception.
	 *
	 * @static
	 * @return mixed				{@link CContainer} or <tt>NULL</tt> if not found.
	 *
	 * @throws Exception
	 */
	static function ResolveContainer( CConnection $theConnection, $doException )
	{
		//
		// Resolve database.
		//
		if( $theConnection instanceof CServer )
		{
			//
			// Check database.
			// Note the static keyword:
			// we want the caller's DefaultDatabase().
			//
			$theConnection = static::DefaultDatabase( $theConnection );
			
			//
			// Handle missing default database.
			//
			if( $theConnection === NULL )
			{
				//
				// Raise exception.
				//
				if( $doException )
					throw new Exception
						( "Cannot determine default database",
						  kERROR_PARAMETER );									// !@! ==>
				
				return NULL;														// ==>
			
			} // No default database.
		
		} // Provided server.
		
		//
		// Resolve container.
		// Note the static keyword:
		// we want the caller's DefaultContainer().
		//
		if( $theConnection instanceof CDatabase )
			$theConnection = static::DefaultContainer( $theConnection );
		
		//
		// Check container.
		//
		if( $theConnection instanceof CContainer )
			return $theConnection;													// ==>
		
		//
		// Handle missing default container.
		//
		if( $theConnection === NULL )
		{
			//
			// Raise exception.
			//
			if( $doException )
				throw new Exception
					( "Cannot determine default container",
					  kERROR_PARAMETER );										// !@! ==>
			
			return NULL;															// ==>
		
		} // No default container.
		
		//
		// Raise exception.
		//
		throw new Exception
			( "Invalid connection: expecting server or database",
			  kERROR_PARAMETER );												// !@! ==>
	
	} // ResolveContainer.
		


/*=======================================================================================
 *																						*
 *								PROTECTED OFFSET INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_Postset																		*
	 *==================================================================================*/

	/**
	 * <h4>Handle offset after setting it</h4>
	 *
	 * This method will be called after the offset is set into the object only if the
	 * provided value is not equivalent to the stored value, it gives the chance to
	 * normalise the value after it gets stored in the object.
	 *
	 * The method accepts the same parameters as the {@link offsetSet()} method, except that
	 * they are passed by reference.
	 *
	 * In this class we update the {@link _IsInited()} status.
	 *
	 * @param reference			   &$theOffset			Offset.
	 * @param reference			   &$theValue			Value to set at offset.
	 *
	 * @access protected
	 *
	 * @uses _Ready()
	 * @uses _IsInited()
	 */
	protected function _Postset( &$theOffset, &$theValue )
	{
		//
		// Call parent method.
		//
		parent::_Postset( $theOffset, $theValue );
		
		//
		// Update inited status.
		//
		$this->_IsInited( $this->_Ready() );
	
	} // _Postset.

	 
	/*===================================================================================
	 *	_Postunset																		*
	 *==================================================================================*/

	/**
	 * <h4>Handle offset after unsetting it</h4>
	 *
	 * This method will be called after the offset is unset from the object only if the
	 * provided offset existed in the object, it gives the chance to perform custom actions
	 * after a removal.
	 *
	 * The method accepts the same parameter as the {@link offsetUnset()} method, except that
	 * it passed by reference.
	 *
	 * In this class we set the {@link _IsDirty()} status.
	 *
	 * @param reference			   &$theOffset			Offset.
	 *
	 * @access protected
	 *
	 * @uses _Ready()
	 * @uses _IsInited()
	 */
	protected function _Postunset( &$theOffset )
	{
		//
		// Call parent method.
		//
		parent::_Postunset( $theOffset );
		
		//
		// Update inited status.
		//
		$this->_IsInited( $this->_Ready() );
	
	} // _Postunset.
		


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
	 * check whether the object has all the required elements, to set all default data amd
	 * to commit eventual embedded objects.
	 *
	 * This method calls three other methods which perform the following functions:
	 *
	 * <ul>
	 *	<li>{@link _PrecommitValidate()}: This method's duty is to check if the object is
	 *		fot for being committed.
	 *	<li>{@link _PrecommitRelated()}: This method's duty is to check and commit eventual
	 *		embedded or related objects.
	 *	<li>{@link _PrecommitIdentify()}: This method's duty is to fill the object's
	 *		identifiers.
	 * </ul>
	 *
	 * These three methods are called in the above order, they take the same arguments as
	 * the current method and do not return a value: errors must raise exceptions.
	 *
	 * When deriving from this class you should overload the above methods and not this one.
	 * 
	 * This method accepts two parameters:
	 *
	 * <ul>
	 *	<li><tt>$theConnection</tt>: The container in which the object is to be committed,
	 *		a server or a database if the {@link DefaultDatabase} and
	 *		{@link DefaultContainer()} are able to resolve it into a container.
	 *	<li><tt>$theModifiers</tt>: The commit options provided as a bitfield in which the
	 *		following values are considered:
	 *	 <ul>
	 *		<li><tt>{@link kFLAG_PERSIST_INSERT}</tt>: Insert operation.
	 *		<li><tt>{@link kFLAG_PERSIST_UPDATE}</tt>: Update operation.
	 *		<li><tt>{@link kFLAG_PERSIST_REPLACE}</tt>: Replace operation.
	 *		<li><tt>{@link kFLAG_PERSIST_DELETE}</tt>: Delete operation.
	 *	 </ul>
	 * </ul>
	 *
	 * If the conditions for committing the object are not met, an exception should be
	 * raised.
	 *
	 * @param CConnection			$theConnection		Container.
	 * @param bitfield				$theModifiers		Commit options.
	 *
	 * @access protected
	 *
	 * @uses _PrecommitValidate()
	 * @uses _PrecommitRelated()
	 * @uses _PrecommitIdentify()
	 */
	protected function _Precommit( CConnection $theConnection,
											   $theModifiers = kFLAG_DEFAULT )
	{
		//
		// Validate object.
		//
		$this->_PrecommitValidate( $theConnection, $theModifiers );
		
		//
		// Handle embedded.
		//
		$this->_PrecommitRelated( $theConnection, $theModifiers );
		
		//
		// Identify object.
		//
		$this->_PrecommitIdentify( $theConnection, $theModifiers );
		
	} // _Precommit.

	 
	/*===================================================================================
	 *	_Postcommit																		*
	 *==================================================================================*/

	/**
	 * <h4>Prepare the object after committing</h4>
	 *
	 * This method will be called after the object gets committed, its main duty is to
	 * update the object after it has been committed.
	 *
	 * This method calls three other methods which perform the following functions:
	 *
	 * <ul>
	 *	<li>{@link _PostcommitRelated()}: This method's duty is to update related objects.
	 *	<li>{@link _PostcommitStatus()}: This method's duty is to set the object's status
	 *		after the persist operation.
	 *	<li>{@link _PostcommitCleanup()}: This method's duty is to cleanup the object after
	 *		the operation.
	 * </ul>
	 *
	 * These three methods are called in the above order, they take the same arguments as
	 * the current method and do not return a value: errors must raise exceptions.
	 *
	 * When deriving from this class you should overload the above methods and not this one.
	 * 
	 * This method accepts two parameters:
	 *
	 * <ul>
	 *	<li><tt>$theConnection</tt>: The container in which the object is to be committed,
	 *		a server or a database if the {@link DefaultDatabase} and
	 *		{@link DefaultContainer()} are able to resolve it into a container.
	 *	<li><tt>$theModifiers</tt>: The commit options provided as a bitfield in which the
	 *		following values are considered:
	 *	 <ul>
	 *		<li><tt>{@link kFLAG_PERSIST_INSERT}</tt>: Insert operation.
	 *		<li><tt>{@link kFLAG_PERSIST_UPDATE}</tt>: Update operation.
	 *		<li><tt>{@link kFLAG_PERSIST_REPLACE}</tt>: Replace operation.
	 *		<li><tt>{@link kFLAG_PERSIST_DELETE}</tt>: Delete operation.
	 *	 </ul>
	 * </ul>
	 *
	 * @param CConnection			$theConnection		Container.
	 * @param bitfield				$theModifiers		Commit options.
	 *
	 * @access protected
	 *
	 * @uses _PostcommitRelated()
	 * @uses _PostcommitStatus()
	 * @uses _PostcommitCleanup()
	 */
	protected function _Postcommit( CConnection $theConnection,
												$theModifiers = kFLAG_DEFAULT )
	{
		//
		// Update related objects.
		//
		$this->_PostcommitRelated( $theConnection, $theModifiers );
		
		//
		// Update object's status.
		//
		$this->_PostcommitStatus( $theConnection, $theModifiers );
		
		//
		// Cleanup after operation.
		//
		$this->_PostcommitCleanup( $theConnection, $theModifiers );
		
	} // _Postcommit.
		


/*=======================================================================================
 *																						*
 *							PROTECTED PRE-COMMIT INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_PrecommitValidate																*
	 *==================================================================================*/

	/**
	 * <h4>Validate the object before committing</h4>
	 *
	 * This method should check if the object is in the condition for being inserted,
	 * updated, replaced or deleted.
	 *
	 * This method is the first one called by {@link _Precommit()}, it should validate the
	 * object elements specific to the current class and let the inherited method handle the
	 * inherited ones.
	 *
	 * If the object does not meet the requirements for the desired operation, this method
	 * should raise an exception.
	 * 
	 * The method accepts two parameters:
	 *
	 * <ul>
	 *	<li><tt>$theConnection</tt>: The container in which the object is to be committed,
	 *		a server or a database if the {@link DefaultDatabase} and
	 *		{@link DefaultContainer()} are able to resolve it into a container. This
	 *		parameter is provided as a reference allowing this method to change it.
	 *	<li><tt>$theModifiers</tt>: The commit options provided as a bitfield in which the
	 *		following values are considered:
	 *	 <ul>
	 *		<li><tt>{@link kFLAG_PERSIST_INSERT}</tt>: Insert operation.
	 *		<li><tt>{@link kFLAG_PERSIST_UPDATE}</tt>: Update operation.
	 *		<li><tt>{@link kFLAG_PERSIST_REPLACE}</tt>: Replace operation.
	 *		<li><tt>{@link kFLAG_PERSIST_DELETE}</tt>: Delete operation.
	 *	 </ul>
	 *		This parameter is provided as a reference allowing this method to change it.
	 * </ul>
	 *
	 * In this class we check if the object has the {@link _IsInited()} status.
	 *
	 * @param reference			   &$theConnection		Server, database or container.
	 * @param reference			   &$theModifiers		Commit options.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 *
	 * @uses _IsInited()
	 *
	 * @see kFLAG_PERSIST_WRITE_MASK
	 */
	protected function _PrecommitValidate( &$theConnection, &$theModifiers )
	{
		//
		// Handle commits: insert, update, replace or delete.
		//
		if( $theModifiers & kFLAG_PERSIST_WRITE_MASK )
		{
			//
			// Check if object is inited.
			//
			if( ! $this->_IsInited() )
				throw new Exception
					( "The object cannot be committed: "
					 ."the object is not initialised",
					  kERROR_STATE );											// !@! ==>
		
		} // Insert, update, replace or delete.
		
	} // _PrecommitValidate.

	 
	/*===================================================================================
	 *	_PrecommitRelated																*
	 *==================================================================================*/

	/**
	 * <h4>Handle embedded or related objects before committing</h4>
	 *
	 * This method should handle embedded or related objects before the current object gets
	 * committed. In general it is here where you would commit embedded objects and convert
	 * them to references.
	 *
	 * This method is the second one called by {@link _Precommit()}, it should handle the
	 * object elements specific to the current class and let the inherited method handle the
	 * inherited ones.
	 *
	 * If any error occurs during the process, this method should raise an exception.
	 * 
	 * The method accepts two parameters:
	 *
	 * <ul>
	 *	<li><tt>$theConnection</tt>: The container in which the object is to be committed,
	 *		a server or a database if the {@link DefaultDatabase} and
	 *		{@link DefaultContainer()} are able to resolve it into a container. This
	 *		parameter is provided as a reference allowing this method to change it.
	 *	<li><tt>$theModifiers</tt>: The commit options provided as a bitfield in which the
	 *		following values are considered:
	 *	 <ul>
	 *		<li><tt>{@link kFLAG_PERSIST_INSERT}</tt>: Insert operation.
	 *		<li><tt>{@link kFLAG_PERSIST_UPDATE}</tt>: Update operation.
	 *		<li><tt>{@link kFLAG_PERSIST_REPLACE}</tt>: Replace operation.
	 *		<li><tt>{@link kFLAG_PERSIST_DELETE}</tt>: Delete operation.
	 *	 </ul>
	 *		This parameter is provided as a reference allowing this method to change it.
	 * </ul>
	 *
	 * In this class we do nothing.
	 *
	 * @param reference			   &$theConnection		Server, database or container.
	 * @param reference			   &$theModifiers		Commit options.
	 *
	 * @access protected
	 */
	protected function _PrecommitRelated( &$theConnection, &$theModifiers )				   {}

	 
	/*===================================================================================
	 *	_PrecommitIdentify																*
	 *==================================================================================*/

	/**
	 * <h4>Determine the identifiers before committing</h4>
	 *
	 * This method should set the object identifiers before the current object gets
	 * committed. In general it is here where you set sequence numbers or generate unique
	 * identifiers.
	 *
	 * This method is the last one called by {@link _Precommit()}, in general, it should not
	 * fail if the first method called by {@link _Precommit()} has made the necessary
	 * validations. The reason this method is the last in the chain is because often the
	 * object identifier may depend on related or embedded objects which have been committed
	 * in the previous method.
	 *
	 * If any error occurs during the process, this method should still raise an exception.
	 * 
	 * The method accepts two parameters:
	 *
	 * <ul>
	 *	<li><tt>$theConnection</tt>: The container in which the object is to be committed,
	 *		a server or a database if the {@link DefaultDatabase} and
	 *		{@link DefaultContainer()} are able to resolve it into a container. This
	 *		parameter is provided as a reference allowing this method to change it.
	 *	<li><tt>$theModifiers</tt>: The commit options provided as a bitfield in which the
	 *		following values are considered:
	 *	 <ul>
	 *		<li><tt>{@link kFLAG_PERSIST_INSERT}</tt>: Insert operation.
	 *		<li><tt>{@link kFLAG_PERSIST_UPDATE}</tt>: Update operation.
	 *		<li><tt>{@link kFLAG_PERSIST_REPLACE}</tt>: Replace operation.
	 *		<li><tt>{@link kFLAG_PERSIST_DELETE}</tt>: Delete operation.
	 *	 </ul>
	 *		This parameter is provided as a reference allowing this method to change it.
	 * </ul>
	 *
	 * In this class we do nothing.
	 *
	 * @param reference			   &$theConnection		Server, database or container.
	 * @param reference			   &$theModifiers		Commit options.
	 *
	 * @access protected
	 */
	protected function _PrecommitIdentify( &$theConnection, &$theModifiers )			   {}
		


/*=======================================================================================
 *																						*
 *							PROTECTED POST-COMMIT INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_PostcommitRelated																*
	 *==================================================================================*/

	/**
	 * <h4>Update related objects after committing</h4>
	 *
	 * This method should update eventual related objects after the current object has been
	 * committed. This method is the first one called by {@link _Postcommit()} after the
	 * persist operation and the object has not yet updated its status according to the
	 * operation, so this is a good place to make changes before the status gets reset.
	 * 
	 * The method accepts two parameters:
	 *
	 * <ul>
	 *	<li><tt>$theConnection</tt>: The container in which the object is to be committed,
	 *		a server or a database if the {@link DefaultDatabase} and
	 *		{@link DefaultContainer()} are able to resolve it into a container. This
	 *		parameter is provided as a reference allowing this method to change it.
	 *	<li><tt>$theModifiers</tt>: The commit options provided as a bitfield in which the
	 *		following values are considered:
	 *	 <ul>
	 *		<li><tt>{@link kFLAG_PERSIST_INSERT}</tt>: Insert operation.
	 *		<li><tt>{@link kFLAG_PERSIST_UPDATE}</tt>: Update operation.
	 *		<li><tt>{@link kFLAG_PERSIST_REPLACE}</tt>: Replace operation.
	 *		<li><tt>{@link kFLAG_PERSIST_DELETE}</tt>: Delete operation.
	 *	 </ul>
	 *		This parameter is provided as a reference allowing this method to change it.
	 * </ul>
	 *
	 * In this class we do nothing.
	 *
	 * @param reference			   &$theConnection		Server, database or container.
	 * @param reference			   &$theModifiers		Commit options.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 *
	 * @uses _IsInited()
	 *
	 * @see kFLAG_PERSIST_WRITE_MASK
	 */
	protected function _PostcommitRelated( &$theConnection, &$theModifiers )			   {}

	 
	/*===================================================================================
	 *	_PostcommitStatus																*
	 *==================================================================================*/

	/**
	 * <h4>Update the object's status after committing</h4>
	 *
	 * This method should set the object status according to the operation performed, it is
	 * the second method called by {@link _Postcommit()} after the persist operation and is
	 * called before the {@link _PostcommitCleanup()} method that should cleanup after the
	 * operation.
	 *
	 * In general this method should set or reset the status reflecting the persistent state
	 * of the object.
	 * 
	 * The method accepts two parameters:
	 *
	 * <ul>
	 *	<li><tt>$theConnection</tt>: The container in which the object is to be committed,
	 *		a server or a database if the {@link DefaultDatabase} and
	 *		{@link DefaultContainer()} are able to resolve it into a container. This
	 *		parameter is provided as a reference allowing this method to change it.
	 *	<li><tt>$theModifiers</tt>: The commit options provided as a bitfield in which the
	 *		following values are considered:
	 *	 <ul>
	 *		<li><tt>{@link kFLAG_PERSIST_INSERT}</tt>: Insert operation.
	 *		<li><tt>{@link kFLAG_PERSIST_UPDATE}</tt>: Update operation.
	 *		<li><tt>{@link kFLAG_PERSIST_REPLACE}</tt>: Replace operation.
	 *		<li><tt>{@link kFLAG_PERSIST_DELETE}</tt>: Delete operation.
	 *	 </ul>
	 *		This parameter is provided as a reference allowing this method to change it.
	 * </ul>
	 *
	 * In this class we reset the {@link _IsDirty()} status after committing or loading the
	 * object, set the {@link _IsCommitted()} status after committing and resetting it after
	 * deleting.
	 *
	 * @param reference			   &$theConnection		Server, database or container.
	 * @param reference			   &$theModifiers		Commit options.
	 *
	 * @access protected
	 */
	protected function _PostcommitStatus( &$theConnection, &$theModifiers )
	{
		//
		// Handle insert, update and replace, or load.
		//
		if( ($theModifiers & kFLAG_PERSIST_COMMIT_MASK)	// Commit,
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
		
	} // _PostcommitStatus.

	 
	/*===================================================================================
	 *	_PostcommitCleanup																*
	 *==================================================================================*/

	/**
	 * <h4>Cleanup the object after committing</h4>
	 *
	 * This method should clean and normalise the object after the operation, it is the last
	 * method called by {@link _Postcommit()} and the last chance to have a hook into the
	 * persist workflow.
	 *
	 * Be aware that {@link _PostcommitStatus()} has been called before, so if you intend to
	 * perform operations that may change the object's status, this is not the place.
	 * 
	 * The method accepts two parameters:
	 *
	 * <ul>
	 *	<li><tt>$theConnection</tt>: The container in which the object is to be committed,
	 *		a server or a database if the {@link DefaultDatabase} and
	 *		{@link DefaultContainer()} are able to resolve it into a container. This
	 *		parameter is provided as a reference allowing this method to change it.
	 *	<li><tt>$theModifiers</tt>: The commit options provided as a bitfield in which the
	 *		following values are considered:
	 *	 <ul>
	 *		<li><tt>{@link kFLAG_PERSIST_INSERT}</tt>: Insert operation.
	 *		<li><tt>{@link kFLAG_PERSIST_UPDATE}</tt>: Update operation.
	 *		<li><tt>{@link kFLAG_PERSIST_REPLACE}</tt>: Replace operation.
	 *		<li><tt>{@link kFLAG_PERSIST_DELETE}</tt>: Delete operation.
	 *	 </ul>
	 *		This parameter is provided as a reference allowing this method to change it.
	 * </ul>
	 *
	 * In this class we reset the {@link _IsDirty()} status after committing or loading the
	 * object, set the {@link _IsCommitted()} status after committing and resetting it after
	 * deleting.
	 *
	 * In this class we do nothing.
	 *
	 * @param reference			   &$theConnection		Server, database or container.
	 * @param reference			   &$theModifiers		Commit options.
	 *
	 * @access protected
	 */
	protected function _PostcommitCleanup( &$theConnection, &$theModifiers )			   {}
		


/*=======================================================================================
 *																						*
 *								PROTECTED STATUS INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_Ready																			*
	 *==================================================================================*/

	/**
	 * <h4>Determine if the object is ready</h4>
	 *
	 * This method will return a boolean indicating whether all the required the elements
	 * managed by the current class are present, this value should then be set by the caller
	 * into the {@link _IsInited()} status.
	 *
	 * This method should be implemented in all inheritance levels in which the
	 * @link _IsInited()} status is affected.
	 *
	 * In this class we assume the object is {@link _IsInited()}, it is up to derived
	 * classes to prove the contrary.
	 *
	 * @access protected
	 * @return boolean				<tt>TRUE</tt> means {@link _IsInited( <tt>TRUE</tt> ).
	 */
	protected function _Ready()											{	return TRUE;	}

	 

} // class CPersistentDocument.


?>
