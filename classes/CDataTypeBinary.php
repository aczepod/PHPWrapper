<?php

/**
 * <i>CDataTypeBinary</i> class definition.
 *
 * This file contains the class definition of <b>CDataTypeBinary</b> which wraps this class
 * around a binary string.
 *
 *	@package	MyWrapper
 *	@subpackage	Framework
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 21/03/2012
 */

/*=======================================================================================
 *																						*
 *									CDataTypeBinary.php									*
 *																						*
 *======================================================================================*/

/**
 * Ancestor.
 *
 * This include file contains the parent class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CDataType.php" );

/**
 * <h4>Binary string</h4>
 *
 * This class represents a binary string, the object records the following information in
 * its offsets:
 *
 * <ul>
 *	<li><i>{@link kTAG_CUSTOM_TYPE}</i>: The constant {@link kTYPE_BINARY_STRING}.
 *	<li><i>{@link kTAG_CUSTOM_DATA}</i>: The following structure:
 *	 <ul>
 *		<li><i>{@link kTYPE_BINARY_STRING}</i>: The binary string in hexadecimal.
 *		<li><i>{@link kTYPE_BINARY_TYPE}</i>: The binary string type (integer):
 *		 <ul>
 *			<li><i>1</i>: Function.
 *			<li><i>2</i>: Byte array (use as default).
 *			<li><i>3</i>: UUID.
 *			<li><i>5</i>: MD5.
 *			<li><i>128</i>: Custom.
 *		 </ul>
 *	 </ul>
 * </ul>
 *
 *	@package	MyWrapper
 *	@subpackage	Framework
 */
class CDataTypeBinary extends CDataType
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
	 * We overload the parent constructor to set the default {@link kTYPE_BINARY_STRING} and to set
	 * the binary string into the {@link kTAG_CUSTOM_DATA} offset.
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
		$this->offsetSet( kTAG_CUSTOM_TYPE, kTYPE_BINARY_STRING );
		$this->offsetSet( kTAG_CUSTOM_DATA, bin2hex( (string) $theData ) );
	
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
	 * This method will return the actual binary string.
	 *
	 * @access public
	 * @return float
	 *
	 * @throws Exception
	 */
	public function value()
	{
		return ( function_exists( 'hex2bin' ) )
			 ? hex2bin( $this->offsetGet( kTAG_CUSTOM_DATA ) )								// ==>
			 : pack( 'H*', $this->offsetGet( kTAG_CUSTOM_DATA ) );							// ==>
	
	} // value.

		

/*=======================================================================================
 *																						*
 *									STATIC INTERFACE									*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	FromHex																			*
	 *==================================================================================*/

	/**
	 * Create from hex.
	 *
	 * This method will return an object created from the provided hexadecimal value.
	 *
	 * @param string				$theHex				Binary hexadecimal value.
	 *
	 * @static
	 * @return CDataTypeBinary
	 */
	static function FromHex( $theHex )
	{
		//
		// Convert to binary.
		//
		$data = ( function_exists( 'hex2bin' ) )
			  ? hex2bin( $theHex )
			  : pack( 'H*', $theHex );
		
		return new self( $data );													// ==>
	
	} // FromHex.

	 

} // class CDataTypeBinary.


?>
