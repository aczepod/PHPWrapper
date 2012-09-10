<?php namespace MyWrapper\Framework;

/**
 * <i>CServer</i> class definition.
 *
 * This file contains the class definition of <b>CServer</b> which represents the
 * ancestor of all server objects in this library.
 *
 *	@package	MyWrapper
 *	@subpackage	Framework
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 03/09/2012
 */

/*=======================================================================================
 *																						*
 *										CServer.php										*
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
 * <h3>Server object ancestor</h3>
 *
 * This <i>abstract</i> class is the ancestor of all server classes in this library, it
 * implements the interface and workflow that all concrete derived classes should implement.
 *
 * A server object holds a data member that represents a native connection to a server
 * environment, server objects have the ability to generate other connection derived objects
 * that have specific functionality, such as databases.
 *
 * The object is instantiated by providing the native server connection which is stored in a
 * data member of the object, the array part of the object can be used to store specific
 * attributes of the native server connection.
 *
 * The abstract class must be overloaded by concrete classes that implement a native server
 * object.
 *
 *	@package	MyWrapper
 *	@subpackage	Framework
 */
abstract class CServer extends CConnection
{
		

/*=======================================================================================
 *																						*
 *								PUBLIC CONNECTION INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	Database																		*
	 *==================================================================================*/

	/**
	 * <h4>Generate a database object</h4>
	 *
	 * This method can be used to return a database object belonging to the current server.
	 *
	 * The parameter will be used by concrete instances to select which database to return,
	 * the goal of this class is only to declare the public interface, which must be
	 * implemented by specialised derived classes.
	 *
	 * @param mixed					$theDatabase		Database selector.
	 *
	 * @access public
	 * @return mixed				The database object.
	 */
	abstract public function Database( $theDatabase = NULL );

	 

} // class CServer.


?>
