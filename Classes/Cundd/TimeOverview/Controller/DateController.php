<?php
namespace Cundd\TimeOverview\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Cundd.TimeOverview".    *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

use TYPO3\Flow\Mvc\Controller\ActionController;
use \Cundd\TimeOverview\Domain\Model\Date;

/**
 * Date controller for the Cundd.TimeOverview package 
 *
 * @Flow\Scope("singleton")
 */
class DateController extends ActionController {

	/**
	 * @Flow\Inject
	 * @var \Cundd\TimeOverview\Domain\Repository\DateRepository
	 */
	protected $dateRepository;

	/**
	 * Shows a list of dates
	 *
	 * @return void
	 */
	public function indexAction() {
		$this->view->assign('dates', $this->dateRepository->findAll());
	}

	/**
	 * Shows a single date object
	 *
	 * @param \Cundd\TimeOverview\Domain\Model\Date $date The date to show
	 * @return void
	 */
	public function showAction(Date $date) {
		$this->view->assign('date', $date);
	}

	/**
	 * Shows a form for creating a new date object
	 *
	 * @return void
	 */
	public function newAction() {
	}

	/**
	 * Adds the given new date object to the date repository
	 *
	 * @param \Cundd\TimeOverview\Domain\Model\Date $newDate A new date to add
	 * @return void
	 */
	public function createAction(Date $newDate) {
		$this->dateRepository->add($newDate);
		$this->addFlashMessage('Created a new date.');
		$this->redirect('index');
	}

	/**
	 * Shows a form for editing an existing date object
	 *
	 * @param \Cundd\TimeOverview\Domain\Model\Date $date The date to edit
	 * @return void
	 */
	public function editAction(Date $date) {
		$this->view->assign('date', $date);
	}

	/**
	 * Updates the given date object
	 *
	 * @param \Cundd\TimeOverview\Domain\Model\Date $date The date to update
	 * @return void
	 */
	public function updateAction(Date $date) {
		$this->dateRepository->update($date);
		$this->addFlashMessage('Updated the date.');
		$this->redirect('index');
	}

	/**
	 * Removes the given date object from the date repository
	 *
	 * @param \Cundd\TimeOverview\Domain\Model\Date $date The date to delete
	 * @return void
	 */
	public function deleteAction(Date $date) {
		$this->dateRepository->remove($date);
		$this->addFlashMessage('Deleted a date.');
		$this->redirect('index');
	}

}

?>