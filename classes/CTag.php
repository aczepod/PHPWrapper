<?php

/**
 * <i>CTag</i> class definition.
 *
 * This file contains the class definition of <b>CTag</b> which represents the ancestor of
 * all tag classes.
 *
 *	@package	MyWrapper
 *	@subpackage	Framework
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 17/09/2012
 */

/*=======================================================================================
 *																						*
 *										CTag.php										*
 *																						*
 *======================================================================================*/

/**
 * Tokens.
 *
 * This include file contains all default token definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_DEFINE."/Tokens.inc.php" );

/**
 * Category trait.
 *
 * This includes the category trait definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/TCategory.php" );

/**
 * Representation trait.
 *
 * This includes the representation trait definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/TRepresentation.php" );

/**
 * Ancestor.
 *
 * This includes the ancestor class definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_CLASS."/CPersistentObject.php" );

/**
 * <h4>Tag object ancestor</h4>
 *
 * A tag object represents a path between two vertices of a graph, it can be used as a
 * reference to that path.
 *
 * This class features the following default properties:
 *
 * <ul>
 *	<li><i>Path</i>: The tag path, or the <tt>{@link kTAG_PATH}</tt> tag, represents a
 *		sequence of <i>vertex</i>/<i>predicate</i>/<i>vertex</i> elements in which the odd
 *		elements represent relationship vertices and the even elements the predicates that
 *		connect these vertices. The class offers two methods, {@link PushItem()} and
 *		{@link PopItem()} which respectively allow to append and remove items from the top
 *		of the list.
 *	<li><i>Global identifier</i>: The global identifier, <tt>{@link GID()}</tt> or the
 *		<tt>{@link kTAG_GID}</tt> tag, is constituted by concatenating all the elements of
 *		the path attribute, separated by the {@link kTOKEN_INDEX_SEPARATOR} token.
 * </ul>
 *
 * A tag can be considered {@link _IsInited()} when it has at least one element in the path,
 * which represents the minimum legal number of path items.
 *
 * This class implements the logic to manage these paths without assuming the nature or
 * type of their elements: this will be the responsibility of derived classes. In this
 * class all items comprising the path must be convertable to strings
 *
 *	@package	MyWrapper
 *	@subpackage	Framework
 */
class CTag extends CPersistentObject
{
		

/*=======================================================================================
 *																						*
 *											TRAITS										*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	TCategory																		*
	 *==================================================================================*/

	/**
	 * <h4>Category traits</h4>
	 *
	 * This trait provides accessor methods for the category properties of the object:
	 *
	 * <ul>
	 *	<li><tt>{@link Category()}</tt>: The <i>categories</i>, {@link kTAG_CATEGORY},
	 *		represent a set of values that constitute the category of the tag.
	 *	<li><tt>{@link Kind()}</tt>: The <i>kinds</i>, {@link kTAG_KIND}, represent a set of
	 *		enumerations that represent the kind of of the tag.
	 *	<li><tt>{@link Type()}</tt>: The <i>types</i>, {@link kTAG_TYPE}, represent a set of
	 *		enumerations that define the tag's data type.
	 * </ul>
	 */
	use TCategory;

	 
	/*===================================================================================
	 *	TRepresentation																	*
	 *==================================================================================*/

	/**
	 * <h4>Representation traits</h4>
	 *
	 * This trait provides accessor methods for the attributes that define how a property
	 * is displayed and how this property is validated, this set of accessor methods will
	 * generally be copied from the tag's scale node, but should be set if the tag was
	 * created with terms:
	 *
	 * <ul>
	 *	<li><tt>{@link Input()}</tt>: The <i>input</i>, {@link kTAG_INPUT}, represents a set
	 *		of values which list the suggested or preferred control types that should be
	 *		used to display and modify an object property.
	 *	<li><tt>{@link Pattern()}</tt>: The <i>pattern</i>, {@link kTAG_PATTERN},
	 *		represents a regular expression that can be used to validate the input of an
	 *		attribute's value.
	 *	<li><tt>{@link Length()}</tt>: The <i>length</i>, {@link kTAG_LENGTH}, represents
	 *		the maximum number of characters a value may hold.
	 *	<li><tt>{@link LowerBound()}</tt>: The <i>lower bound</i>, {@link kTAG_MIN_VAL},
	 *		represents the lowest limit a range value may take.
	 *	<li><tt>{@link UpperBound()}</tt>: The <i>upper bound</i>, {@link kTAG_MAX_VAL},
	 *		represents the highest limit a range value may take.
	 *	<li><tt>{@link Example()}</tt>: The <i>examples</i>, {@link kTAG_EXAMPLES},
	 *		represents a list of values that can be used as examples which follow a set of
	 *		validation rules.
	 * </ul>
	 */
	use TRepresentation;
		


/*=======================================================================================
 *																						*
 *								PUBLIC MEMBER INTERFACE									*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	Synonym																			*
	 *==================================================================================*/

	/**
	 * <h4>Manage tag synonyms</h4>
	 *
	 * This method can be used to manage the tag's synonyms, {@link kTAG_SYNONYMS},
	 * which contains a list of strings that represent alternate codes or names that can be
	 * used to identify the tag.
	 *
	 * This offset collects the list of synonyms in an enumerated set that can be managed
	 * with the following parameters:
	 *
	 * <ul>
	 *	<li><tt>$theValue</tt>: Depending on the next parameter, this may either refer to
	 *		the value to be set or to the index of the element to be retrieved or deleted:
	 *	 <ul>
	 *		<li><tt>NULL</tt>: This value indicates that we want to operate on all elements,
	 *			which means, in practical terms, that we either want to retrieve or delete
	 *			the full list. If the operation parameter resolves to <tt>TRUE</tt>, the
	 *			method will default to retrieving the current list and no new element will
	 *			be added.
	 *		<li><tt>array</tt>: An array indicates that we want to operate on a list of
	 *			values and that other parameters may also be provided as lists. Note that
	 *			{@link ArrayObject} instances are not considered here as arrays.
	 *		<li><i>other</i>: Any other type represents either the new value to be added or
	 *			the index to the value to be returned or deleted.
	 *	 </ul>
	 *	<li><tt>$theOperation</tt>: This parameter represents the operation to be performed
	 *		whose scope depends on the value of the previous parameter:
	 *	 <ul>
	 *		<li><tt>NULL</tt>: Return the element or full list.
	 *		<li><tt>FALSE</tt>: Delete the element or full list.
	 *		<li><tt>array</tt>: This type is only considered if the <tt>$theValue</tt>
	 *			parameter is provided as an array: the method will be called for each
	 *			element of the <tt>$theValue</tt> parameter matched with the corresponding
	 *			element of this parameter, which also means that both both parameters must
	 *			share the same count.
	 *		<li><i>other</i>: Add the <tt>$theValue</tt> value to the list. If you provided
	 *			<tt>NULL</tt> in the previous parameter, the operation will be reset to
	 *			<tt>NULL</tt>.
	 *	 </ul>
	 *	<li><tt>$getOld</tt>: Determines what the method will return:
	 *	 <ul>
	 *		<li><tt>TRUE</tt>: Return the value <i>before</i> it was eventually modified.
	 *		<li><tt>FALSE</tt>: Return the value <i>after</i> it was eventually modified.
	 *	 </ul>
	 * </ul>
	 *
	 * @param mixed					$theValue			Value or index.
	 * @param mixed					$theOperation		Operation.
	 * @param boolean				$getOld				TRUE get old value.
	 *
	 * @access public
	 * @return mixed				<i>New</i> or <i>old</i> type.
	 *
	 * @uses ManageObjectSetOffset()
	 *
	 * @see kTAG_SYNONYMS
	 */
	public function Synonym( $theValue = NULL, $theOperation = NULL, $getOld = FALSE )
	{
		return ManageObjectSetOffset
			( $this, kTAG_SYNONYMS, $theValue, $theOperation, $getOld );			// ==>

	} // Synonym.
		

	/*===================================================================================
	 *	PushItem																		*
	 *==================================================================================*/

	/**
	 * <h4>Append to path</h4>
	 *
	 * This method will add the provided item to the tag path, the element will be appended
	 * to the end of the list.
	 *
	 * The provided item is considered as-is, that means that arrays are considered as a
	 * scalar item. If you provide <tt>NULL</tt> as the value, this will be ignored and the
	 * method will return <tt>FALSE</tt>.
	 *
	 * The method will return the current number of items in the list.
	 *
	 * @param mixed					$theValue			Value to append.
	 *
	 * @access public
	 * @return integer				Number of items in the list.
	 *
	 * @see kTAG_PATH
	 */
	public function PushItem( $theValue )
	{
		//
		// Check value.
		//
		if( $theValue !== NULL )
		{
			//
			// Check if list exists.
			//
			if( $this->offsetExists( kTAG_PATH ) )
			{
				//
				// Get list.
				//
				$list = $this->offsetGet( kTAG_PATH );
				
				//
				// Add item.
				//
				$list[] = $theValue;
				
				//
				// Update list.
				//
				$this->offsetSet( kTAG_PATH, $list );
				
				return count( $list );												// ==>
			
			} // Has list.
			
			//
			// Create list.
			//
			$this->offsetSet( kTAG_PATH, array( $theValue ) );
			
			return 1;																// ==>
		
		} // Provided non-null value.
		
		return FALSE;																// ==>

	} // PushItem.

	 
	/*===================================================================================
	 *	PopItem																			*
	 *==================================================================================*/

	/**
	 * <h4>Remove from path</h4>
	 *
	 * This method will remove the last item from the tag path and return it to the caller.
	 *
	 * If the removed item is the last one, the offset will be deleted, if the list is
	 * missing, the method will return <tt>NULL</tt>.
	 *
	 * @access public
	 * @return mixed				Last item of the list or <tt>NULL</tt>.
	 *
	 * @see kTAG_PATH
	 */
	public function PopItem()
	{
		//
		// Check if list exists.
		//
		if( $this->offsetExists( kTAG_PATH ) )
		{
			//
			// Get list.
			//
			$list = $this->offsetGet( kTAG_PATH );
			
			//
			// Pop item.
			//
			$item = array_pop( $list );
			
			//
			// Update list.
			//
			if( count( $list ) )
				$this->offsetSet( kTAG_PATH, $list );
			
			//
			// Delete list.
			//
			else
				$this->offsetUnset( kTAG_PATH );
			
			return $item;															// ==>
		
		} // Has list.
		
		return NULL;																// ==>

	} // PopItem.
		


/*=======================================================================================
 *																						*
 *							PROTECTED IDENTIFICATION INTERFACE							*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_index																			*
	 *==================================================================================*/

	/**
	 * <h4>Return the object's global unique identifier</h4>
	 *
	 * The tag is identified by its path items, this method will return the list of items
	 * separated by the {@link kTOKEN_INDEX_SEPARATOR} token.
	 *
	 * This also means that all elements of the path must be convertable to string.
	 *
	 * @param CConnection			$theConnection		Server, database or container.
	 * @param bitfield				$theModifiers		Commit options.
	 *
	 * @access protected
	 * @return string|NULL			The object's global unique identifier.
	 *
	 * @see kTAG_PATH kTOKEN_INDEX_SEPARATOR
	 */
	protected function _index( CConnection $theConnection, $theModifiers )
	{
		return implode( kTOKEN_INDEX_SEPARATOR,
						$this->offsetGet( kTAG_PATH ) );						// ==>
	
	} // _index.
		


/*=======================================================================================
 *																						*
 *								PROTECTED OFFSET INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_Preset																			*
	 *==================================================================================*/

	/**
	 * <h4>Handle offset before setting it</h4>
	 *
	 * In this class we ensure that the {@link kTAG_PATH} offset is an array,
	 * ArrayObject instances are not counted as an array.
	 *
	 * We also prevent changing the data type once the object was committed.
	 *
	 * @param reference			   &$theOffset			Offset.
	 * @param reference			   &$theValue			Value to set at offset.
	 *
	 * @access protected
	 *
	 * @throws Exception
	 *
	 * @see kTAG_PATH
	 */
	protected function _Preset( &$theOffset, &$theValue )
	{
		//
		// Parse by offset.
		//
		switch( $theOffset )
		{
			case kTAG_PATH:
				if( ($theValue !== NULL)
				 && (! is_array( $theValue )) )
				throw new Exception
					( "Invalid type for the [$theOffset] offset: "
					 ."it must be an array",
					  kERROR_PARAMETER );										// !@! ==>
				break;
			
			case kTAG_TYPE:
				if( ($theValue !== NULL)
				 && $this->offsetExists( kTAG_TYPE )
				 && $this->_IsCommitted() )
				throw new Exception
					( "Cannot modify data type: "
					 ."the object is committed",
					  kERROR_PARAMETER );										// !@! ==>
				break;
		}
		
		//
		// Call parent method.
		//
		parent::_Preset( $theOffset, $theValue );
	
	} // _Preset.

	 
	/*===================================================================================
	 *	_Preunset																		*
	 *==================================================================================*/

	/**
	 * <h4>Handle offset before unsetting it</h4>
	 *
	 * In this class we prevent resetting the path and the data type once the object is
	 * committed.
	 *
	 * @param reference			   &$theOffset			Offset.
	 *
	 * @access protected
	 *
	 * @uses _IsDirty()
	 */
	protected function _Preunset( &$theOffset )
	{
		//
		// Parse by offset.
		//
		switch( $theOffset )
		{
			case kTAG_PATH:
				if( $this->_IsCommitted() )
				throw new Exception
					( "Cannot reset path: "
					 ."the object is committed",
					  kERROR_PARAMETER );										// !@! ==>
				break;

			case kTAG_TYPE:
				if( $this->_IsCommitted() )
				throw new Exception
					( "Cannot reset data type: "
					 ."the object is committed",
					  kERROR_PARAMETER );										// !@! ==>
				break;
		}
		
		//
		// Call parent method.
		//
		parent::_Preset( $theOffset, $theValue );
	
	} // _Preunset.
		


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
	 * In this class we check if the current path has an odd number of items, if that is not
	 * the case, the method will raise an exception.
	 *
	 * @param reference			   &$theConnection		Server, database or container.
	 * @param reference			   &$theModifiers		Commit options.
	 *
	 * @access protected
	 * @return mixed
	 *
	 * @throws Exception
	 *
	 * @see kTAG_PATH
	 */
	protected function _PrecommitValidate( &$theConnection, &$theModifiers )
	{
		//
		// Call parent method.
		//
		parent::_PrecommitValidate( $theConnection, $theModifiers );
	
		//
		// Check path count.
		// Note that the parent method will have checked the path is there.
		//
		if( ! (count( $this->offsetGet( kTAG_PATH ) ) % 2) )	// Even.
			throw new Exception
				( "Unable to commit object: "
				 ."the path must have an odd number of elements",
				  kERROR_STATE );												// !@! ==>
		
		return NULL;																// ==>
		
	} // _PrecommitValidate.
		


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
	 * {@link kTAG_PATH} offset.
	 *
	 * @access protected
	 * @return boolean				<tt>TRUE</tt> means {@link _IsInited( <tt>TRUE</tt> ).
	 *
	 * @uses _Ready()
	 *
	 * @see kTAG_PATH
	 */
	protected function _Ready()
	{
		//
		// Check parent.
		//
		if( parent::_Ready() )
			return $this->offsetExists( kTAG_PATH );							// ==>
		
		return FALSE;																// ==>
	
	} // _Ready.

	 

} // class CTag.


?>
