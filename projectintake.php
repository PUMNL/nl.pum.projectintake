<?php

require_once 'projectintake.civix.php';

/**
 * Implementation of hook_civicrm_aclWhereClause
 * 
 * Check if the current user is customer contact and retreive for every customer 
 * the country coordinator(s) and the local rep(s)
 * 
 * @param type $type
 * @param type $tables
 * @param type $whereTables
 * @param type $contactID
 * @param type $where
 */
function projectintake_civicrm_aclWhereClause( $type, &$tables, &$whereTables, &$contactID, &$where ) {
  //select all customers for this contact
  $return = false;
  $config = CRM_Projectintake_Config::singleton();
  $customer_contact_rel_type_id = $config->getCustomerContactRelationTypeId();
  $cc_rel_type_id = $config->getCountryCoordinatorRelationTypeId();
  $loc_rep_rel_type_id = $config->getLocalRepRelationTypeId();
  if ($customer_contact_rel_type_id === false || $cc_rel_type_id === false || $loc_rep_rel_type_id === false) {
    return false;
  }
  
  $clauses = array();
  
  //find customers for this contact
  $dao = CRM_Core_DAO::executeQuery("SELECT `contact_id_a` FROM `civicrm_relationship` WHERE `relationship_type_id`  = %1 AND `contact_id_b` = %2 AND `is_active` = 1  AND (`start_date` <= CURDATE() OR `start_date` IS NULL) AND (`end_date` >= CURDATE() OR `end_date` IS NULL)", array(
    1 => array($customer_contact_rel_type_id, 'Integer'),
    2 => array($contactID, 'Integer'),
  ));
  while ($dao->fetch()) {
    $cc_table_name = 'cc_'.$dao->contact_id_a;
    $loc_rep_table_name = 'loc_rep_'.$dao->contact_id_a;
    
    //retrieve the country contact id of the customer
    $country_id = _projectintake_country_contact_id($dao->contact_id_a);
    if (empty($country_id)) {
      continue; //continue customer is not linked to a country
    }
    
    //access to customer
    $clauses[] = " (contact_a.id = '".$dao->contact_id_a."')";
    
   $tables[$cc_table_name] = $whereTables[$cc_table_name] = 
        "LEFT JOIN `civicrm_relationship` `{$cc_table_name}` ON contact_a.id = {$cc_table_name}.contact_id_b";     
   $clauses[] = " ({$cc_table_name}.relationship_type_id = '".$cc_rel_type_id."' AND {$cc_table_name}.contact_id_a = '".$country_id."' 
      AND `{$cc_table_name}`.`is_active` = '1' AND (`{$cc_table_name}`.`start_date` <= CURDATE() OR `{$cc_table_name}`.`start_date` IS NULL) AND (`{$cc_table_name}`.`end_date` >= CURDATE() OR `{$cc_table_name}`.`end_date` IS NULL))";     
   
   $tables[$loc_rep_table_name] = $whereTables[$loc_rep_table_name] = 
        "LEFT JOIN `civicrm_relationship` `{$loc_rep_table_name}` ON contact_a.id = {$loc_rep_table_name}.contact_id_b";
   $clauses[] .= " ({$loc_rep_table_name}.relationship_type_id = '".$loc_rep_rel_type_id."' AND {$loc_rep_table_name}.contact_id_a = '".$country_id."')
        AND `{$loc_rep_table_name}`.`is_active` = '1' AND (`{$loc_rep_table_name}`.`start_date` <= CURDATE() OR `{$loc_rep_table_name}`.`start_date` IS NULL) AND (`{$loc_rep_table_name}`.`end_date` >= CURDATE() OR `{$loc_rep_table_name}`.`end_date` IS NULL)";
  }
  
  if ( ! empty( $clauses ) ) {
    $where .= ' (' . implode( ' OR ', $clauses ) . ')';
    $return = true;
  }
  
  return $return;
}

function _projectintake_country_contact_id($contact_id) {
  $config = CRM_Projectintake_Config::singleton();
  $country_field_id = $config->getCountryCustomFieldId();
  if (empty($country_field_id)) {
    return false;
  }
  
  $address = civicrm_api3('Address', 'getsingle', array('is_primary' => '1', 'contact_id' => $contact_id));
  if (empty($address['country_id'])) {
    return false;
  }
  
  $params['custom_'.$country_field_id] = $address['country_id'];
  $contact = civicrm_api3('Contact', 'getsingle', $params);
  if (isset($contact['id'])) {
    return $contact['id'];
  }
  return false;
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
