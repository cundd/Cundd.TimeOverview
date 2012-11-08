<?php
namespace Cundd\TimeOverview\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Cundd.TimeOverview".    *
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use \Cundd\TimeOverview\Domain\Model\Project as Project;

/**
 * Standard controller for the Cundd.TimeOverview package 
 *
 * @Flow\Scope("singleton")
 */
class ProjectController extends \TYPO3\Flow\Mvc\Controller\ActionController {

	/**
	 * projectRepository
	 *
	 * @Flow\Inject
	 * @var \Cundd\TimeOverview\Domain\Repository\ProjectRepository
	 */
	protected $projectRepository;


	/**
	 * action list
	 *
	 * @return void
	 */
	public function listAction() {
		$projects = $this->projectRepository->findAll();
		$this->view->assign('projects', $projects);
	}

	/**
	 * action show
	 *
	 * @param \Cundd\TimeOverview\Domain\Model\Project $project
	 * @return void
	 */
	public function showAction(Project $project) {
		$this->view->assign('project', $project);
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
	 * @param \Cundd\TimeOverview\Domain\Model\Project $newProject
	 * @return void
	 */
	public function createAction(Project $newProject) {
		$this->projectRepository->add($newProject);
		$this->flashMessageContainer->add('Your new Project was created.');
		$this->redirect('list');
	}

	/**
	 * action edit
	 *
	 * @param \Cundd\TimeOverview\Domain\Model\Project $project
	 * @return void
	 */
	public function editAction(Project $project) {
		$this->view->assign('project', $project);
	}

	/**
	 * action update
	 *
	 * @param \Cundd\TimeOverview\Domain\Model\Project $project
	 * @return void
	 */
	public function updateAction(Project $project) {
		$this->projectRepository->update($project);
		$this->flashMessageContainer->add('Your Project was updated.');
		$this->redirect('list');
	}

	/**
	 * action delete
	 *
	 * @param \Cundd\TimeOverview\Domain\Model\Project $project
	 * @return void
	 */
	public function deleteAction(Project $project) {
		$this->projectRepository->remove($project);
		$this->flashMessageContainer->add('Your Project was removed.');
		$this->redirect('list');
	}

}
?>