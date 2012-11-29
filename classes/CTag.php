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
 *								PUBLIC MEMBER INTERFACE									*
 *																						*
 *======================================================================================*/


	 
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
		// Ensure path is array.
		//
		if( ($theOffset == kTAG_PATH)
		 && ($theValue !== NULL)
		 && (! is_array( $theValue )) )
			throw new Exception
				( "Invalid type for the [$theOffset] offset: "
				 ."it must be an array",
				  kERROR_PARAMETER );											// !@! ==>
		
		//
		// Call parent method.
		//
		parent::_Preset( $theOffset, $theValue );
	
	} // _Preset.
		


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
