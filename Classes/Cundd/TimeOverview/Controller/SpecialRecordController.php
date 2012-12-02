<?php
namespace Cundd\TimeOverview\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Cundd.TimeOverview".    *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use \Cundd\TimeOverview\Domain\Model\SpecialRecord as SpecialRecord;

ini_set('display_errors', TRUE);

/**
 * Standard controller for the Cundd.TimeOverview package
 *
 * @Flow\Scope("singleton")
 */
class SpecialRecordController extends \TYPO3\Flow\Mvc\Controller\ActionController {

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
	 * @return void
	 */
	public function newAction() {
	}

	/**
	 * action create
	 *
	 * @param \Cundd\TimeOverview\Domain\Model\SpecialRecord $newSpecialRecord
	 * @return void
	 */
	public function createAction(\Cundd\TimeOverview\Domain\Model\SpecialRecord $newSpecialRecord) {
		$this->specialRecordRepository->add($newSpecialRecord);
		$this->flashMessageContainer->add('Your new SpecialRecord was created.');
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
		$this->flashMessageContainer->add('Your SpecialRecord was updated.');
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
		$this->flashMessageContainer->add('Your SpecialRecord was removed.');
		$this->redirect('list');
	}

}
?>