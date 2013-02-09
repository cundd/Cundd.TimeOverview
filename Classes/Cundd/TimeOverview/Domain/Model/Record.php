<?php
namespace Cundd\TimeOverview\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Cundd.TimeOverview".    *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * A time record
 *
 * @Flow\Entity
 *
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="record_type", type="string")
 * @ORM\DiscriminatorMap({"standard_record"="Record", "special_record"="SpecialRecord"})
 */
class Record {
	const RECORD_TYPE = 'RECORD_TYPE';
	const RECORD_TYPE_STANDARD = 'RECORD_TYPE_STANDARD';
	const RECORD_TYPE_SPECIAL = 'RECORD_TYPE_SPECIAL';

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
	 * @Flow\Validate(type="NotEmpty")
	 */
	protected $end;

	/**
	 * Comment
	 *
	 * @var string
	 */
	protected $comment;

	/**
	 * Person
	 *
	 * @var \Cundd\TimeOverview\Domain\Model\Person
	 * @ORM\ManyToOne(inversedBy="records")
	 */
	protected $person;

	/**
	 * Task
	 *
	 * @var \Cundd\TimeOverview\Domain\Model\Task
	 * @ORM\ManyToOne(inversedBy="records",cascade={"persist"})
	 */
	protected $task;

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
	public function setStart(\DateTime $start) {
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
	public function setEnd(\DateTime $end) {
		$this->end = $end;
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
	 * Returns the person
	 *
	 * @return \Cundd\TimeOverview\Domain\Model\Person $person
	 */
	public function getPerson() {
		return $this->person;
	}

	/**
	 * Sets the person
	 *
	 * @param \Cundd\TimeOverview\Domain\Model\Person $person
	 * @return void
	 */
	public function setPerson(Person $person) {
		$this->person = $person;
	}

	/**
	 * Returns the task
	 *
	 * @return \Cundd\TimeOverview\Domain\Model\Task $task
	 */
	public function getTask() {
		return $this->task;
	}

	/**
	 * Sets the task
	 *
	 * @param \Cundd\TimeOverview\Domain\Model\Task $task
	 * @return void
	 */
	public function setTask(Task $task) {
		$this->task = $task;
	}

	/**
	 * Returns the duration
	 *
	 * @return \DateInterval Returns the time interval or FALSE on error
	 */
	public function getDuration() {
		$start = $this->getStart();
		$end = $this->getEnd();
		if (!$start || !$end) {
			return FALSE;
		}
		return $end->diff($start);
	}

	/**
	 * Returns the formatted duration
	 *
	 * @return string
	 */
	public function getFormattedDuration() {
		$duration = $this->getDuration();
		if ($duration) {
			return $duration->format('%hh %Imin');
		}
		return '';
	}

	/**
	 * Returns the duration in seconds
	 *
	 * @return integer Returns the time interval or FALSE on error
	 */
	public function getDurationInSeconds() {
		$start = $this->getStart()->getTimestamp();
		$end = $this->getEnd()->getTimestamp();
		if (!$start || !$end) {
			return FALSE;
		}
		return $end - $start;
	}



}
?>