<?php
namespace Cundd\TimeOverview\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Cundd.TimeOverview".    *
 *                                                                        *
 *                                                                        */
ini_set('display_errors', TRUE);
use TYPO3\Flow\Annotations as Flow;
use Cundd\TimeOverview\Domain\Model\Date as Date;
use Cundd\TimeOverview\Domain\Model\Record as Record;
use Cundd\TimeOverview\Domain\Repository\RecordRepository as RecordRepository;
use Iresults\Core as Iresults;
use Iresults\Core\Nil;

/**
 * Standard controller for the Cundd.TimeOverview package
 *
 * @Flow\Scope("singleton")
 */
class RecordController extends \TYPO3\Flow\Mvc\Controller\ActionController {

	/**
	 * Property mapper
	 *
	 * @var \TYPO3\Flow\Property\PropertyMapper
	 * @Flow\Inject
	 */
	protected $propertyMapper;

	/**
	 * recordRepository
	 *
	 * @Flow\Inject
	 * @var \Cundd\TimeOverview\Domain\Repository\RecordRepository
	 */
	protected $recordRepository;

	/**
	 * Special record repository
	 *
	 * @Flow\Inject
	 * @var \Cundd\TimeOverview\Domain\Repository\SpecialRecordRepository
	 */
	protected $specialRecordRepository;

	/**
	 * Project repository
	 *
	 * @Flow\Inject
	 * @var \Cundd\TimeOverview\Domain\Repository\ProjectRepository
	 */
	protected $projectRepository;

	/**
	 * Task repository
	 *
	 * @Flow\Inject
	 * @var \Cundd\TimeOverview\Domain\Repository\TaskRepository
	 */
	protected $taskRepository;

	/**
	 * Added projects that are not saved in the repository
	 *
	 * @var array<\Cundd\TimeOverview\Domain\Model\Project>
	 */
	protected $addedProjects = array();

	/**
	 * Added tasks that are not saved in the repository
	 *
	 * @var array<\Cundd\TimeOverview\Domain\Model\Task>
	 */
	protected $addedTasks = array();

	/**
	 * The array of date objects with their records.
	 *
	 * @var array<\Cundd\TimeOverview\Domain\Model\Date>
	 */
	protected $dates = array();

	/**
	 * The target total hours
	 * @var float
	 */
	protected $totalTargetHours = 0.0;

	/**
	 * The actual total hours
	 * @var float
	 */
	protected $totalActualHours = 0.0;

	/**
	 * The total difference between target and actual hours
	 * @var float
	 */
	protected $totalDifferenceHours = 0.0;

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$records = $this->recordRepository->findAll();
		$this->view->assign('records', $records);
	}

	/**
	 * Calendar list
	 *
	 * @param string 	$calendarMode 	What to display
	 * @param string 	$date 			A date in the period
	 * @return 	void
	 */
	public function calendarAction($calendarMode = RecordRepository::CALENDAR_MODE_YEAR, $date = NULL) {
		$date = new \DateTime($date);

		$this->prepareDatesForCalendarModeAndDate($calendarMode, $date);
		// $records = $this->recordRepository->findAll();
		$records = $this->recordRepository->findByCalendarModeAndDate($calendarMode, $date);
		$specialRecords = $this->specialRecordRepository->findByCalendarModeAndDate($calendarMode, $date);

		\Iresults::pd($records);

		$dates = $this->assignRecordsToDates($records);
		$dates = $this->assignRecordsToDates($specialRecords);
		$this->view->assign('dates', $dates);
		$this->view->assign('records', $records);


		$calendarModes = array(
			'CALENDAR_MODE_YEAR' 	=> 'Year',
			'CALENDAR_MODE_MONTH' 	=> 'Month',
			'CALENDAR_MODE_WEEK' 	=> 'Week',
			'CALENDAR_MODE_DAY' 	=> 'Day',
		);
		$this->view->assign('date', $date->format('Y-m-d'));
		$this->view->assign('calendarMode', $calendarMode);
		$this->view->assign('calendarModes', $calendarModes);




		\Iresults::pd($this->settings['hoursPerWorkingDay']);
	}

	/**
	 * Calculate and assign the total values
	 * @return void
	 */
	public function collectTotals() {
		\Iresults::pd('totalTargetHoursLocal: ' . $this->totalTargetHours);
		\Iresults::pd('totalActualHoursLocal: ' . $this->totalActualHours);

		$this->view->assign('totalTargetHours', $this->totalTargetHours);
		$this->view->assign('totalActualHours', $this->totalActualHours);
		$this->view->assign('totalDifferenceHours', $this->totalDifferenceHours);

		$this->totalActualHours = $this->totalActualHours ? $this->totalActualHours : 1;
		$totalDifferenceInPercent = $this->totalTargetHours / $this->totalActualHours * 100;
		$this->view->assign('totalDifferenceInPercent', $totalDifferenceInPercent);
		$this->view->assign('totalDifferenceFormatted', $this->getTotalDifferenceFormatted());

	}

	/**
	 * Returns the total difference
	 * @return string
	 */
	public function getTotalDifferenceFormatted() {
		$date1 = new \DateTime();
		$date2 = new \DateTime();
		$difference = ($this->totalActualHours - $this->totalTargetHours) * 60 * 60;

		$date2->add(new \DateInterval('PT' . abs($difference) . 'S'));

		$duration = $date2->diff($date1);
		$output = '';
		if ($difference < 0) {
			$output .= '-';
		}
		return $output . $duration->format('%hh %Imin');
	}


	/**
	 * Creates and stores a Date object for each date of the given calender mode
	 * and date.
	 *
	 * @param  string 		$calendarMode The calendar mode to display records of a single day, week, month or year
	 * @param  \DateTime 	$date         A date that lies within the calendar mode period
	 * @return array<\Cundd\TimeOverview\Domain\Model\Date>	Returns the prepared dates
	 */
	public function prepareDatesForCalendarModeAndDate($calendarMode, $date) {
		list($start, $end) = $this->recordRepository->getStartAndEndDateForCalenderModeAndDate($calendarMode, $date);
		$now = time();
		$tempDates = array();
		$oneDayInSeconds = 60 * 60 * 24;
		$endTimeStamp = $end->getTimestamp();
		$currentWorkingDate = NULL;
		$hoursPerWorkingDay = $this->settings['hoursPerWorkingDay'];
		$currentWorkingDateTime = NULL;
		$currentWorkingDateString = '';
		$currentWorkingTimestamp = $start->getTimestamp();

		do {
			$currentWorkingDateString = date('Y-m-d', $currentWorkingTimestamp);
			$currentWorkingDateTime = new \DateTime($currentWorkingDateString . ' 00:00:00 +0000');

			$currentWorkingDate = new Date();
			$currentWorkingDate->setDate($currentWorkingDateTime);

			$day = $currentWorkingDateTime->format('D');
			if ($day !== 'Sat' && $day !== 'Sun') {
				$currentWorkingDate->setHoursPerWorkingDay($hoursPerWorkingDay);
			}

			$tempDates[$currentWorkingDateString] = $currentWorkingDate;

			// $v++;
			// \Iresults::pd($currentWorkingTimestamp . ' vs. ' . $now . ' = now ' . ($now - $currentWorkingTimestamp));

			$currentWorkingTimestamp += $oneDayInSeconds;
		} while ($currentWorkingTimestamp < $now && $currentWorkingTimestamp < $endTimeStamp);

		$this->dates = $tempDates;
		return $this->dates;

		// $this->dates[$dateKey] = $currentDateRecord;
	}

	/**
	 * Assignes records to it's date.
	 *
	 * @param  \TYPO3\Flow\Persistence\QueryResultInterface $records 	The records
	 * @param string 										$recordType The record type of the given records
	 * @return array<\Cundd\TimeOverview\Domain\Model\Date>
	 */
	public function assignRecordsToDates($records, $recordType = NULL) {
		$recordsArray = $records->toArray();
		$totalTargetHoursLocal = $this->totalTargetHours;
		$totalActualHoursLocal = $this->totalActualHours;
		$totalDifferenceHoursLocal = $this->totalDifferenceHours;
		$hoursPerWorkingDay = $this->settings['hoursPerWorkingDay'];

		foreach ($recordsArray as $record) {
			$currentDateRecord = NULL;
			$startDate = $record->getStart();
			$dateKey = $startDate->format('Y-m-d');

			if (isset($this->dates[$dateKey])) {
				$currentDateRecord = $this->dates[$dateKey];
			} else {
				throw new \UnexpectedValueException('The Date object for date ' . $dateKey . ' doesn\'t appear to have been created in prepareDatesForCalendarModeAndDate()', 1353757274);
				// $startDateString = $startDate->format('Y-m-d') . ' 00:00:00 +0000';
				// $startDateObject = new \DateTime($startDateString);
				// $currentDateRecord = new Date();
				// $currentDateRecord->setDate($startDateObject);

				// $day = date('D', $startDateObject->getTimestamp());
				// if ($day !== 'Sat' && $day !== 'Sun') {
				// 	$currentDateRecord->setHoursPerWorkingDay($hoursPerWorkingDay);
				// }
				// $this->dates[$dateKey] = $currentDateRecord;
			}

			//RECORD_TYPE_STANDARD
			$currentRecordType = NULL;
			if ($recordType) {
				$currentRecordType = $recordType;
			} else if ($record instanceof Record) {
				$currentRecordType = Record::RECORD_TYPE_STANDARD;
			} else if ($record instanceof SpecialRecord) {
				$currentRecordType = Record::RECORD_TYPE_SPECIAL;
			}

			// Add it as standard or special record
			if ($currentRecordType === Record::RECORD_TYPE_STANDARD) {
				$currentDateRecord->addRecord($record);

				// Calculate the time
				$totalTargetHoursLocal += $hoursPerWorkingDay;
				$totalActualHoursLocal += $currentDateRecord->getWorkedHours();
				$totalDifferenceHoursLocal += $currentDateRecord->getDifferenceInHours();
			} else if ($currentRecordType === Record::RECORD_TYPE_SPECIAL) {
				$currentDateRecord->addSpecialRecord($record);
				$totalTargetHoursLocal -= $record->getDurationInHourse();
			}
		}

		$this->totalTargetHours = $totalTargetHoursLocal;
		$this->totalActualHours = $totalActualHoursLocal;
		// $this->totalDifferenceHours = $totalDifferenceHoursLocal;
		return $this->dates;
	}

	/**
	 * Import action
	 *
	 * @param string $importFile The file to import
	 * @return void
	 */
	public function importAction($importFile) {
		$this->importFromFile($importFile);
		$this->redirect('list');
	}

	/**
	 * Import records from the given file
	 *
	 * @param string $importFile The file to import
	 * @return void
	 */
	public function importFromFile($importFile) {
		$timeRecords = array();
		$timeRecord = NULL;

		// $importFile = \Iresults::getBasePath() . 'Data/Time Tracker Data.csv';
		$dataGrid = new Iresults\Model\DataGrid();
		$dataGrid->initWithContentsOfCSVFile($importFile, ';');

		// Convert all rows
		$dataRowsCount = $dataGrid->getRowCount();

		// $maxRowsCount = 30;
		$maxRowsCount = PHP_INT_MAX;
		$dataRowsCount = $dataRowsCount < $maxRowsCount ? $dataRowsCount : $maxRowsCount;
		$i = 1; // Skip the first row with the labels
		do {
			$task = NULL;
			$projectTitle = '';
			$recordDictionary = $dataGrid->getRowAtIndexAsDictionary($i);

			$preparedDictionary = array();
			foreach ($recordDictionary as $property => $value) {
				$property = lcfirst($property);
				switch ($property) {
					case 'project':
						$projectTitle = $value;
						// $preparedDictionary[$property] = $value;
						break;

					case 'duration':
					case 'date':
						break;

					case 'task':
						$task = $this->getTaskWithTitleForProjectWithTitle($value, $projectTitle);
						break;

					case 'start':
					case 'end':
						$value = new Iresults\DateTime($value);
						$value = $value->getRaw();
						$preparedDictionary[$property] = $value;
						break;

					default:
						$preparedDictionary[$property] = $value;
						break;
				}
			}
			$timeRecord = $this->propertyMapper->convert($preparedDictionary, 'Cundd\TimeOverview\Domain\Model\Record');

			if (!Nil::nil($task)) {
				$timeRecord->setTask($task);
			}

			$i++;

			// Check if the record already exists
			if (!$this->recordRepository->hasRecord($timeRecord)) {
				$timeRecords[] = $timeRecord;
				$this->recordRepository->add($timeRecord);
			}
		} while ($i < $dataRowsCount);
		return $timeRecords;
	}

	/**
	 * Returns the task with the given title in a project with the given project title.
	 *
	 * @param  string $taskTitle 						The task's title
	 * @param  string $projectTitle 					The project's title
	 * @return \Cundd\TimeOverview\Domain\Model\Task
	 */
	public function getTaskWithTitleForProjectWithTitle($taskTitle, $projectTitle) {
		$task = NULL;
		$project = $this->getProjectWithTitle($projectTitle);
		$task = $project->getTaskWithTitle($taskTitle);

		if (Nil::nil($task)) {
			$task = new \Cundd\TimeOverview\Domain\Model\Task();
			$task->setTitle($taskTitle);
			$task->setDescription('Description: ' . $taskTitle);
			$project->addTask($task);
		}
		return $task;
	}

	/**
	 * Returns the project with the given title, or creates a new project with
	 * that title.
	 *
	 * @param  string $title 								The title
	 * @return \Cundd\TimeOverview\Domain\Model\Project
	 */
	public function getProjectWithTitle($title) {
		$project = $this->projectRepository->findOneByTitle($title);
		if (!$project && isset($this->addedProjects[$title])) {
			$project = $this->addedProjects[$title];
		}

		if (!$project) {
			$project = new \Cundd\TimeOverview\Domain\Model\Project();
			$project->setTitle($title);
			$project->setDescription('Description: ' . $title);
			$this->projectRepository->add($project);
			$this->addedProjects[$title] = $project;
		}
		return $project;
	}

	/**
	 * action show
	 *
	 * @param \Cundd\TimeOverview\Domain\Model\Record $record
	 * @return void
	 */
	public function showAction(Record $record) {
		$this->view->assign('record', $record);
	}

	/**
	 * action new
	 *
	 * @return void
	 */
	public function newAction() {
	}

	/**
	 * action create
	 *
	 * @param \Cundd\TimeOverview\Domain\Model\Record $newRecord
	 * @return void
	 */
	public function createAction(Record $newRecord) {
		$this->recordRepository->add($newRecord);
		$this->flashMessageContainer->add('Your new Record was created.');
		$this->redirect('list');
	}

	/**
	 * action edit
	 *
	 * @param \Cundd\TimeOverview\Domain\Model\Record $record
	 * @return void
	 */
	public function editAction(Record $record) {
		$this->view->assign('record', $record);
	}

	/**
	 * action update
	 *
	 * @param \Cundd\TimeOverview\Domain\Model\Record $record
	 * @return void
	 */
	public function updateAction(Record $record) {
		$this->recordRepository->update($record);
		$this->flashMessageContainer->add('Your Record was updated.');
		$this->redirect('list');
	}

	/**
	 * action delete
	 *
	 * @param \Cundd\TimeOverview\Domain\Model\Record $record
	 * @return void
	 */
	public function deleteAction(Record $record) {
		$this->recordRepository->remove($record);
		$this->flashMessageContainer->add('Your Record was removed.');
		$this->redirect('list');
	}

}
?>