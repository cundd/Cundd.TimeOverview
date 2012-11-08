<?php
if (!defined('TYPO3_MODE')) {
	die ('Access denied.');
}

Tx_Extbase_Utility_Extension::registerPlugin(
	$_EXTKEY,
	'Cunddtimeoverview',
	'Time Overview'
);

t3lib_extMgm::addStaticFile($_EXTKEY, 'Configuration/TypoScript', 'Time Overview');

t3lib_extMgm::addLLrefForTCAdescr('tx_cunddtimeoverview_domain_model_record', 'EXT:cundd_time_overview/Resources/Private/Language/locallang_csh_tx_cunddtimeoverview_domain_model_record.xlf');
t3lib_extMgm::allowTableOnStandardPages('tx_cunddtimeoverview_domain_model_record');
$TCA['tx_cunddtimeoverview_domain_model_record'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:cundd_time_overview/Resources/Private/Language/locallang_db.xlf:tx_cunddtimeoverview_domain_model_record',
		'label' => 'start',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'start,end,comment,person,task,',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Record.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_cunddtimeoverview_domain_model_record.gif'
	),
);

t3lib_extMgm::addLLrefForTCAdescr('tx_cunddtimeoverview_domain_model_person', 'EXT:cundd_time_overview/Resources/Private/Language/locallang_csh_tx_cunddtimeoverview_domain_model_person.xlf');
t3lib_extMgm::allowTableOnStandardPages('tx_cunddtimeoverview_domain_model_person');
$TCA['tx_cunddtimeoverview_domain_model_person'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:cundd_time_overview/Resources/Private/Language/locallang_db.xlf:tx_cunddtimeoverview_domain_model_person',
		'label' => 'username',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'username,password,first_name,last_name,records,projects,special_records,',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Person.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_cunddtimeoverview_domain_model_person.gif'
	),
);

t3lib_extMgm::addLLrefForTCAdescr('tx_cunddtimeoverview_domain_model_project', 'EXT:cundd_time_overview/Resources/Private/Language/locallang_csh_tx_cunddtimeoverview_domain_model_project.xlf');
t3lib_extMgm::allowTableOnStandardPages('tx_cunddtimeoverview_domain_model_project');
$TCA['tx_cunddtimeoverview_domain_model_project'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:cundd_time_overview/Resources/Private/Language/locallang_db.xlf:tx_cunddtimeoverview_domain_model_project',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'title,description,tasks,persons,',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Project.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_cunddtimeoverview_domain_model_project.gif'
	),
);

t3lib_extMgm::addLLrefForTCAdescr('tx_cunddtimeoverview_domain_model_task', 'EXT:cundd_time_overview/Resources/Private/Language/locallang_csh_tx_cunddtimeoverview_domain_model_task.xlf');
t3lib_extMgm::allowTableOnStandardPages('tx_cunddtimeoverview_domain_model_task');
$TCA['tx_cunddtimeoverview_domain_model_task'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:cundd_time_overview/Resources/Private/Language/locallang_db.xlf:tx_cunddtimeoverview_domain_model_task',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'title,description,records,',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/Task.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_cunddtimeoverview_domain_model_task.gif'
	),
);

t3lib_extMgm::addLLrefForTCAdescr('tx_cunddtimeoverview_domain_model_specialrecord', 'EXT:cundd_time_overview/Resources/Private/Language/locallang_csh_tx_cunddtimeoverview_domain_model_specialrecord.xlf');
t3lib_extMgm::allowTableOnStandardPages('tx_cunddtimeoverview_domain_model_specialrecord');
$TCA['tx_cunddtimeoverview_domain_model_specialrecord'] = array(
	'ctrl' => array(
		'title'	=> 'LLL:EXT:cundd_time_overview/Resources/Private/Language/locallang_db.xlf:tx_cunddtimeoverview_domain_model_specialrecord',
		'label' => 'title',
		'tstamp' => 'tstamp',
		'crdate' => 'crdate',
		'cruser_id' => 'cruser_id',
		'dividers2tabs' => TRUE,

		'origUid' => 't3_origuid',
		'languageField' => 'sys_language_uid',
		'transOrigPointerField' => 'l10n_parent',
		'transOrigDiffSourceField' => 'l10n_diffsource',
		'delete' => 'deleted',
		'enablecolumns' => array(
			'disabled' => 'hidden',
			'starttime' => 'starttime',
			'endtime' => 'endtime',
		),
		'searchFields' => 'title,recurring,comment,start,end,person,task,',
		'dynamicConfigFile' => t3lib_extMgm::extPath($_EXTKEY) . 'Configuration/TCA/SpecialRecord.php',
		'iconfile' => t3lib_extMgm::extRelPath($_EXTKEY) . 'Resources/Public/Icons/tx_cunddtimeoverview_domain_model_specialrecord.gif'
	),
);

?>