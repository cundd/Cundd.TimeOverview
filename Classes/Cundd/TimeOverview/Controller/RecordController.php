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


		// $records = $this->recordRepository->findAll();
		$records = $this->recordRepository->findByCalendarModeAndDate($calendarMode, $date);

		\Iresults::pd($records);

		$dates = $this->assignRecordsToDates($records);
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
	 * Assignes records to it's date.
	 *
	 * @param  \TYPO3\Flow\Persistence\QueryResultInterface $records The records
	 * @return array<\Cundd\TimeOverview\Domain\Model\Date>
	 */
	public function assignRecordsToDates($records) {
		$recordsArray = $records->toArray();
		#$this->dates
		foreach ($recordsArray as $record) {
			$currentDateRecord = NULL;
			$startDate = $record->getStart();
			$dateKey = $startDate->format('Y-m-d');

			if (isset($this->dates[$dateKey])) {
				$currentDateRecord = $this->dates[$dateKey];
			} else {
				$startDateString = $startDate->format('Y-m-d') . ' 00:00:00 +0000';
				#$dateObjectDate = \new DateTime($startDateString);
				$currentDateRecord = new Date();
				$currentDateRecord->setDate(new \DateTime($startDateString));
				$currentDateRecord->setHoursPerWorkingDay($this->settings['hoursPerWorkingDay']);
				$this->dates[$dateKey] = $currentDateRecord;
			}

			$currentDateRecord->addRecord($record);
		}
		return $this->dates;
	}

	/**
	 * action show
	 *
	 * @return void
	 */
	public function importAction() {
		$timeRecords = array();

		$importFile = \Iresults::getBasePath() . 'Data/Time Tracker Data.csv';
		$dataGrid = new Iresults\Model\DataGrid();
		$dataGrid->initWithContentsOfCSVFile($importFile, ';');

		// Convert all rows
		$dataRowsCount = $dataGrid->getRowCount();

		$maxRowsCount = 30;
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
			$timeRecords[] = $timeRecord;
			$this->recordRepository->add($timeRecord);
		} while ($i < $dataRowsCount);

		$this->redirect('list');
		// $this->view->assign('records', $timeRecords);
		// $this->view->assign('dataGrid', $dataGrid);
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