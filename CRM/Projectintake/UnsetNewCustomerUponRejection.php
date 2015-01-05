<?php

/**
 * Act on a change in custom group Intake (belongs to case project intake)
 * And unset the New Customer tag on the client of the case (the customer)
 */
class CRM_Projectintake_UnsetNewCustomerUponRejection extends CRM_Projectintake_Rejected {
  
  protected function doAction($caseId) {
    $tag_id = civicrm_api3('Tag', 'getvalue', array('return' => 'id', 'name' => 'New Customer'));
    $case = civicrm_api3('Case', 'getsingle', array('id' => $caseId));
    $cids = $case['contact_id'];
    
    CRM_Core_BAO_EntityTag::removeEntitiesFromTag($cids, $tag_id, 'civicrm_contact');
  }
  
}

