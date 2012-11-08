<?php
namespace Cundd\TimeOverview\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Cundd.TimeOverview".    *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;

/**
 * Standard controller for the Cundd.TimeOverview package
 *
 * @Flow\Scope("singleton")
 */
class PersonController extends \TYPO3\Flow\Mvc\Controller\ActionController {

	/**
	 * personRepository
	 *
	 * @Flow\Inject
	 * @var \Cundd\TimeOverview\Domain\Repository\PersonRepository
	 */
	protected $personRepository;

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$persons = $this->personRepository->findAll();
		$this->view->assign('persons', $persons);
	}

	/**
	 * action show
	 *
	 * @param \Cundd\TimeOverview\Domain\Model\Person $person
	 * @return void
	 */
	public function showAction(\Cundd\TimeOverview\Domain\Model\Person $person) {
		$this->view->assign('person', $person);
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
	 * @param \Cundd\TimeOverview\Domain\Model\Person $newPerson
	 * @return void
	 */
	public function createAction(\Cundd\TimeOverview\Domain\Model\Person $newPerson) {
		$this->personRepository->add($newPerson);
		$this->redirect('list');
	}

	/**
	 * action edit
	 *
	 * @param \Cundd\TimeOverview\Domain\Model\Person $person
	 * @return void
	 */
	public function editAction(\Cundd\TimeOverview\Domain\Model\Person $person) {
		$this->view->assign('person', $person);
	}

	/**
	 * action update
	 *
	 * @param \Cundd\TimeOverview\Domain\Model\Person $person
	 * @return void
	 */
	public function updateAction(\Cundd\TimeOverview\Domain\Model\Person $person) {
		$this->personRepository->update($person);
		$this->redirect('list');
	}

	/**
	 * action delete
	 *
	 * @param \Cundd\TimeOverview\Domain\Model\Person $person
	 * @return void
	 */
	public function deleteAction(\Cundd\TimeOverview\Domain\Model\Person $person) {
		$this->personRepository->remove($person);
		$this->redirect('list');
	}

}
?>