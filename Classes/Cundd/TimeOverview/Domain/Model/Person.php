<?php
namespace Cundd\TimeOverview\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Cundd.TimeOverview".    *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * A person
 *
 * @Flow\Entity
 */
class Person {

	/**
	 * Time records
	 *
	 * @var \Doctrine\Common\Collections\Collection<\Cundd\TimeOverview\Domain\Model\Record>
	 * @ORM\OneToMany(mappedBy="person")
	 */
	protected $records;

	/**
	 * Special time records
	 *
	 * @var \Doctrine\Common\Collections\Collection<\Cundd\TimeOverview\Domain\Model\SpecialRecord>
	 * @ORM\ManyToMany(inversedBy="person")
	 */
	protected $specialRecords;

	/**
	 * Projects
	 *
	 * @var \Doctrine\Common\Collections\Collection<\Cundd\TimeOverview\Domain\Model\Project>
	 * @ORM\ManyToMany(inversedBy="persons")
	 */
	protected $projects;

	/**
	 * Username
	 *
	 * @var string
	 * @Flow\Validate(type="StringLength", options={ "minimum"=1, "maximum"=100 })
	 */
	protected $username;

	/**
	 * Password
	 *
	 * @var string
	 */
	protected $password;

	/**
	 * First name
	 *
	 * @var string
	 */
	protected $firstName;

	/**
	 * Last name
	 *
	 * @var string
	 */
	protected $lastName;

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

		$this->projects = new \Doctrine\Common\Collections\ArrayCollection();
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

	/**
	 * Adds a Project
	 *
	 * @param \Cundd\TimeOverview\Domain\Model\Project $project
	 * @return void
	 */
	public function addProject(Project $project) {
		$this->projects->attach($project);
	}

	/**
	 * Removes a Project
	 *
	 * @param \Cundd\TimeOverview\Domain\Model\Project $projectToRemove The Project to be removed
	 * @return void
	 */
	public function removeProject(Project $projectToRemove) {
		$this->projects->removeElement($projectToRemove);
	}

	/**
	 * Returns the projects
	 *
	 * @return \Doctrine\Common\Collections\Collection<\Cundd\TimeOverview\Domain\Model\Project> $projects
	 */
	public function getProjects() {
		return $this->projects;
	}

	/**
	 * Sets the projects
	 *
	 * @param \Doctrine\Common\Collections\Collection<\Cundd\TimeOverview\Domain\Model\Project> $projects
	 * @return void
	 */
	public function setProjects(\Doctrine\Common\Collections\ArrayCollection $projects) {
		$this->projects = $projects;
	}

	/**
	 * Returns the username
	 *
	 * @return string $username
	 */
	public function getUsername() {
		return $this->username;
	}

	/**
	 * Sets the username
	 *
	 * @param string $username
	 * @return void
	 */
	public function setUsername($username) {
		$this->username = $username;
	}

	/**
	 * Returns the password
	 *
	 * @return string $password
	 */
	public function getPassword() {
		return $this->password;
	}

	/**
	 * Sets the password
	 *
	 * @param string $password
	 * @return void
	 */
	public function setPassword($password) {
		$this->password = $password;
	}

	/**
	 * Returns the firstName
	 *
	 * @return string $firstName
	 */
	public function getFirstName() {
		return $this->firstName;
	}

	/**
	 * Sets the firstName
	 *
	 * @param string $firstName
	 * @return void
	 */
	public function setFirstName($firstName) {
		$this->firstName = $firstName;
	}

	/**
	 * Returns the lastName
	 *
	 * @return string $lastName
	 */
	public function getLastName() {
		return $this->lastName;
	}

	/**
	 * Sets the lastName
	 *
	 * @param string $lastName
	 * @return void
	 */
	public function setLastName($lastName) {
		$this->lastName = $lastName;
	}

}
?>