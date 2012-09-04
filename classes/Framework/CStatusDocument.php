<?php namespace MyWrapper\Framework;

/**
 * <i>CStatusDocument</i> class definition.
 *
 * This file contains the class definition of <b>CStatusDocument</b> which extends its
 * {@link CDocument ancestor} to handle states.
 *
 *	@package	MyWrapper
 *	@subpackage	Framework
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 03/09/2012
 */

/*=======================================================================================
 *																						*
 *									CStatusDocument.php									*
 *																						*
 *======================================================================================*/

/**
 * Ancestor.
 *
 * This includes the ancestor class definitions.
 */
use MyWrapper\Framework\CDocument;

/**
 * Flags.
 *
 * This include file contains all status flag definitions.
 */
require_once( kPATH_MYWRAPPER_LIBRARY_DEFINE."/Flags.inc.php" );

/**
 * <h3>Document with status object</h3>
 *
 * This class manages a data member which can be used to track the state of the object.
 *
 * The status is recorded in a {@link $mStatus property} that does not belong to the
 * object's array data store. The data member consists of a 4 byte bit field in which the
 * first 31 elements are used to record on/off states.
 *
 * <i>Note: you should use only the first 31 bits because PHP tends to cast a bitfield into
 * a 32 bit integer which uses the last bit as the sign.</i>
 *
 *	@package	MyWrapper
 *	@subpackage	Framework
 */
class CStatusDocument extends CDocument
{
	/**
	 * <b>Object status</b>
	 *
	 * This data member is a bitfield that holds the object status.
	 *
	 * @var bitfield
	 */
	 protected $mStatus = kFLAG_DEFAULT;

		

/*=======================================================================================
 *																						*
 *								PUBLIC ARRAY ACCESS INTERFACE							*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	offsetSet																		*
	 *==================================================================================*/

	/**
	 * <h4>Set a value for a given offset</h4>
	 *
	 * We override this method to handle the dirty flag: when the value changes, we turn the
	 * {@link kFLAG_STATE_DIRTY} status flag on.
	 *
	 * @param string				$theOffset			Offset.
	 * @param mixed					$theValue			Value to set at offset.
	 *
	 * @access public
	 *
	 * @uses _IsDirty()
	 *
	 * @see kFLAG_STATE_DIRTY
	 */
	public function offsetSet( $theOffset, $theValue )
	{
		//
		// Check for changes.
		//
		if( $this->offsetGet( $theOffset ) !== $theValue )
			$this->_IsDirty( TRUE );
		
		//
		// Call parent method.
		//
		parent::offsetSet( $theOffset, $theValue );
	
	} // offsetSet.

	 
	/*===================================================================================
	 *	offsetUnset																		*
	 *==================================================================================*/

	/**
	 * <h4>Reset a value for a given offset</h4>
	 *
	 * We override this method to handle the dirty flag: when the value changes, we turn the
	 * {@link kFLAG_STATE_DIRTY} status flag on.
	 *
	 * @param string				$theOffset			Offset.
	 *
	 * @access public
	 *
	 * @uses _IsDirty()
	 *
	 * @see kFLAG_STATE_DIRTY
	 */
	public function offsetUnset( $theOffset )
	{
		//
		// Check for changes.
		//
		if( $this->offsetGet( $theOffset ) !== NULL )
			$this->_IsDirty( TRUE );
		
		//
		// Call parent method.
		//
		parent::offsetUnset( $theOffset );
	
	} // offsetUnset.

		

/*=======================================================================================
 *																						*
 *							STATIC MEMBER ACCESSOR INTERFACE							*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	ManageBitField																	*
	 *==================================================================================*/

	/**
	 * <h4>Manage bit-field property</h4>
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
	static function ManageBitField( &$theField, $theMask, $theState = NULL )
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
 *							PROTECTED STATUS MANAGEMENT INTERFACE						*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	_IsInited																		*
	 *==================================================================================*/

	/**
	 * <h4>Manage inited status</h4>
	 *
	 * This method can be used to get or set the object's inited state.
	 *
	 * An object becomes inited when it has all the required elements necessary for it to be
	 * correctly used or persistently stored. Such a state indicates that at least the
	 * minimum required information was initialised in the object.
	 *
	 * The counterpart state indicates that the object still lacks the necessary elements to
	 * successfully operate the object.
	 *
	 * This method operates by setting or clearing the {@link kFLAG_STATE_INITED} flag.
	 *
	 * The method features a single parameter:
	 *
	 * <ul>
	 *	<li><tt>NULL</tt>: The method will return the object's inited state.
	 *	<li><tt>TRUE</tt>: The method will set the object's inited state.
	 *	<li><tt>FALSE</tt>: The method will reset the object's inited state.
	 * </ul>
	 *
	 * In all cases the method will return the state <i>after</i> it was eventually
	 * modified.
	 *
	 * @param mixed					$theState			<tt>TRUE</tt>, <tt>FALSE</tt> or
	 *													<tt>NULL</tt>.
	 *
	 * @access protected
	 * @return boolean				<tt>TRUE</tt> inited, <tt>FALSE</tt> idle.
	 *
	 * @uses ManageBitField()
	 *
	 * @see kFLAG_STATE_INITED
	 */
	protected function _IsInited( $theState = NULL )
	{
		return self::ManageBitField( $this->mStatus,
									 kFLAG_STATE_INITED,
									 $theState );									// ==>
	
	} // _IsInited.

	 
	/*===================================================================================
	 *	_IsDirty																		*
	 *==================================================================================*/

	/**
	 * <h4>Manage dirty status</h4>
	 *
	 * This method can be used to get or set the object's dirty state.
	 *
	 * A dirty object is one that was modified since the last time this state was probed. In
	 * general, this state should be set whenever the persistent properties of the object
	 * are modified.
	 *
	 * In this class we automatically set this state when setting or unsetting offsets.
	 *
	 * The method features a single parameter:
	 *
	 * <ul>
	 *	<li><tt>NULL</tt>: The method will return the object's dirty state.
	 *	<li><tt>TRUE</tt>: The method will set the object's dirty state.
	 *	<li><tt>FALSE</tt>: The method will reset the object's dirty state.
	 * </ul>
	 *
	 * In all cases the method will return the state <i>after</i> it was eventually
	 * modified.
	 *
	 * @param mixed					$theState			<tt>TRUE</tt>, <tt>FALSE</tt> or
	 *													<tt>NULL</tt>.
	 *
	 * @access protected
	 * @return boolean				<tt>TRUE</tt> dirty, <tt>FALSE</tt> clean.
	 *
	 * @uses ManageBitField()
	 *
	 * @see kFLAG_STATE_DIRTY
	 */
	protected function _IsDirty( $theState = NULL )
	{
		return self::ManageBitField( $this->mStatus,
									 kFLAG_STATE_DIRTY,
									 $theState );									// ==>
	
	} // _IsDirty.

	 
	/*===================================================================================
	 *	_IsCommitted																	*
	 *==================================================================================*/

	/**
	 * <h4>Manage committed status</h4>
	 *
	 * This method can be used to get or set the object's committed state.
	 *
	 * A committed object is one that has either been loaded from a container or committed
	 * to a container, this state can be used in conjunction with the
	 * {@link kFLAG_STATE_DIRTY} flag to determine whether an object needs to be committed.
	 *
	 * The method features a single parameter:
	 *
	 * <ul>
	 *	<li><tt>NULL</tt>: The method will return the object's committed state.
	 *	<li><tt>TRUE</tt>: The method will set the object's committed state.
	 *	<li><tt>FALSE</tt>: The method will reset the object's committed state.
	 * </ul>
	 *
	 * In all cases the method will return the state <i>after</i> it was eventually
	 * modified.
	 *
	 * @param mixed					$theState			<tt>TRUE</tt>, <tt>FALSE</tt> or
	 *													<tt>NULL</tt>.
	 *
	 * @access protected
	 * @return boolean				<tt>TRUE</tt> committed, <tt>FALSE</tt> uncommitted.
	 *
	 * @uses ManageBitField()
	 *
	 * @see kFLAG_STATE_COMMITTED
	 */
	protected function _IsCommitted( $theState = NULL )
	{
		return self::ManageBitField( $this->mStatus,
									 kFLAG_STATE_COMMITTED,
									 $theState );									// ==>
	
	} // _IsCommitted.

	 
	/*===================================================================================
	 *	_IsEncoded																		*
	 *==================================================================================*/

	/**
	 * <h4>Manage encoded status</h4>
	 *
	 * This method can be used to get or set the object's encoded state.
	 *
	 * This flag determines whether the object should take care of serialising custom data
	 * types before the object is transmitted over the network.
	 *
	 * The method features a single parameter:
	 *
	 * <ul>
	 *	<li><tt>NULL</tt>: The method will return the object's encoded state.
	 *	<li><tt>TRUE</tt>: The method will set the object's encoded state.
	 *	<li><tt>FALSE</tt>: The method will reset the object's encoded state.
	 * </ul>
	 *
	 * In all cases the method will return the state <i>after</i> it was eventually
	 * modified.
	 *
	 * @param mixed					$theState			<tt>TRUE</tt>, <tt>FALSE</tt> or
	 *													<tt>NULL</tt>.
	 *
	 * @access protected
	 * @return boolean				<tt>TRUE</tt> supports encoding, <tt>FALSE</tt> does not
	 *								support encoding.
	 *
	 * @uses ManageBitField()
	 *
	 * @see kFLAG_STATE_ENCODED
	 */
	protected function _IsEncoded( $theState = NULL )
	{
		return self::ManageBitField( $this->mStatus,
									 kFLAG_STATE_ENCODED,
									 $theState );									// ==>
	
	} // _IsEncoded.

	 

} // class CStatusDocument.


?>
