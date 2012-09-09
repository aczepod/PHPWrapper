<?php namespace MyWrapper\Persistence;

/**
 * <i>CMongoSequence</i> class definition.
 *
 * This file contains the class definition of <b>CMongoSequence</b> which implements a
 * concrete Mongo based sequence object.
 *
 *	@package	MyWrapper
 *	@subpackage	Persistence
 *
 *	@author		Milko A. Škofič <m.skofic@cgiar.org>
 *	@version	1.00 09/09/2012
 */

/*=======================================================================================
 *																						*
 *									CMongoSequence.php									*
 *																						*
 *======================================================================================*/

/**
 * Exceptions.
 *
 * This include file contains the native exceptions class definitions.
 */
use \Exception as Exception;

/**
 * Ancestor.
 *
 * This include file contains the parent class definitions.
 */
use \MyWrapper\Persistence\CMongoContainer as CMongoContainer;

/**
 * <h3>Mongo based sequence number generator</h3>
 *
 * The purpose of objects of this kind is to provide an automatic sequential number 
 * generator.
 *
 * The class feature a single public method whose purpose is to return a sequence number
 * given a key.
 *
 *	@package	MyWrapper
 *	@subpackage	Persistence
 */
class CMongoSequence extends CMongoContainer
{
		

/*=======================================================================================
 *																						*
 *								PUBLIC SEQUENCE INTERFACE								*
 *																						*
 *======================================================================================*/


	 
	/*===================================================================================
	 *	Next																			*
	 *==================================================================================*/

	/**
	 * <h4>Return a sequence number</h4>
	 *
	 * This method should return a sequence number connected to the provided key. Each time
	 * this method is called, the sequence number is incremented, which means that you
	 * should only call it when you intend to use this number.
	 *
	 * If the object is not {@link _Is Inited()}, the method will raise an exception.
	 *
	 * @param string				$theKey				Sequence key.
	 *
	 * @access public
	 * @return integer				The sequence number.
	 */
	public function Next( $theKey )
	{
		//
		// Check inited status.
		//
		if( $this->_IsInited() )
		{
			//
			// Init local storage.
			//
			$container = $this->Connection();
			$options = array( 'safe' => TRUE );
			$criteria = array( '_id' => $theKey );
			
			//
			// Read sequence number.
			//
			$seq = $container->findOne( $criteria );
			
			//
			// Handle first.
			//
			if( $seq === NULL )
			{
				//
				// Save next.
				//
				$ok = $container->save( array( '_id' => $theKey, 'seq' => 2 ), $options );
				if( $ok[ 'ok' ] )
					return 1;														// ==>
				
				throw new Exception
					( $ok[ 'errmsg' ],
					  kERROR_COMMIT );											// !@! ==>
			
			} // First sequence.
			
			//
			// Handle existing sequence.
			//
			else
			{
				//
				// Save sequence.
				//
				$number = $seq[ 'seq' ]++;
				
				//
				// Increment sequence.
				//
				$ok = $container->save( $seq, $options );
				if( ! $ok[ 'ok' ] )
					throw new Exception
						( $ok[ 'errmsg' ],
						  kERROR_COMMIT );										// !@! ==>
				
				return $number;														// ==>
			
			} // Sequence exists.
		
		} // Object is inited.
		
		throw new Exception
			( "Object is not ready",
			  kERROR_STATE );													// !@! ==>
	
	} // Next.

	 

} // class CMongoSequence.


?>
