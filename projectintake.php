<?php

require_once 'projectintake.civix.php';

function projectintake_civicrm_custom( $op, $groupID, $entityID, &$params ) {
  $autoCaseStatus = new CRM_Projectintake_AutomaticRejectCaseStatus($groupID, $params);
  if ($autoCaseStatus->isValid()) {
    $autoCaseStatus->parse();
  }
  
  $unsetNewCustomerTag = new CRM_Projectintake_UnsetNewCustomerUponRejection($groupID, $params);
  if ($unsetNewCustomerTag->isValid()) {
      $unsetNewCustomerTag->parse();
  }
}

/**
 * Implementation of hook_civicrm_config
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function projectintake_civicrm_config(&$config) {
  _projectintake_civix_civicrm_config($config);
}

/**
 * Implementation of hook_civicrm_xmlMenu
 *
 * @param $files array(string)
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function projectintake_civicrm_xmlMenu(&$files) {
  _projectintake_civix_civicrm_xmlMenu($files);
}

/**
 * Implementation of hook_civicrm_install
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function projectintake_civicrm_install() {
  // issue 3021 run config to rename and remove custom fields if still required
  CRM_Projectintake_IntakeAnamonConfig::singleton();
  return _projectintake_civix_civicrm_install();
}

/**
 * Implementation of hook_civicrm_uninstall
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function projectintake_civicrm_uninstall() {
  return _projectintake_civix_civicrm_uninstall();
}

/**
 * Implementation of hook_civicrm_enable
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function projectintake_civicrm_enable() {
  return _projectintake_civix_civicrm_enable();
}

/**
 * Implementation of hook_civicrm_disable
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function projectintake_civicrm_disable() {
  return _projectintake_civix_civicrm_disable();
}

/**
 * Implementation of hook_civicrm_upgrade
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed  based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function projectintake_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _projectintake_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implementation of hook_civicrm_managed
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function projectintake_civicrm_managed(&$entities) {
  return _projectintake_civix_civicrm_managed($entities);
}

/**
 * Implementation of hook_civicrm_caseTypes
 *
 * Generate a list of case-types
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function projectintake_civicrm_caseTypes(&$caseTypes) {
  _projectintake_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implementation of hook_civicrm_alterSettingsFolders
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function projectintake_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _projectintake_civix_civicrm_alterSettingsFolders($metaDataFolders);
}
/**
 * Implementation of hook civicrm_buildForm
 *
 * @param string $formName
 * @param object $form
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_buildForm
 */
function projectintake_civicrm_buildForm($formName, &$form) {
  CRM_Projectintake_IntakeAnamon::buildForm($formName, $form);
}
