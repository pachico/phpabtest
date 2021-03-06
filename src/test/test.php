<?php

/**
 * @author Mariano F.co Benítez Mulet <nanodevel@gmail.com>
 * @copyright (c) 2016, Mariano F.co Benítez Mulet
 */

namespace Pachico\Abtest\Test;

use \Pachico\Abtest\Segmentation;
use \Pachico\Abtest\Split;
use \Pachico\Abtest\Memory;

/**
 * Each AB test is an instance of this class
 */
class Test
{

	/**
	 *
	 * @var string
	 */
	protected $_name;

	/**
	 *
	 * @var Split\SplitInterface
	 */
	protected $_split;

	/**
	 *
	 * @var Segmentation\SegmentatIoninterface
	 */
	protected $_segmentation;

	/**
	 *
	 * @var string
	 */
	protected $_tracking_id;

	/**
	 *
	 * @var Memory\MemoryInterface
	 */
	protected $_memory;

	/**
	 *
	 * @var int
	 */
	protected $_version = false;

	/**
	 *
	 * @param string $name
	 * @param \Pachico\Abtest\Split\SplitInterface $split
	 * @param \Pachico\Abtest\Memory\MemoryInterface $memory
	 * @param \Pachico\Abtest\Segmentation\SegmentatIoninterface $segmentation
	 * @param string $tracking_id
	 */
	public function __construct($name, Split\SplitInterface $split, Memory\MemoryInterface $memory, Segmentation\SegmentatIoninterface $segmentation = null, $tracking_id = null)
	{
		$this->_name = $name;
		$this->_split = $split;
		$this->_memory = $memory;
		$this->_segmentation = $segmentation;
		$this->_tracking_id = $tracking_id;
	}

	/**
	 *
	 * @return string
	 */
	public function getName()
	{
		return $this->_name;
	}

	/**
	 *
	 * @return boolean
	 */
	public function isParticipant()
	{
		if (is_null($this->_segmentation))
		{
			return true;
		}

		return $this->_segmentation->isParticipant();
	}

	/**
	 * @return int
	 */
	public function getVersion()
	{
		if (!$this->isParticipant())
		{
			return false;
		}

		// Sort of cache
		if (false === $this->_version)
		{
			$this->_version = $this->_memory->getVersion($this, $this->_split);
		}

		return $this->_version;
	}

	/**
	 *
	 * @return string
	 */
	public function getTrackingId()
	{
		return $this->_tracking_id;
	}

}
