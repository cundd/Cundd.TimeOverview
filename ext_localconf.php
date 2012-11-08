<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::configurePlugin(
	$_EXTKEY,
	'Cunddtimeoverview',
	array(
		'Record' => 'list, show, new, create, edit, update, delete',
		'Person' => 'list, show, new, create, edit, update, delete',
		'Project' => 'list, show, new, create, edit, update, delete',
		'Task' => 'list, show, new, create, edit, update, delete',
		'SpecialRecord' => 'list, show, new, create, edit, update, delete',
		
	),
	// non-cacheable actions
	array(
		'Record' => 'create, update, delete',
		'Person' => 'create, update, delete',
		'Project' => 'create, update, delete',
		'Task' => 'create, update, delete',
		'SpecialRecord' => 'create, update, delete',
		
	)
);

?>