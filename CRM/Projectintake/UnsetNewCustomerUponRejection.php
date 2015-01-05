<?php

/**
 * Act on a change in custom group Intake (belongs to case project intake)
 * And unset the New Customer tag on the client of the case (the customer)
 */
class CRM_Projectintake_UnsetNewCustomerUponRejection extends CRM_Projectintake_Rejected {
  
  protected function doAction($caseId) {
    $tag_id = civicrm_api3('Tag', 'getvalue', array('return' => 'id', 'name' => 'New Customer'));
    $case = civicrm_api3('Case', 'getsingle', array('id' => $caseId));
    foreach($case['contact_id'] as $cid) {
        try {
            $tag_entity_id = civicrm_api3('EntityTag', 'getvalue', array('return' => 'id', 'entity' => 'civicrm_contact', 'tag_id' => $tag_id, 'entity_id' => $cid));
            //unset tag if set
            civicrm_api3('EntityTag', 'delete', array('id' => $tag_entity_id));
        } catch (Exception $e) {
            //do nothing becuase tag New Customer is already unset
        }
    }
  }
  
}

