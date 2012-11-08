<?php
namespace Cundd\TimeOverview\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Cundd.TimeOverview".    *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use \Cundd\TimeOverview\Domain\Model\Tasl as Task;

/**
 * Standard controller for the Cundd.TimeOverview package 
 *
 * @Flow\Scope("singleton")
 */
class TaskController extends \TYPO3\Flow\Mvc\Controller\ActionController {

	/**
	 * taskRepository
	 *
	 * @Flow\Inject
	 * @var \Cundd\TimeOverview\Domain\Repository\TaskRepository
	 */
	protected $taskRepository;

	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$tasks = $this->taskRepository->findAll();
		$this->view->assign('tasks', $tasks);
	}

	/**
	 * action show
	 *
	 * @param \Cundd\TimeOverview\Domain\Model\Task $task
	 * @return void
	 */
	public function showAction(Task $task) {
		$this->view->assign('task', $task);
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
	 * @param \Cundd\TimeOverview\Domain\Model\Task $newTask
	 * @return void
	 */
	public function createAction(Task $newTask) {
		$this->taskRepository->add($newTask);
		$this->flashMessageContainer->add('Your new Task was created.');
		$this->redirect('list');
	}

	/**
	 * action edit
	 *
	 * @param \Cundd\TimeOverview\Domain\Model\Task $task
	 * @return void
	 */
	public function editAction(Task $task) {
		$this->view->assign('task', $task);
	}

	/**
	 * action update
	 *
	 * @param \Cundd\TimeOverview\Domain\Model\Task $task
	 * @return void
	 */
	public function updateAction(Task $task) {
		$this->taskRepository->update($task);
		$this->flashMessageContainer->add('Your Task was updated.');
		$this->redirect('list');
	}

	/**
	 * action delete
	 *
	 * @param \Cundd\TimeOverview\Domain\Model\Task $task
	 * @return void
	 */
	public function deleteAction(Task $task) {
		$this->taskRepository->remove($task);
		$this->flashMessageContainer->add('Your Task was removed.');
		$this->redirect('list');
	}

}
?>