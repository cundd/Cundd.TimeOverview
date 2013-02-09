<?php
namespace Cundd\TimeOverview\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Cundd.TimeOverview".    *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;
use Cundd\TimeOverview\Domain\Model\Record as Record;
use Cundd\TimeOverview\Domain\Model\SpecialRecord as SpecialRecord;

/**
 * A Date
 */
class Date {

	/**
	 * The date
	 * @var \DateTime
	 */
	protected $date;

	/**
	 * The records
	 * @var \SplObjectStorage<\Cundd\TimeOverview\Domain\Model\Record>
	 */
	protected $records;

	/**
	 * The special records
	 * @var \SplObjectStorage<\Cundd\TimeOverview\Domain\Model\SpecialRecord>
	 */
	protected $specialRecords;

	/**
	 * The hours per working day (should)
	 * @var float
	 * @Flow\Transient
	 */
	protected $hoursPerWorkingDay = 0.0;

	/**
	 * The seconds worked (is)
	 * @var float
	 * @Flow\Transient
	 */
	protected $workedSeconds = NULL;

	/**
	 * The total seconds of special records
	 * @var float
	 * @Flow\Transient
	 */
	protected $specialRecordsTotalSeconds = NULL;



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
		$this->records = new \Doctrine\Common\Collections\ArrayCollection();
		$this->specialRecords = new \Doctrine\Common\Collections\ArrayCollection();
	}

	/**
	 * Get the Date's date
	 *
	 * @return \DateTime The Date's date
	 */
	public function getDate() {
		$this->workedSeconds = NULL;
		return $this->date;
	}

	/**
	 * Sets this Date's date
	 *
	 * @param \DateTime $date The Date's date
	 * @return void
	 */
	public function setDate($date) {
		$this->date = $date;
	}

	/**
	 * Adds a Record
	 *
	 * @param \Cundd\TimeOverview\Domain\Model\Record $record
	 * @return void
	 */
	public function addRecord(Record $record) {
		$this->workedSeconds = NULL;
		$this->records->add($record);
	}

	/**
	 * Removes a Record
	 *
	 * @param \Cundd\TimeOverview\Domain\Model\Record $recordToRemove The Record to be removed
	 * @return void
	 */
	public function removeRecord(Record $recordToRemove) {
		$this->workedSeconds = NULL;
		$this->records->removeElement($recordToRemove);
	}

	/**
	 * Get the Date's records
	 *
	 * @return \SplObjectStorage<\Cundd\TimeOverview\Domain\Model\Record> The Date's records
	 */
	public function getRecords() {
		return $this->records;
	}

	/**
	 * Sets this Date's records
	 *
	 * @param \SplObjectStorage<\Cundd\TimeOverview\Domain\Model\Record> $records The Date's records
	 * @return void
	 */
	public function setRecords(\SplObjectStorage $records) {
		$this->workedSeconds = NULL;
		$this->records = $records;
	}

	/**
	 * Adds a Record
	 *
	 * @param \Cundd\TimeOverview\Domain\Model\Record $record
	 * @return void
	 */
	public function addSpecialRecord(SpecialRecord $record) {
		$this->specialRecords->add($record);
	}

	/**
	 * Removes a Record
	 *
	 * @param \Cundd\TimeOverview\Domain\Model\Record $recordToRemove The Record to be removed
	 * @return void
	 */
	public function removeSpecialRecords(SpecialRecord $recordToRemove) {
		$this->specialRecords->removeElement($recordToRemove);
	}

	/**
	 * Get the Date's special records
	 *
	 * @return \SplObjectStorage<\Cundd\TimeOverview\Domain\Model\SpecialRecord> The Date's special records
	 */
	public function getSpecialRecords() {
		return $this->specialRecords;
	}

	/**
	 * Sets this Date's special records
	 *
	 * @param \SplObjectStorage<\Cundd\TimeOverview\Domain\Model\SpecialRecord> $specialRecords The Date's special records
	 * @return void
	 */
	public function setSpecialRecords(\SplObjectStorage $specialRecords) {
		$this->specialRecords = $specialRecords;
	}

	/**
	 * Returns the time that should be.
	 * @return integer
	 */
	public function getShouldInSeconds() {
		return $this->getSecondsPerWorkingDay() - $this->getSpecialRecordsTotalInSeconds();
	}

	/**
	 * Returns the time that should be.
	 * @return float
	 */
	public function getShouldInHours() {
		return $this->getShouldInSeconds() / 60 / 60;
	}

	/**
	 * Returns the time that is worked.
	 * @return integer
	 */
	public function getIsInSeconds() {
		return $this->getWorkedSeconds();
	}

	/**
	 * Returns the time that is worked.
	 * @return float
	 */
	public function getIsInHours() {
		return $this->getWorkedHours();
	}

	/**
	 * Returns the hours per working day
	 *
	 * @return float
	 */
	public function getHoursPerWorkingDay() {
		return $this->hoursPerWorkingDay;
	}

	/**
	 * Set the hours per working day
	 *
	 * @param float $hoursPerWorkingDay
	 */
	public function setHoursPerWorkingDay($hoursPerWorkingDay) {
		$this->hoursPerWorkingDay = $hoursPerWorkingDay;
	}

	/**
	 * Returns the hours per working day
	 *
	 * @return float
	 */
	public function getSecondsPerWorkingDay() {
		return $this->hoursPerWorkingDay * 60 * 60;
	}

	/**
	 * Returns the seconds worked this day
	 *
	 * @return integer
	 */
	public function getWorkedSeconds() {
		if ($this->workedSeconds === NULL) {
			$records = $this->getRecords();
			foreach ($records as $record) {
				$this->workedSeconds += $record->getDurationInSeconds();
			}
		}
		return $this->workedSeconds;
	}

	/**
	 * Returns the hours worked this day
	 *
	 * @return float
	 */
	public function getWorkedHours() {
		return $this->getWorkedSeconds() / 60 / 60;
	}

	/**
	 * Returns the total seconds of special records
	 *
	 * @return integer
	 */
	public function getSpecialRecordsTotalInSeconds() {
		if ($this->specialRecordsTotalSeconds === NULL) {
			$records = $this->getSpecialRecords();
			foreach ($records as $record) {
				$this->specialRecordsTotalSeconds += $record->getDurationInSeconds();
			}
		}
		return $this->specialRecordsTotalSeconds;
	}

	/**
	 * Returns the total hours of special records
	 *
	 * @return integer
	 */
	public function getSpecialRecordsTotalInHours() {
		return $this->getSpecialRecordsTotalInSeconds() / 60 / 60;
	}

	/**
	 * Returns the difference between the actual worked seconds and the seconds
	 * that should be (is - should).
	 *
	 * @return integer Difference in seconds
	 */
	public function getDifferenceInSeconds() {
		return $this->getWorkedSeconds() - $this->getShouldInSeconds();
	}

	/**
	 * Returns the difference between the hours per working day and the worked
	 * hours (should - is).
	 *
	 * @return float Difference in hours
	 */
	public function getDifferenceInHours() {
		return $this->getDifferenceInSeconds() / 60 / 60;
	}

	/**
	 * Returns the difference between the hours per working day and the worked
	 * hours (should - is).
	 *
	 * @return float Difference in percent
	 */
	public function getDifferenceInPercent() {
		if (!$this->getShouldInSeconds()) {
			return 100;
		}
		return $this->getWorkedSeconds() / $this->getSecondsPerWorkingDay() * 100;
	}

	/**
	 * Returns the difference between the hours per working day and the worked
	 * hours (should - is).
	 *
	 * @return string
	 */
	public function getDifferenceAsFormattedDateInterval() {
		$date1 = new \DateTime();
		$date2 = new \DateTime();
		$difference = $this->getDifferenceInSeconds();

		$date2->add(new \DateInterval('PT' . abs($difference) . 'S'));

		$duration = $date2->diff($date1);
		$output = '';
		if ($difference < 0) {
			$output .= '-';
		}
		return $output . $duration->format('%hh %Imin');
	}


}
?>