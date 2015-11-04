<?php
/**
 * Class following Singleton pattern for specific extension configuration
 * for Projectintake PUM - activity Intake Customer by Anamon
 *
 * @author Erik Hommel (CiviCooP) <erik.hommel@civicoop.org>
 * @date 3 Nov 2015
 * @license AGPL-3.0
 */

class CRM_Projectintake_IntakeAnamonConfig {
  /*
   * singleton pattern
   */
  static private $_singleton = NULL;

  protected $_customGroup = array();
  protected $_activityTypeId = null;
  protected $_anamonRoleName = null;

  /**
   * Constructor method
   *
   * @access public
   */
  function __construct() {
    $this->setCustomGroup();
    $activityType = CRM_Threepeas_Utils::getActivityTypeWithName("Intake Customer by Anamon");
    $this->_activityTypeId = $activityType['value'];
    $this->_anamonRoleName = "Anamon";
  }

  /**
   * Method to get the intake anamon custom group
   *
   * @param string $key
   * @return mixed
   * @access public
   */
  public function getCustomGroup($key = null) {
    if (empty($key) || !isset($this->_customGroup[$key])) {
      return $this->_customGroup;
    } else {
      return $this->_customGroup[$key];
    }
  }

  /**
   * Method to get the anamon role name
   *
   * @return string
   * @access public
   */
  public function getAnamonRoleName() {
    return $this->_anamonRoleName;
  }

  /**
   * Method to get the activity type id of Intake Customer by Anamon
   *
   * @return int
   * @access public
   */
  public function getActivityTypeId() {
    return $this->_activityTypeId;
  }

  /**
   * Method to set the intake anamon custom group and change fields if still required
   */
  private function setCustomGroup() {
    $customGroup = CRM_Threepeas_Utils::getCustomGroup("Intake_Customer_by_Anamon");
    if (!empty($customGroup)) {

      // update label and delete deprecated custom field for issue 3021
      $this->updateLabelApproveField($customGroup['id']);
      $this->deleteApproveProjectCustomField($customGroup['id']);

      $customFieldParams = array('custom_group_id' => $customGroup['id']);
      try {
        $customFields = civicrm_api3("CustomField", "Get", $customFieldParams);
        $customGroup['custom_fields'] = $customFields['values'];
      } catch (CiviCRM_API3_Exception $ex) {}
      $this->_customGroup = $customGroup;
    }
  }

  /**
   * Method to delete custom field that is no longer required (issue 3021) once
   *
   * @param $customGroupId
   * @access private
   */
  private function deleteApproveProjectCustomField($customGroupId) {
    $getParams = array(
      'custom_group_id' => $customGroupId,
      'name' => "Do_you_approve_the_Customer_"
    );
    try {
      $customField = civicrm_api3("CustomField", "Getsingle", $getParams);
      try {
        civicrm_api3("CustomField", "Delete", array('id' => $customField['id']));
      } catch (CiviCRM_API3_Exception $ex) {}
    } catch (CiviCRM_API3_Exception $ex) {}
  }

  /**
   * Method to update the label of custom field approve customer and project (issue 3021) once
   *
   * @param $customGroupId
   * @access private
   */
  private function updateLabelApproveField($customGroupId) {
    $getParams = array(
      'custom_group_id' => $customGroupId,
      'name' => "Do_you_approve_the_project_",
      'label' => "Do you approve the project?"
    );
    try {
      $customField = civicrm_api3("CustomField", "Getsingle", $getParams);
      $updateParams = $customField;
      $updateParams['label'] = "Do you approve this customer and this project?";
      $updateParams['is_active'] = 1;
      try {
        civicrm_api3("CustomField", "Create", $updateParams);
      } catch (CiviCRM_API3_Exception $ex) {}
    } catch (CiviCRM_API3_Exception $ex) {}
  }

  /**
   * Function to return singleton object
   *
   * @return object $_singleton
   * @access public
   * @static
   */
  public static function &singleton() {
    if (self::$_singleton === NULL) {
      self::$_singleton = new CRM_Projectintake_IntakeAnamonConfig();
    }
    return self::$_singleton;
  }

}