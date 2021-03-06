<?php

/**
 * <i>CDataTypeRegex</i> class definition.
 *
 * This file contains the class definition of <b>CDataTypeRegex</b> which implements a
 * regular expression object.
 *
 *	@package	MyWrapper
 *	@subpackage	Framework
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 21/03/2012
 */

/*=======================================================================================
 *																						*
 *									CDataTypeRegex.php									*
 *																						*
 *======================================================================================*/

/**
 * Ancestor.
 *
 * This include file contains the parent class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CDataType.php" );

/**
 * <h4>Regular expression</h4>
 *
 * This class is a wrapper around a regular expression string, its function is only to
 * indicate that the string is to be considered a regular expression pattern; its structure
 * is as follows:
 *
 * <ul>
 *	<li><i>{@link kTAG_CUSTOM_TYPE}</i>: The constant {@link kTYPE_REGEX_STRING}.
 *	<li><i>{@link kTAG_CUSTOM_DATA}</i>: The regular expression string.
 * </ul>
 *
 *	@package	MyWrapper
 *	@subpackage	Framework
 */
class CDataTypeRegex extends CDataType
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
	 * Instantiate class.
	 *
	 * In this class we instantiate such an object from a MongoRegex object or from a
	 * string.
	 *
	 * @param mixed					$theData			Custom data.
	 *
	 * @access public
	 *
	 * @throws Exception
	 */
	public function __construct( $theData = NULL )
	{
		//
		// Call parent constructor.
		//
		parent::__construct( $theData );
		
		//
		// Load object.
		//
		$this->offsetSet( kTAG_CUSTOM_TYPE, kTYPE_REGEX_STRING );
		$this->offsetSet( kTAG_CUSTOM_DATA, (string) $theData );
	
	} // Constructor.

		

/*=======================================================================================
 *																						*
 *									PUBLIC DATA INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	value																			*
	 *==================================================================================*/

	/**
	 * Return data value.
	 *
	 * In this class we return the MongoRegex object.
	 *
	 * @access public
	 * @return mixed
	 *
	 * @throws Exception
	 */
	public function value()				{	return $this->offsetGet( kTAG_CUSTOM_DATA );	}

	 

} // class CDataTypeRegex.


?>
