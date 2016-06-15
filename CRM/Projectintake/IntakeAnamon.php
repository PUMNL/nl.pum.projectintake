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
   * Method buildForm to process actions from civicrm hook buildForm
   * - issue 3021 only allow update status activity if user has role Anamon
   *
   * @param string $formName
   * @param object $form
   */
  public static function buildForm($formName, &$form) {
    switch ($formName) {
      case "CRM_Case_Form_Activity":
        if (!self::userCanEditIntakeAnamon()) {
          self::protectIntakeAnamonOnCase($form);
        }
      break;
      case "CRM_Activity_Form_Activity":
        if (!self::userCanEditIntakeAnamon()) {
          self::protectIntakeAnamonOnActivity($form);
        }
      break;
    }
    if ($formName == "CRM_Case_Form_Activity") {
      if (!self::userCanEditIntakeAnamon()) {

      }
    }
  }

  /**
   * Method to protect activity intake anamon on activity form
   *
   * @param $form
   */
  private static function protectIntakeAnamonOnActivity(&$form) {
    $intakeAnamonConfig = CRM_Projectintake_IntakeAnamonConfig::singleton();
    // freeze custom elements
    if (isset($form->_subType) && isset($form->_type)) {
      if ($form->_type == 'Activity' && $form->_subType == $intakeAnamonConfig->getActivityTypeId()) {
        $customFields = $intakeAnamonConfig->getCustomGroup('custom_fields');
        foreach ($customFields as $customFieldId => $customField) {
          foreach ($form->_elementIndex as $indexName => $index) {
            $parts = explode('_', $indexName);
            if ($parts[0] = 'custom' && isset($parts[1]) && $parts[1] == $customFieldId) {
              $customElement = $form->getElement($indexName);
              $customElement->freeze();
            }
          }
        }
      }
    }
    if ($form->_activityTypeId == $intakeAnamonConfig->getActivityTypeId()) {
      CRM_Core_Region::instance('page-body')->add(array('template' => 'CRM/Projectintake/IntakeAnamonReadOnly.tpl'));
      $statusElement = $form->getElement("status_id");
      $statusElement->freeze();
    }
  }

  /**
   * Method to protect activity intake anamon on case form
   *
   * @param $form
   */
  private static function protectIntakeAnamonOnCase(&$form) {
    $config = CRM_Projectintake_Config::singleton();
    $intakeAnamonConfig = CRM_Projectintake_IntakeAnamonConfig::singleton();
    // freeze custom elements
    if (isset($form->_subType) && isset($form->_type)) {
      if ($form->_type == 'Activity' && $form->_subType == $intakeAnamonConfig->getActivityTypeId()) {
        $customFields = $intakeAnamonConfig->getCustomGroup('custom_fields');
        foreach ($customFields as $customFieldId => $customField) {
          foreach ($form->_elementIndex as $indexName => $index) {
            $parts = explode('_', $indexName);
            if ($parts[0] = 'custom' && isset($parts[1]) && $parts[1] == $customFieldId) {
              $customElement = $form->getElement($indexName);
              $customElement->freeze();
            }
          }
        }
      }
    }

    if ($form->_caseType == $config->getCaseTypeName() && $form->_activityTypeId == $intakeAnamonConfig->getActivityTypeId()) {
      CRM_Core_Region::instance('page-body')->add(array('template' => 'CRM/Projectintake/IntakeAnamonReadOnly.tpl'));
      $statusElement = $form->getElement("status_id");
      $statusElement->freeze();
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