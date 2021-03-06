<?php

/**
 * <i>CDataTypeMongoCode</i> class definition.
 *
 * This file contains the class definition of <b>CDataTypeMongoCode</b> which wraps this
 * class around a MongoCode object.
 *
 *	@package	MyWrapper
 *	@subpackage	Framework
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 21/03/2012
 */

/*=======================================================================================
 *																						*
 *								CDataTypeMongoCode.php									*
 *																						*
 *======================================================================================*/

/**
 * Ancestor.
 *
 * This include file contains the parent class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CDataType.php" );

/**
 * <h4><i>MongoCode</i> type wrapper</h4>
 *
 * This class represents a MongoCode object, it is structured as follows:
 *
 * <ul>
 *	<li><i>{@link kTAG_CUSTOM_TYPE}</i>: The constant {@link kTYPE_MongoCode}.
 *	<li><i>{@link kTAG_CUSTOM_DATA}</i>: The following structure:
 *	 <ul>
 *		<li><i>{@link kOBJ_TYPE_CODE_SRC}</i>: The javascript source.
 *		<li><i>{@link kOBJ_TYPE_CODE_SCOPE}</i>: The key/values list.
 *	 </ul>
 * </ul>
 *
 *	@package	MyWrapper
 *	@subpackage	Framework
 */
class CDataTypeMongoCode extends CDataType
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
	 * In this class we can only instantiate such an object from a MongoCode object.
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
		// Check data.
		//
		if( ! $theData instanceof MongoCode )
			throw new CException( "Invalid data",
								  kERROR_PARAMETER,
								  kSTATUS_ERROR,
								  array( 'Data' => $theData ) );				// !@! ==>
		
		//
		// Load object.
		//
		$this->offsetSet( kTAG_CUSTOM_TYPE, kTYPE_MongoCode );
		$this->offsetSet( kTAG_CUSTOM_DATA,
						  array( kOBJ_TYPE_CODE_SRC => $theData->code,
								 kOBJ_TYPE_CODE_SCOPE => $theData->scope ) );
	
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
	 * In this class we return the MongoCode object.
	 *
	 * @access public
	 * @return mixed
	 *
	 * @throws Exception
	 */
	public function value()
	{
		//
		// Get data.
		//
		$data = $this->offsetGet( kTAG_CUSTOM_DATA );
		
		return new MongoCode( $data[ kOBJ_TYPE_CODE_SRC ],
							  $data[ kOBJ_TYPE_CODE_SCOPE ] );						// ==>
	
	} // value.

	 

} // class CDataTypeMongoCode.


?>
