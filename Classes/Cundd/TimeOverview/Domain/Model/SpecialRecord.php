<?php
namespace Cundd\TimeOverview\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Cundd.TimeOverview".    *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * A special time record
 *
 * @Flow\Entity
 */
class SpecialRecord {

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
	 * Comment
	 *
	 * @var string
	 */
	protected $comment;

	/**
	 * Start
	 *
	 * @var \DateTime
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $start;

	/**
	 * End
	 *
	 * @var \DateTime
	 */
	protected $end;

	/**
	 * Person
	 *
	 * @var \Cundd\TimeOverview\Domain\Model\Person
	 * @ORM\ManyToMany(mappedBy="specialRecords")
	 */
	protected $person;

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

	/**
	 * Returns the comment
	 *
	 * @return string $comment
	 */
	public function getComment() {
		return $this->comment;
	}

	/**
	 * Sets the comment
	 *
	 * @param string $comment
	 * @return void
	 */
	public function setComment($comment) {
		$this->comment = $comment;
	}

	/**
	 * Returns the start
	 *
	 * @return \DateTime $start
	 */
	public function getStart() {
		return $this->start;
	}

	/**
	 * Sets the start
	 *
	 * @param \DateTime $start
	 * @return void
	 */
	public function setStart($start) {
		$this->start = $start;
	}

	/**
	 * Returns the end
	 *
	 * @return \DateTime $end
	 */
	public function getEnd() {
		return $this->end;
	}

	/**
	 * Sets the end
	 *
	 * @param \DateTime $end
	 * @return void
	 */
	public function setEnd($end) {
		$this->end = $end;
	}

	/**
	 * Returns the person
	 *
	 * @return \Cundd\TimeOverview\Domain\Model\Task\Person $person
	 */
	public function getPerson() {
		return $this->person;
	}

	/**
	 * Sets the person
	 *
	 * @param \Cundd\TimeOverview\Domain\Model\Task\Person $person
	 * @return void
	 */
	public function setPerson(Person $person) {
		$this->person = $person;
	}

}
?>