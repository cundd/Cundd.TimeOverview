<?php
namespace Cundd\TimeOverview\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Cundd.TimeOverview".    *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;
use Iresults\Core\Nil;

/**
 * A project
 *
 * @Flow\Entity
 */
class Project {

	/**
	 * Tasks
	 *
	 * @var \Doctrine\Common\Collections\Collection<\Cundd\TimeOverview\Domain\Model\Task>
	 * @ORM\OneToMany(mappedBy="project",cascade={"persist"})
	 */
	protected $tasks;

	/**
	 * Persons
	 *
	 * @var \Doctrine\Common\Collections\Collection<\Cundd\TimeOverview\Domain\Model\Person>
	 * @ORM\ManyToMany(mappedBy="projects")
	 */
	protected $persons;

	/**
	 * Title
	 *
	 * @var string
	 * @Flow\Validate(type="StringLength", options={ "minimum"=1, "maximum"=100 })
	 * @Flow\Identity
	 */
	protected $title;

	/**
	 * Description
	 *
	 * @var string
	 */
	protected $description;

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
		$this->tasks = new \Doctrine\Common\Collections\ArrayCollection();

		$this->persons = new \Doctrine\Common\Collections\ArrayCollection();
	}

	/**
	 * Adds a Task
	 *
	 * @param \Cundd\TimeOverview\Domain\Model\Task $task
	 * @return void
	 */
	public function addTask(Task $task) {
		$task->setProject($this);
		$this->tasks->add($task);
	}

	/**
	 * Removes a Task
	 *
	 * @param \Cundd\TimeOverview\Domain\Model\Task $taskToRemove The Task to be removed
	 * @return void
	 */
	public function removeTask(Task $taskToRemove) {
		$this->tasks->removeElement($taskToRemove);
	}

	/**
	 * Returns the tasks
	 *
	 * @return \Doctrine\Common\Collections\Collection<\Cundd\TimeOverview\Domain\Model\Task> $tasks
	 */
	public function getTasks() {
		return $this->tasks;
	}

	/**
	 * Returns if the given task is one of the project's tasks
	 *
	 * @param \Cundd\TimeOverview\Domain\Model\Task $task
	 * @return boolean
	 */
	public function hasTask(Task $task) {
		return $this->tasks->contains($task);
	}

	/**
	 * Returns the task with the given title
	 *
	 * @param string $title
	 * @return boolean
	 */
	public function getTaskWithTitle($title) {
		foreach ($this->tasks as $task) {
			if ($task->getTitle() === $title) {
				return $task;
			}
		}
		return Nil::nil();
	}

	/**
	 * Returns if a task with the given name is one of the project's tasks
	 *
	 * @param string $title
	 * @return boolean
	 */
	public function hasTaskWithTitle($title) {
		return Nil::nil($this->getTaskWithTitle()) ? TRUE : FALSE;
	}

	/**
	 * Sets the tasks
	 *
	 * @param \Doctrine\Common\Collections\Collection<\Cundd\TimeOverview\Domain\Model\Task> $tasks
	 * @return void
	 */
	public function setTasks(\Doctrine\Common\Collections\ArrayCollection $tasks) {
		$this->tasks = $tasks;
	}

	/**
	 * Adds a Person
	 *
	 * @param \Cundd\TimeOverview\Domain\Model\Person $person
	 * @return void
	 */
	public function addPerson(Person $person) {
		$this->persons->add($person);
	}

	/**
	 * Removes a Person
	 *
	 * @param \Cundd\TimeOverview\Domain\Model\Person $personToRemove The Person to be removed
	 * @return void
	 */
	public function removePerson(Person $personToRemove) {
		$this->persons->removeElement($personToRemove);
	}

	/**
	 * Returns the persons
	 *
	 * @return \Doctrine\Common\Collections\Collection<\Cundd\TimeOverview\Domain\Model\Person> $persons
	 */
	public function getPersons() {
		return $this->persons;
	}

	/**
	 * Sets the persons
	 *
	 * @param \Doctrine\Common\Collections\Collection<\Cundd\TimeOverview\Domain\Model\Person> $persons
	 * @return void
	 */
	public function setPersons(\Doctrine\Common\Collections\ArrayCollection $persons) {
		$this->persons = $persons;
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

}
?>