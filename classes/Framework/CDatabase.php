<?php namespace MyWrapper\Framework;

/**
 * <i>CDatabase</i> class definition.
 *
 * This file contains the class definition of <b>CDatabase</b> which represents the
 * ancestor of all database objects in this library.
 *
 *	@package	MyWrapper
 *	@subpackage	Framework
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 03/09/2012
 */

/*=======================================================================================
 *																						*
 *									CDatabase.php										*
 *																						*
 *======================================================================================*/

/**
 * Ancestor.
 *
 * This includes the ancestor class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/Framework/CConnection.php" );
use \MyWrapper\Framework\CConnection as CConnection;

/**
 * <h3>Database object ancestor</h3>
 *
 * This <i>abstract</i> class is the ancestor of all database classes in this library, it
 * implements the interface and workflow that all concrete derived classes should implement.
 *
 * A database object holds a data member that represents a native connection to a database
 * server, database objects have the ability to generate other connection derived objects
 * that have specific functionality, such as containers.
 *
 * The object is instantiated by providing the native database connection which is stored in
 * a data member of the object, the array part of the object can be used to store specific
 * attributes of the native database connection.
 *
 * The class also features an offset, {@link kOFFSET_PARENT}, that can be used to store the
 * parent object, in this case the server object. This member gets set when the object is
 * instantiated by a server object.
 *
 * The abstract class must be overloaded by concrete classes that implement a native
 * database object.
 *
 *	@package	MyWrapper
 *	@subpackage	Framework
 */
abstract class CDatabase extends CConnection
{
		

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
	 * This method can be used to delete or erase a database, it is up to derived concrete
	 * instances to implement it.
	 *
	 * The method takes no parameters.
	 *
	 * @access public
	 */
	abstract public function Drop();

	 
	/*===================================================================================
	 *	Container																		*
	 *==================================================================================*/

	/**
	 * <h4>Generate a container object</h4>
	 *
	 * This method can be used to return a container object belonging to the current
	 * database.
	 *
	 * The parameter will be used by concrete instances to select which container to return,
	 * the goal of this class is only to declare the public interface, which must be
	 * implemented by specialised derived classes.
	 *
	 * @param mixed					$theContainer		Container selector.
	 *
	 * @access public
	 * @return mixed				The container object.
	 */
	abstract public function Container( $theContainer = NULL );

	 

} // class CDatabase.


?>
