<?php

/**
 * Act on a change in custom group Intake (belongs to case project intake)
 * And set status to Rejected;
 */
class CRM_Projectintake_AutomaticRejectCaseStatus extends CRM_Projectintake_Rejected {
  
  protected function doAction($caseId) {
    $case_status_option_group = civicrm_api3('OptionGroup', 'getvalue', array('return' => 'id', 'name' => 'case_status'));
    $reject_case_status_id = civicrm_api3('OptionValue', 'getvalue', array('return' => 'value', 'option_group_id' => $case_status_option_group, 'name' => 'Rejected'));
    $params['id'] = $caseId;
    $params['case_status_id'] = $reject_case_status_id;
    civicrm_api3('Case', 'create',$params);
  }
  
}

