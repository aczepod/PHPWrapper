<?php

/**
 * <h3>Attribute utilities</h3>
 *
 * This file contains common functions used by classes in this library to implement
 * interfaces to object properties and offsets.
 *
 *	@package	MyWrapper
 *	@subpackage	Functions
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 03/09/2012
 */

/*=======================================================================================
 *																						*
 *									accessors.php										*
 *																						*
 *======================================================================================*/

/**
 * Errors.
 *
 * This include file contains all error code definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_DEFINE."/Errors.inc.php" );



/*=======================================================================================
 *																						*
 *								MEMBER ACCESSOR INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	ManageProperty																	*
	 *==================================================================================*/

	/**
	 * <h4>Manage a property</h4>
	 *
	 * This library implements a standard interface for managing object properties using
	 * accessor methods, this method implements this interface:
	 *
	 * <ul>
	 *	<li><tt>&$theMember</tt>: Reference to the property being managed.
	 *	<li><tt>$theValue</tt>: The property value or operation:
	 *	 <ul>
	 *		<li><tt>NULL</tt>: Return the current property value.
	 *		<li><tt>FALSE</tt>: Reset the property to <tt>NULL</tt>, the default value.
	 *		<li><i>other</i>: Any other type represents the new value of the property.
	 *	 </ul>
	 *	<li><tt>$getOld</tt>: Determines what the method will return:
	 *	 <ul>
	 *		<li><tt>TRUE</tt>: Return the value of the property <i>before</i> it was
	 *			eventually modified.
	 *		<li><tt>FALSE</tt>: Return the value of the property <i>after</i> it was
	 *			eventually modified.
	 *	 </ul>
	 * </ul>
	 *
	 * @param string			   &$theMember			Offset.
	 * @param mixed					$theValue			Value or operation.
	 * @param boolean				$getOld				<tt>TRUE</tt> get old value.
	 *
	 * @return mixed				Old or new property value.
	 */
	function ManageProperty( &$theMember, $theValue = NULL, $getOld = FALSE )
	{
		//
		// Return current value.
		//
		if( $theValue === NULL )
			return $theMember;														// ==>

		//
		// Save current value.
		//
		$save = $theMember;
		
		//
		// Delete offset.
		//
		if( $theValue === FALSE )
			$theMember = NULL;
		
		//
		// Set offset.
		//
		else
			$theMember = $theValue;
		
		return ( $getOld ) ? $save													// ==>
						   : $theMember;											// ==>
	
	} // ManageProperty.

	 
	/*===================================================================================
	 *	ManageBitField																	*
	 *==================================================================================*/

	/**
	 * <h4>Manage a bit-field property</h4>
	 *
	 * This method can be used to manage a bitfield property, it accepts the following
	 * parameters:
	 *
	 * <ul>
	 *	<li><tt>&$theField</tt>: Reference to the bit-field property.
	 *	<li><tt>$theMask</tt>: Bit-field mask.
	 *	<li><tt>$theState</tt>: State or operator:
	 *	 <ul>
	 *		<li><tt>NULL</tt>: Return the masked bitfield.
	 *		<li><tt>FALSE</tt>: Turn <i>off</i> the masked bits.
	 *		<li><i>other</i>: Turn <i>on</i> the masked bits.
	 *	 </ul>
	 * </ul>
	 *
	 * In all cases the method will return the status <i>after</i> it was eventually
	 * modified.
	 *
	 * @param reference			   &$theField			Bit-field reference.
	 * @param bitfield				$theMask			Bit-field mask.
	 * @param mixed					$theState			Value or operator.
	 *
	 * @return bitfield				Current masked status.
	 *
	 * @see kFLAG_DEFAULT_MASK
	 */
	function ManageBitField( &$theField, $theMask, $theState = NULL )
	{
		//
		// Normalise mask (mask sign bit).
		//
		$theMask &= kFLAG_DEFAULT_MASK;
		
		//
		// Modify status.
		//
		if( $theState !== NULL )
		{
			//
			// Set mask.
			//
			if( (boolean) $theState )
				$theField |= $theMask;
			
			//
			// Reset mask.
			//
			else
				$theField &= (~ $theMask);
		}
		
		return $theField & $theMask;												// ==>
	
	} // ManageBitField



/*=======================================================================================
 *																						*
 *								OFFSET ACCESSOR INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	ManageOffset																	*
	 *==================================================================================*/

	/**
	 * Manage a scalar offset.
	 *
	 * This method can be used to manage a scalar offset, its options involve setting,
	 * retrieving and deleting an offset of the provided array or ArrayObject.
	 *
	 * The method accepts the following parameters:
	 *
	 * <ul>
	 *	<li><tt>&$theReference</tt>: Reference to the document, it may either refer to an
	 *		array or an ArrayObject, any other type will trigger an exception.
	 *	<li><tt>$theOffset</tt>: The offset to the attribute contained in the previous
	 *		parameter that is to be managed.
	 *	<li><tt>$theValue</tt>: The value or operation:
	 *	 <ul>
	 *		<li><tt>NULL</tt>: Return the offset's current value.
	 *		<li><tt>FALSE</tt>: Delete the offset.
	 *		<li><i>other</i>: Any other type represents the offset's new value.
	 *	 </ul>
	 *	<li><tt>$getOld</tt>: Determines what the method will return:
	 *	 <ul>
	 *		<li><tt>TRUE</tt>: Return the value of the offset <i>before</i> it was eventually
	 *			modified.
	 *		<li><tt>FALSE</tt>: Return the value of the offset <i>after</i> it was eventually
	 *			modified.
	 *	 </ul>
	 * </ul>
	 *
	 * @param reference			   &$theReference		Array or ArrayObject reference.
	 * @param string				$theOffset			Offset to be managed.
	 * @param mixed					$theValue			New value or operation.
	 * @param boolean				$getOld				TRUE get old value.
	 *
	 * @static
	 * @return mixed
	 *
	 * @throws {@link CException CException}
	 */
	function ManageOffset( &$theReference, $theOffset, $theValue = NULL,
													   $getOld = FALSE )
	{
		//
		// Check reference.
		//
		if( is_array( $theReference )
		 || ($theReference instanceof ArrayObject) )
		{
			//
			// Normalise offset.
			//
			$theOffset = (string) $theOffset;
			
			//
			// Save current list.
			//
			$save = ( isset( $theReference[ $theOffset ] ) )
				  ? $theReference[ $theOffset ]
				  : NULL;
			
			//
			// Return current value.
			//
			if( $theValue === NULL )
				return $save;														// ==>
			
			//
			// Delete offset.
			//
			if( $theValue === FALSE )
			{
				if( $save !== NULL )
				{
					if( is_array( $theReference ) )
						unset( $theReference[ $theOffset ] );
					else
						$theReference->offsetUnset( $theOffset );
				}
			}
			
			//
			// Set offset.
			//
			else
				$theReference[ $theOffset ] = $theValue;
			
			if( $getOld )
				return $save;														// ==>
			
			return ( $theValue === FALSE )
				 ? NULL																// ==>
				 : $theValue;														// ==>
		
		} // Supported reference.

		throw new Exception
				( "Unsupported document reference",
				  kERROR_UNSUPPORTED );											// !@! ==>
	
	} // ManageOffset.


?>
