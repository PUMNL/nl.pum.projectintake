<?php

/**
 * Act on a change in custom group Intake (belongs to case project intake)
 * And set status to Rejected;
 */
abstract class CRM_Projectintake_Rejected {
  
  protected $params;
  
  protected $groupId;
  
  protected $isValid;
  
  protected $cgroup_intake;
  
  public function __construct($groupId, $params) {
    $this->groupId = $groupId;
    $this->params = $params;
    
    $this->cgroup_intake = civicrm_api3('CustomGroup', 'getsingle', array('name' => 'Intake'));
  }
  
  protected function check() {
    $this->isValid = false;
    if ($this->groupId == $this->cgroup_intake['id']) {
      $this->isValid = true;
    }
  }
  
  public function isValid() {
    $this->check();
    return $this->isValid;
  }
  
  public function parse() {
    if (!$this->isValid()) {
      return;
    }
    
    $asses_rep_field = civicrm_api3('CustomField', 'getsingle', array('name' => 'Assessment_Rep', 'custom_group_id' => $this->cgroup_intake['id']));
    foreach($this->params as $param) {
      if ($param['custom_field_id'] == $asses_rep_field['id'] && strtolower($param['value']) == 'reject') {
        //update the case status to reject
        $this->doAction($param['entity_id']);
      }
    }
  }
  
  abstract protected function doAction($caseId);
  
}

