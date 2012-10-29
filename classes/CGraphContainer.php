<?php

/**
 * <i>CGraphContainer</i> class definition.
 *
 * This file contains the class definition of <b>CGraphContainer</b> which implements a
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
 *									CGraphContainer.php									*
 *																						*
 *======================================================================================*/

/**
 * Local definitions.
 *
 * This include file contains common offset definitions.
 */
require_once( "CGraphContainer.inc.php" );

/**
 * Ancestor.
 *
 * This includes the ancestor class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CConnection.php" );

/**
 * <h3>Connection object ancestor</h3>
 *
 * This <i>abstract</i> class is the ancestor of all connection and container classes in
 * this library, it implements the the common interface shared by derived concrete
 * instances.
 *
 * A connection object holds a reference to a native connection which can be that to a
 * server, database or container. The class server as a proxy to native implementations,
 * offering a single interface to client objects which will use native derived concrete
 * classes.
 *
 * The object is instantiated by providing the native connection which is stored in a data
 * member of the object, the array part of the object can be used to store specific
 * attributes of the native connection.
 *
 * All objects derived from this class must implement the {@link __toString()} method that
 * will return the specific name of the current connection.
 *
 * The {@link Connection()} accessor method can be used to manage the native connection and
 * the inherited offset management methods can be used to manage the connection attributes.
 *
 * The object has its {@link _IsInited()} status set when the native connection has been
 * set in the object.
 *
 * The class acts as an ancestor of other specialised abstract classes which declare the
 * common interfaces of specific connection types.
 *
 * The class declares two constants: {@link kOFFSET_NAME} and {@link kOFFSET_PARENT}. The
 * first one corresponds to the internal name of the object, which could also be the public
 * one. The second offset corresponds to the parent connection object: if the current
 * object was instantiated by a parent class instance, such as a database by a server, or a
 * container by a database, this offset will contain the creator object. This can be useful
 * if we need, for instance, the database, given the container.
 *
 *	@package	MyWrapper
 *	@subpackage	Framework
 */
class CGraphContainer extends CConnection
{
	/**
	 * Persistent data store.
	 *
	 * This data member holds the native graph client connection.
	 *
	 * @var mixed
	 */
	 protected static $mGraphClient = NULL;

		

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
	 * You instantiate the class with a native connection, the method expects a parameter
	 * that will be stored in the {@link $mConnection} data member and another parameter
	 * that can be used to pass instantiation options.
	 *
	 * Derived classes should overload this method if a default value is possible; to check
	 * for specific connection types they should rather overload the member accessor method.
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
		// Handle native container.
		//
		if( $theConnection !== NULL )
			$this->Connection( $theConnection );
		
	} // Constructor.

	 
	/*===================================================================================
	 *	__toString																		*
	 *==================================================================================*/

	/**
	 * <h4>Return connection name</h4>
	 *
	 * This method should return the current connection's name.
	 *
	 * All derived concrete classes should implement this method, all connections must be
	 * able to return a name.
	 *
	 * @access public
	 * @return string				The connection name.
	 */
	abstract public function __toString();

		

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
	 * This method can be used to manage the connection, it accepts a parameter which
	 * represents either the container or the requested operation, depending on its value:
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
	 * In derived classes you should overload this method to check if the provided
	 * connection is of the correct type, in this class we accept anything.
	 *
	 * This class is considered initialised ({@link _IsInited()}) when this member has been
	 * set.
	 *
	 * @param mixed					$theValue			Native connection or operation.
	 * @param boolean				$getOld				<tt>TRUE</tt> get old value.
	 *
	 * @access public
	 * @return mixed				<i>New</i> or <i>old</i> native connection.
	 *
	 * @uses _isInited()
	 * @uses ManageProperty()
	 */
	public function Connection( $theValue = NULL, $getOld = FALSE )
	{
		//
		// Manage connection.
		//
		$save = ManageProperty( $this->mConnection, $theValue, $getOld );
		
		//
		// Update inited status.
		//
		$this->_isInited( $this->_Ready() );
		
		return $save;																// ==>

	} // Connection.

		

/*=======================================================================================
 *																						*
 *								PROTECTED MEMBER INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	&_Connection																	*
	 *==================================================================================*/

	/**
	 * <h4>Get connection reference</h4>
	 *
	 * This method can be used to retrieve a reference to the native connection member, this
	 * can be useful when the native {@link Connection()} is not an object passed by
	 * reference.
	 *
	 * @access protected
	 * @return mixed
	 */
	protected function &_Connection()						{	return $this->mConnection;	}
		


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
	 * In this class we tie the {@link _IsInited()} status to the presence or absence of the
	 * connection.
	 *
	 * @access protected
	 * @return boolean				<tt>TRUE</tt> means {@link _IsInited( <tt>TRUE</tt> ).
	 *
	 * @uses _Ready()
	 */
	protected function _Ready()
	{
		//
		// Check parent.
		//
		if( parent::_Ready() )
			return ( $this->mConnection !== NULL );									// ==>
		
		return FALSE;																// ==>
	
	} // _Ready.

	 

} // class CGraphContainer.


?>
