<?php
namespace Cundd\TimeOverview\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Cundd.TimeOverview".    *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * A task
 *
 * @Flow\Entity
 */
class Task {

	/**
	 * Title
	 *
	 * @var string
	 * @Flow\Validate(type="StringLength", options={ "minimum"=1, "maximum"=100 })
	 */
	protected $title;

	/**
	 * Description
	 *
	 * @var string
	 */
	protected $description;

	/**
	 * Time records
	 *
	 * @var \Doctrine\Common\Collections\Collection<\Cundd\TimeOverview\Domain\Model\Record>
	 * @ORM\OneToMany(mappedBy="task")
	 */
	protected $records;

	/**
	 * Project
	 *
	 * @var \Cundd\TimeOverview\Domain\Model\Project
	 * @ORM\ManyToOne(inversedBy="tasks")
	 */
	protected $project;

	/**
	 * __construct
	 *
	 * @return void
	 */
	public function __construct() {
		//Do not remove the next line: It would break the functionality
		$this->initStorageObjects();
	}

	/**
	 * Initializes all \Doctrine\Common\Collections\ArrayCollection properties.
	 *
	 * @return void
	 */
	protected function initStorageObjects() {
		/**
		 * Do not modify this method!
		 * It will be rewritten on each save in the extension builder
		 * You may modify the constructor of this class instead
		 */
		$this->records = new \Doctrine\Common\Collections\ArrayCollection();
	}

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
	 * Returns the description
	 *
	 * @return string $description
	 */
	public function getDescription() {
		return $this->description;
	}

	/**
	 * Sets the description
	 *
	 * @param string $description
	 * @return void
	 */
	public function setDescription($description) {
		$this->description = $description;
	}

	/**
	 * Returns the project
	 *
	 * @return \Cundd\TimeOverview\Domain\Model\Project $project
	 */
	public function getProject() {
		return $this->project;
	}

	/**
	 * Sets the project
	 *
	 * @param \Cundd\TimeOverview\Domain\Model\Project $project
	 * @return void
	 */
	public function setProject(Project $project) {
		$this->project = $project;
	}

	/**
	 * Adds a Record
	 *
	 * @param \Cundd\TimeOverview\Domain\Model\Record $record
	 * @return void
	 */
	public function addRecord(Record $record) {
		$this->records->add($record);
	}

	/**
	 * Removes a Record
	 *
	 * @param \Cundd\TimeOverview\Domain\Model\Record $recordToRemove The Record to be removed
	 * @return void
	 */
	public function removeRecord(Record $recordToRemove) {
		$this->records->removeElement($recordToRemove);
	}

	/**
	 * Returns the records
	 *
	 * @return \Doctrine\Common\Collections\Collection<\Cundd\TimeOverview\Domain\Model\Record> $records
	 */
	public function getRecords() {
		return $this->records;
	}

	/**
	 * Sets the records
	 *
	 * @param \Doctrine\Common\Collections\Collection<\Cundd\TimeOverview\Domain\Model\Record> $records
	 * @return void
	 */
	public function setRecords(\Doctrine\Common\Collections\ArrayCollection $records) {
		$this->records = $records;
	}

}
?>