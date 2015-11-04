<?php
/**
 * Class handling intake customer by anamon for projectintake
 * (#issue 3021 http://redmine.pum.nl/issues/3021)
 *
 * @author Erik Hommel (CiviCooP) <erik.hommel@civicoop.org>
 * @date 3 Nov 2015
 * @license AGPL-3.0
 */

class CRM_Projectintake_IntakeAnamon {

  /**
   * Method buildForm to process actions from civicrm hook buildForm
   * - issue 3021 only allow Intake Customer by Anamon activity for case if user has role Anamon
   *
   * @param string $formName
   * @param object $form
   */
  public static function buildForm($formName, &$form) {
    if ($formName == "CRM_Case_Form_Activity") {
      $config = CRM_Projectintake_Config::singleton();
      $intakeAnamonConfig = CRM_Projectintake_IntakeAnamonConfig::singleton();
      if ($form->_caseType == $config->getCaseTypeName() && $form->_activityTypeId == $intakeAnamonConfig->getActivityTypeId()) {
        if (self::userCanEditCustomFields() == TRUE) {
          //self::switchCustomFields("edit");
        } else {
          //self::switchCustomFields("view");
          $element = $form->getElement("status_id");
          $element->freeze();
        }
      }
    }
  }

  /**
   * Method to determine if user is allowed to edit custom fields for Intake Customer by Anamon.
   * (only if administrator or Anamon)
   *
   * @return bool
   */
  public static function userCanEditCustomFields() {
    global $user;
    $intakeAnamonConfig = CRM_Projectintake_IntakeAnamonConfig::singleton();
    if (in_array($intakeAnamonConfig->getAnamonRoleName(), $user->roles) || in_array("administrator", $user->roles)) {
      return TRUE;
    } else {
      return FALSE;
    }
  }

  /**
   * Method to set custom fields to view only or edit mode
   *
   * @param string $type
   */
  public static function switchCustomFields($type) {
    if ($type == "view") {
      $isView = 1;
    } else {
      $isView = 0;
    }
    $intakeAnamonConfig = CRM_Projectintake_IntakeAnamonConfig::singleton();
    $customGroup = $intakeAnamonConfig->getCustomGroup();
    foreach ($customGroup['custom_fields'] as $customFieldId => $customField) {
      $query = "UPDATE civicrm_custom_field SET is_view = %1 WHERE id = %2";
      $params = array(
        1 => array($isView, "Integer"),
        2 => array($customFieldId, "Integer")
      );
      CRM_Core_DAO::executeQuery($query, $params);
    }
  }
}