<?php
/**
 * Class handling intake customer by anamon for projectintake
 * (#issue 3021 http://redmine.pum.nl/issues/3021)
 *
 * @author Erik Hommel (CiviCooP) <erik.hommel@civicoop.org>
 * @date 3 Nov 2015
 * @license AGPL-3.0
 */

class CRM_Projectintake_IntakeAnamon
{

  /**
   * Method to filter custom field name and values from form fields
   *
   * @param $customFieldName
   * @param $fields
   * @return array
   */
  public static function getFormCustomFieldData($customFieldName, $fields) {
    $formCustomFieldData = array();
    foreach ($fields as $fieldName => $fieldValue) {
      $fieldNameParts = explode("_", $fieldName);
      if (isset($fieldNameParts[1]) && $fieldNameParts[0] == "custom") {
        $name = "custom_" . $fieldNameParts[1];
        if ($name == $customFieldName) {
          $formCustomFieldData['id'] = $fieldNameParts[1];
          $formCustomFieldData['name'] = "custom_" . $fieldNameParts[1];
          $formCustomFieldData['value'] = $fieldValue;
          $formCustomFieldData['form_name'] = $fieldName;
        }
      }
    }
    return $formCustomFieldData;
  }

  /**
   * Method buildForm to process actions from civicrm hook buildForm
   * - issue 3021 only allow update status activity if user has role Anamon
   *
   * @param string $formName
   * @param object $form
   */
  public static function buildForm($formName, &$form) {
    if ($formName == "CRM_Case_Form_Activity") {
      $config = CRM_Projectintake_Config::singleton();
      $intakeAnamonConfig = CRM_Projectintake_IntakeAnamonConfig::singleton();
      if ($form->_caseType == $config->getCaseTypeName() && $form->_activityTypeId == $intakeAnamonConfig->getActivityTypeId()) {
        if (!self::userCanEditIntakeAnamon()) {
          CRM_Core_Region::instance('page-body')->add(array('template' => 'CRM/Projectintake/IntakeAnamonReadOnly.tpl'));
          $statusElement = $form->getElement("status_id");
          $statusElement->freeze();
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
  public static function userCanEditIntakeAnamon() {
    global $user;
    $intakeAnamonConfig = CRM_Projectintake_IntakeAnamonConfig::singleton();
    if (in_array($intakeAnamonConfig->getAnamonRoleName(), $user->roles) || in_array("administrator", $user->roles)) {
      return TRUE;
    } else {
      return FALSE;
    }
  }
}