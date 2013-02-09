<?php
namespace Cundd\TimeOverview\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Cundd.TimeOverview".    *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Cundd\TimeOverview\Domain\Model\SpecialRecord as SpecialRecord;
use Iresults\Core\DateTime as DateTime;

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
	 * @param string $startDate
	 * @return void
	 */
	public function newAction($startDate = NULL) {
		$startDate = new DateTime($startDate);
		$newRecord = new SpecialRecord();
		$newRecord->setStart($startDate);
		$this->view->assign('newSpecialRecord', $newRecord);
	}

	public function initializeCreateAction() {
		\Iresults\Core\Iresults::forceDebug();
		\Iresults\Core\Iresults::pd($this->arguments['newSpecialRecord']);

		\Iresults\Core\Iresults::pd($this->arguments['newSpecialRecord']->getPropertyMappingConfiguration());

		$this->arguments['newSpecialRecord']
			->getPropertyMappingConfiguration()
			->forProperty('start')
			->setTypeConverterOption('TYPO3\Flow\Property\TypeConverter\DateTimeConverter', \TYPO3\Flow\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'Y-m-d H:i');

		$this->arguments['newSpecialRecord']
			->getPropertyMappingConfiguration()
			->forProperty('end')
			->setTypeConverterOption('TYPO3\Flow\Property\TypeConverter\DateTimeConverter', \TYPO3\Flow\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'Y-m-d H:i');

		// $this->arguments['newSpecialRecord']
		// 	->getPropertyMappingConfiguration()
		// 	->forProperty('startDate')
		// 	->setTypeConverterOption('TYPO3\Flow\Property\TypeConverter\DateTimeConverter', \TYPO3\Flow\Property\TypeConverter\DateTimeConverter::CONFIGURATION_DATE_FORMAT, 'Y-m-d H:i');

        // $commentConfiguration = $this->arguments['comment']->getPropertyMappingConfiguration();
        // $commentConfiguration->allowAllProperties();
        // $commentConfiguration
        //         ->setTypeConverterOption(
        //         'TYPO3\Flow\Property\TypeConverter\PersistentObjectConverter',
        //         \TYPO3\Flow\Property\TypeConverter\PersistentObjectConverter::CONFIGURATION_CREATION_ALLOWED,
        //         TRUE
        // );
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