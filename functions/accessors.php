<?php

/**
 * <h4>Attribute utilities</h4>
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
	 * <h4>Manage a scalar offset</h4>
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
	 * @throws Exception
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

	 
	/*===================================================================================
	 *	ManageTypedOffset																*
	 *==================================================================================*/

	/**
	 * <h4>Manage a typed offset</h4>
	 *
	 * Typed offsets are constituted by a list of structures, each containing two elements:
	 * a type code and a the string data.
	 *
	 * The type code is an optional field that represents the key of the list element, no
	 * two list elements may share the same type and no two elements may omit the type. The
	 * data element contains the data qualified by the type and the element is required.
	 *
	 * The method accepts the following parameters:
	 *
	 * <ul>
	 *	<li><tt>&$theReference</tt>: Reference to the main container, it may either refer to
	 *		an array or an ArrayObject, any other type will trigger an exception.
	 *	<li><tt>$theOffset</tt>: The offset to the attribute containing the list of
	 *		elements.
	 *	<li><tt>$theTypeOffset</tt>: The offset to the type within the element.
	 *	<li><tt>$theDataOffset</tt>: The offset to the data within the element.
	 *	<li><tt>$theTypeValue</tt>: The value of the element's type to match, it represents
	 *		the key to the element; we assume the value to be a string. A <tt>NULL</tt>
	 *		value is used to select the element missing the <tt>$theTypeOffset</tt> offset.
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
	 * The method expects each element to be a structure containing at least an element
	 * indexed by the <tt>$theDataOffset</tt> offset, if that is not the case, the method
	 * will raise an exception.
	 *
	 * @param reference			   &$theReference		Array or ArrayObject reference.
	 * @param string				$theOffset			Offset to be managed.
	 * @param string				$theTypeOffset		Offset of type item.
	 * @param string				$theDataOffset		Offset of data item.
	 * @param string				$theTypeValue		Type value.
	 * @param mixed					$theValue			New value or operation.
	 * @param boolean				$getOld				TRUE get old value.
	 *
	 * @static
	 * @return mixed
	 *
	 * @throws Exception
	 */
	function ManageTypedOffset( &$theReference,
								 $theOffset, $theTypeOffset, $theDataOffset,
								 $theTypeValue = NULL, $theValue = NULL,
								 $getOld = FALSE )
	{
		//
		// Check list container.
		//
		if( is_array( $theReference )
		 || ($theReference instanceof ArrayObject) )
		{
			//
			// Init local storage.
			//
			$offset = $save = $idx = NULL;
			
			//
			// Handle existing offset.
			//
			if( ( is_array( $theReference )
			   && array_key_exists( $theOffset, $theReference ) )
			 || ( ($theReference instanceof ArrayObject)
			   && $theReference->offsetExists( $theOffset ) ) )
			{
				//
				// Check offset type.
				//
				if( is_array( $theReference[ $theOffset ] ) )
				{
					//
					// Reference offset.
					//
					$offset = $theReference[ $theOffset ];
					
					//
					// Locate item.
					//
					for( $i = 0; $i < count( $offset ); $i++ )
					{
						//
						// Match type.
						//
						if( ( ($theTypeValue !== NULL)
						   && array_key_exists( $theTypeOffset, $offset[ $i ] )
						   && ($offset[ $i ][ $theTypeOffset ] == $theTypeValue) )
						 || ( ($theTypeValue === NULL)
						   && (! array_key_exists( $theTypeOffset, $offset[ $i ] )) ) )
						{
							//
							// Save element index.
							//
							$idx = $i;
							
							//
							// Save element value.
							//
							$save = ( array_key_exists( $theDataOffset, $offset[ $i ] ) )
								  ? $offset[ $i ][ $theDataOffset ]
								  : NULL;
							
						} // Matched type offset.
					
					} // Iterating offset.
				
				} // Valid offset type.
				
				else
					throw new Exception
							( "The offset must be an array",
							  kERROR_UNSUPPORTED );								// !@! ==>
			
			} // Main offset exists.
			
			//
			// Retrieve value.
			//
			if( $theValue === NULL )
				return $save;														// ==>
			
			//
			// Delete element.
			//
			if( $theValue === FALSE )
			{
				//
				// Handle matched element.
				//
				if( $idx !== NULL )
				{
					//
					// Delete element.
					//
					unset( $offset[ $idx ] );
					
					//
					// Update offset.
					//
					if( count( $offset ) )
						$theReference[ $theOffset ] = array_values( $offset );
					
					//
					// Delete offset.
					//
					else
					{
						if( is_array( $theReference ) )
							unset( $theReference[ $theOffset ] );
						else
							$theReference->offsetUnset( $theOffset );
					
					} // Empty list.
					
					if( $getOld )
						return $save;												// ==>
				
				} // Matched.
				
				return NULL;														// ==>
			
			} // Delete.
			
			//
			// Initialise offset.
			//
			if( ! is_array( $offset ) )
				$offset = Array();
			
			//
			// Create element.
			//
			$element = array( $theDataOffset => $theValue );
			if( $theTypeValue !== NULL )
				$element[ $theTypeOffset ] = $theTypeValue;
			
			//
			// Replace.
			//
			if( $idx !== NULL )
				$offset[ $idx ] = $element;
			
			//
			// Insert.
			//
			else
				$offset[] = $element;
			
			//
			// Update.
			//
			$theReference[ $theOffset ] = $offset;
			
			if( $getOld )
				return $save;														// ==>
			
			return $theValue;														// ==>
		
		} // Supported list container.

		throw new Exception
				( "The container must either be an array or ArrayObject",
				  kERROR_UNSUPPORTED );											// !@! ==>
	
	} // ManageTypedOffset.

	 
	/*===================================================================================
	 *	ManageIndexedOffset																*
	 *==================================================================================*/

	/**
	 * <h4>Manage an indexed offset</h4>
	 *
	 * Indexed offsets are constituted by a list of elements whose key is the discriminant,
	 * no two element may share the same key.
	 *
	 * The method accepts the following parameters:
	 *
	 * <ul>
	 *	<li><tt>&$theReference</tt>: Reference to the main container, it may either refer to
	 *		an array or an ArrayObject, any other type will trigger an exception.
	 *	<li><tt>$theOffset</tt>: The offset to the attribute containing the list of
	 *		elements.
	 *	<li><tt>$theIndex</tt>: The element index. If you provide <tt>NULL</tt>, the index
	 *		will become 0 (zero) by default.
	 *	<li><tt>$theValue</tt>: The value or operation:
	 *	 <ul>
	 *		<li><tt>NULL</tt>: Return the the value at the provided index.
	 *		<li><tt>FALSE</tt>: Delete the value at the provided index.
	 *		<li><i>other</i>: Any other type will replace or set the value at the provided
	 *			index.
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
	 * The method expects each element to be a structure containing at least an element
	 * indexed by the <tt>$theDataOffset</tt> offset, if that is not the case, the method
	 * will raise an exception.
	 *
	 * @param reference			   &$theReference		Array or ArrayObject reference.
	 * @param string				$theOffset			Offset to be managed.
	 * @param string				$theIndex			Item index.
	 * @param mixed					$theValue			New value or operation.
	 * @param boolean				$getOld				TRUE get old value.
	 *
	 * @static
	 * @return mixed
	 *
	 * @throws Exception
	 */
	function ManageIndexedOffset( &$theReference,
								   $theOffset, $theIndex,
								   $theValue = NULL, $getOld = FALSE )
	{
		//
		// Check list container.
		//
		if( is_array( $theReference )
		 || ($theReference instanceof ArrayObject) )
		{
			//
			// Init local storage.
			//
			$offset = $save = NULL;
			
			//
			// Normalise index.
			//
			if( $theIndex === NULL )
				$theIndex = 0;
			
			//
			// Check offset.
			//
			if( ( is_array( $theReference )
			   && array_key_exists( $theOffset, $theReference ) )
			 || ( ($theReference instanceof ArrayObject)
			   && $theReference->offsetExists( $theOffset ) ) )
			{
				//
				// Check offset.
				//
				if( is_array( $theReference[ $theOffset ] ) )
				{
					//
					// Save offset.
					//
					$offset = $theReference[ $theOffset ];
					
					//
					// Save value.
					//
					if( array_key_exists( $theIndex, $offset ) )
						$save = $offset[ $theIndex ];
					
				} // Element is list.
				
				else
					throw new Exception
							( "The offset must be an array",
							  kERROR_UNSUPPORTED );								// !@! ==>
			
			} // Offset exists.
			
			//
			// Retrieve.
			//
			if( $theValue === NULL )
				return $save;														// ==>
			
			//
			// Delete.
			//
			if( $theValue === FALSE )
			{
				//
				// Remove.
				//
				if( $save !== NULL )
				{
					//
					// Unset.
					//
					unset( $offset[ $theIndex ] );
					
					//
					// Update offset.
					//
					if( count( $offset ) )
						$theReference[ $theOffset ] = $offset;
					
					//
					// Clear offset.
					//
					else
					{
						if( is_array( $theReference ) )
							unset( $theReference[ $theOffset ] );
						else
							$theReference->offsetUnset( $theOffset );
					
					} // Empty list.
					
					if( $getOld )
						return $save;												// ==>
				
				} // Matched.
				
				return NULL;														// ==>
			
			} // Delete.
			
			//
			// Set/replace element.
			//
			$offset[ $theIndex ] = $theValue;
			
			//
			// Update offset.
			//
			$theReference[ $theOffset ] = $offset;
			
			if( $getOld )
				return $save;														// ==>
			
			return $theValue;														// ==>
		
		} // Supported list container.

		throw new Exception
				( "Unsupported list container type",
				  kERROR_UNSUPPORTED );											// !@! ==>
	
	} // ManageIndexedOffset.

	 
	/*===================================================================================
	 *	ManageObjectSetOffset															*
	 *==================================================================================*/

	/**
	 * <h4>Manage an object set offset</h4>
	 *
	 * An object set is a list of unique objects, this method manages such an offset by
	 * handling add, retrieve and delete of its elements, rather than of the offset itself
	 * as in {@link ManageOffset}.
	 *
	 * The elements of the list are expected to be object references in the form of their
	 * native unique identifier, @link kTAG_NID}.
	 *
	 * When adding new elements, the method will check if the object already exists in the
	 * set by comparing the hashed identifiers, thus using the {@link kTAG_NID} of
	 * eventual full objects.
	 *
	 * When deleting elements, if the list becomes empty, the whole offset will be deleted.
	 *
	 * The method accepts the following parameters:
	 *
	 * <ul>
	 *	<li><b>&$theReference</b>: Reference to the set container, it may either refer to
	 *		an array or an {@link ArrayObject}, any other type will trigger an exception.
	 *	<li><b>$theOffset</b>: The offset to the set within the previous parameter, this
	 *		referenced element is expected to be an array, if this is not the case, the
	 *		method will raise an exception. Note that it must not be an ArrayObject.
	 *	<li><b>$theValue</b>: Depending on the next parameter, this may either refer to the
	 *		value to be set or to the index of the element to be retrieved or deleted:
	 *	 <ul>
	 *		<li><i>NULL</i>: This value indicates that we want to operate on all elements,
	 *			which means, in practical terms, that we either want to retrieve or delete
	 *			the full list. If the operation parameter resolves to <i>TRUE</i>, the
	 *			method will default to retrieving the current list and no new element will
	 *			be added.
	 *		<li><i>array</i>: An array indicates that we want to operate on a list of
	 *			values and that other parameters may also be provided as lists. Note that
	 *			ArrayObject instances are not considered here as arrays.
	 *		<li><i>other</i>: Any other type represents either the new value to be added or
	 *			the index to the value to be returned or deleted.
	 *	 </ul>
	 *	<li><b>$theOperation</b>: This parameter represents the operation to be performed
	 *		whose scope depends on the value of the previous parameter:
	 *	 <ul>
	 *		<li><i>NULL</i>: Return the element or full list.
	 *		<li><i>FALSE</i>: Delete the element or full list.
	 *		<li><i>array</i>: This type is only considered if the <i>$theValue</i> parameter
	 *			is provided as an array: the method will be called for each element of the
	 *			<i>$theValue</i> parameter matched with the corresponding element of this
	 *			parameter, which also means that both both parameters must share the same
	 *			count.
	 *		<li><i>other</i>: Add the <i>$theValue</i> value to the list. If you provided
	 *			<i>NULL</i> in the previous parameter, the operation will be reset to
	 *			<i>NULL</i>.
	 *	 </ul>
	 *	<li><b>$getOld</b>: Determines what the method will return:
	 *	 <ul>
	 *		<li><i>TRUE</i>: Return the value <i>before</i> it was eventually modified.
	 *		<li><i>FALSE</i>: Return the value <i>after</i> it was eventually modified.
	 *	 </ul>
	 * </ul>
	 *
	 * @param reference			   &$theReference		Object reference.
	 * @param string				$theOffset			Offset.
	 * @param mixed					$theValue			Value to manage.
	 * @param mixed					$theOperation		Operation to perform.
	 * @param boolean				$getOld				TRUE get old value.
	 *
	 * @return mixed
	 *
	 * @throws Exception
	 *
	 * @uses HashClosure()
	 * @uses ManageOffset()
	 */
	function ManageObjectSetOffset( &$theReference, $theOffset, $theValue = NULL,
																$theOperation = NULL,
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
			// Handle multiple parameters:
			//
			if( is_array( $theValue ) )
			{
				//
				// Init local storage.
				//
				$result = Array();
				$count = count( $theValue );
				
				//
				// Check operation.
				//
				if( is_array( $theOperation )
				 && (count( $theOperation ) != $count) )
					throw new Exception
							( "Values and operations counts do not match",
							  kERROR_PARAMETER );								// !@! ==>
				
				//
				// Iterate values.
				//
				foreach( $theValue as $index => $value )
				{
					//
					// Set operation.
					//
					$operation = ( is_array( $theOperation ) )
							   ? $theOperation[ $index ]
							   : $theOperation;
					
					//
					// Get result.
					//
					$result[]
						= ManageObjectSetOffset
							( $theReference, $theOffset,
							  $value, $operation,
							  $getOld );
				
				} // Iterating list of values.
				
				return $result;														// ==>
			
			} // Multiple parameters.
			
			//
			// Manage full list.
			//
			if( $theValue === NULL )
			{
				//
				// Prevent adding.
				// This is because we would be adding the operation...
				//
				if( $theOperation )
					$theOperation = NULL;
				
				//
				// Retrieve or delete.
				//
				return ManageOffset( $theReference,
									 $theOffset, $theOperation,
									 $getOld );										// ==>
			
			} // Manage full list.
			
			//
			// Save current list.
			//
			$list = ( isset( $theReference[ $theOffset ] ) )
				  ? $theReference[ $theOffset ]
				  : NULL;
			
			//
			// Init match.
			//
			$idx = $save = NULL;
			
			//
			// Match element.
			//
			if( is_array( $list )
			 || ($list instanceof ArrayObject) )
			{
				//
				// Hash match value.
				//
				$match = md5( serialize( $theValue ) );
				
				//
				// Match element.
				//
				foreach( $list as $key => $value )
				{
					//
					// Match.
					//
					if( $match == md5( serialize( $value ) ) )
					{
						//
						// Save index.
						//
						$idx = $key;
						
						//
						// Save value.
						//
						$save = $value;
						
						break;												// =>
					
					} // Matched.
				
				} // Matching element.
			
			} // Attribute is a list.
			
			//
			// Invalid attribute type.
			//
			elseif( $list !== NULL )
				throw new Exception
						( "Unsupported list attribute type",
						  kERROR_UNSUPPORTED );									// !@! ==>
			
			//
			// Return current value.
			//
			if( $theOperation === NULL )
				return $save;														// ==>
			
			//
			// Delete data.
			//
			if( $theOperation === FALSE )
			{
				//
				// Delete element.
				//
				if( $idx !== NULL )
				{
					//
					// Remove element.
					//
					unset( $list[ $idx ] );
					
					//
					// Update list.
					//
					if( count( $list ) )
						$theReference[ $theOffset ] = array_values( $list );
					
					//
					// Delete offset.
					//
					else
					{
						//
						// Delete offset.
						//
						if( is_array( $theReference ) )
							unset( $theReference[ $theOffset ] );
						else
							$theReference->offsetUnset( $theOffset );
					
					} // Deleted all elements.
				
				} // Element exists.
				
				if( $getOld )
					return $save;													// ==>
				
				return NULL;														// ==>
			
			} // Delete data.
			
			//
			// Add or replace element.
			//
			if( $list !== NULL )
			{
				//
				// Replace element.
				//
				if( $idx !== NULL )
					$list[ $idx ] = $theValue;
				
				//
				// Append new element.
				//
				else
					$list[] = $theValue;
			
			} // Had values.
			
			//
			// Create list.
			//
			else
				$list = array( $theValue );
			
			//
			// Update offset.
			//
			$theReference[ $theOffset ] = $list;
			
			if( $getOld )
				return $save;														// ==>
			
			return $theValue;														// ==>
		
		} // Supported reference.

		throw new Exception
				( "Unsupported object reference",
				  kERROR_UNSUPPORTED );											// !@! ==>
	
	} // ManageObjectSetOffset.


?>
