<?php
namespace Cundd\TimeOverview\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Cundd.TimeOverview".    *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;
use Cundd\TimeOverview\Domain\Model\Record as Record;

/**
 * A special time record
 *
 * @Flow\Entity
 */
class SpecialRecord extends Record {

	/**
	 * Title
	 *
	 * @var string
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $title;

	/**
	 * Recurring
	 *
	 * @var integer
	 */
	protected $recurring;

	/**
	 * Returns the title
	 *
	 * @return string $title
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Sets the title
	 *
	 * @param string $title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Returns the recurring
	 *
	 * @return integer $recurring
	 */
	public function getRecurring() {
		return $this->recurring;
	}

	/**
	 * Sets the recurring
	 *
	 * @param integer $recurring
	 * @return void
	 */
	public function setRecurring($recurring) {
		$this->recurring = $recurring;
	}

}
?>