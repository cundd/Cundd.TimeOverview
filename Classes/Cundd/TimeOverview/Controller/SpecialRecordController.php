<?php
namespace Cundd\TimeOverview\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Cundd.TimeOverview".    *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Cundd\TimeOverview\Domain\Model\SpecialRecord as SpecialRecord;
use Cundd\TimeOverview\Domain\Model\SpecialRecord as Record;
use Iresults\Core\DateTime as DateTime;

ini_set('display_errors', TRUE);

/**
 * Standard controller for the Cundd.TimeOverview package
 *
 * @Flow\Scope("singleton")
 */
class SpecialRecordController extends AbstractRecordController {

	/**
	 * specialRecordRepository
	 *
	 * @var \Cundd\TimeOverview\Domain\Repository\SpecialRecordRepository
	 * @Flow\Inject
	 */
	protected $specialRecordRepository;

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$specialRecords = $this->specialRecordRepository->findAll();
		$this->view->assign('specialRecords', $specialRecords);
	}

	/**
	 * action show
	 *
	 * @param \Cundd\TimeOverview\Domain\Model\SpecialRecord $specialRecord
	 * @return void
	 */
	public function showAction(\Cundd\TimeOverview\Domain\Model\SpecialRecord $specialRecord) {
		$this->view->assign('specialRecord', $specialRecord);
	}

	/**
	 * action new
	 *
	 * @param string $startDate
	 * @return void
	 */
	public function newAction($startDate = NULL) {
		$startDate = new DateTime($startDate);
		$newRecord = new SpecialRecord();
		$newRecord->setStart($startDate);
		$newRecord->setEnd($startDate->dateByAddingTimeInterval(60 * 60 * 8));
		$this->view->assign('newSpecialRecord', $newRecord);
	}

	/**
	 * action create
	 *
	 * @param \Cundd\TimeOverview\Domain\Model\SpecialRecord $newSpecialRecord
	 * @return void
	 */
	public function createAction(\Cundd\TimeOverview\Domain\Model\SpecialRecord $newSpecialRecord) {
		$this->specialRecordRepository->add($newSpecialRecord);

		$message = 'Your new SpecialRecord was created.';
		$this->flashMessageContainer->addMessage(new \TYPO3\Flow\Error\Message($message, \TYPO3\Flow\Error\Message::SEVERITY_OK));
		$this->redirect('list');
	}

	/**
	 * action edit
	 *
	 * @param \Cundd\TimeOverview\Domain\Model\SpecialRecord $specialRecord
	 * @return void
	 */
	public function editAction(\Cundd\TimeOverview\Domain\Model\SpecialRecord $specialRecord) {
		$this->view->assign('specialRecord', $specialRecord);
	}

	/**
	 * action update
	 *
	 * @param \Cundd\TimeOverview\Domain\Model\SpecialRecord $specialRecord
	 * @return void
	 */
	public function updateAction(\Cundd\TimeOverview\Domain\Model\SpecialRecord $specialRecord) {
		$this->specialRecordRepository->update($specialRecord);
		$message = 'Your SpecialRecord was updated.';
		$this->flashMessageContainer->addMessage(new \TYPO3\Flow\Error\Message($message, \TYPO3\Flow\Error\Message::SEVERITY_OK));
		$this->redirect('list');
	}

	/**
	 * action delete
	 *
	 * @param \Cundd\TimeOverview\Domain\Model\SpecialRecord $specialRecord
	 * @return void
	 */
	public function deleteAction(\Cundd\TimeOverview\Domain\Model\SpecialRecord $specialRecord) {
		$this->specialRecordRepository->remove($specialRecord);
		$message = 'Your SpecialRecord was removed.';
		$this->flashMessageContainer->addMessage(new \TYPO3\Flow\Error\Message($message, \TYPO3\Flow\Error\Message::SEVERITY_OK));
		$this->redirect('list');
	}

	/**
	 * Create multiple records at once
	 *
	 * @return  void
	 */
	public function multipleAction() {
		$i = 0;
		$numberOfRecords = 5;
		$records = array();

		$startDate = new DateTime();
		$endDate = $startDate->dateByAddingTimeInterval(60 * 60 * 8);

		while ($i++ < $numberOfRecords) {
			$tempRecord = new SpecialRecord();

			$startDate = $startDate->dateByAddingTimeInterval(60 * 60 * 24);
			$endDate = $startDate->dateByAddingTimeInterval(60 * 60 * 8);

			$tempRecord->setTitle('New record number ' . $i);
			$tempRecord->setStart($startDate);
			$tempRecord->setEnd($endDate);

			$records[] = $tempRecord;
		}
		$this->view->assign('records', $records);
	}

	/**
	 * Create multiple records at once
	 *
	 * @param array<\Cundd\TimeOverview\Domain\Model\Record> $records
	 * @return void
	 */
	public function createMultipleAction($records) {
		\Iresults\Core\Iresults::forceDebug();
		foreach ($records as $newRecord) {
			\Iresults\Core\Iresults::pd($newRecord);
			if ($newRecord) {
				$this->specialRecordRepository->add($newRecord);
			}
		}

		$message = 'Your new SpecialRecord was created.';
		$this->flashMessageContainer->addMessage(new \TYPO3\Flow\Error\Message($message, \TYPO3\Flow\Error\Message::SEVERITY_OK));

		$this->redirect('list');
	}

}
?>