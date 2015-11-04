<?php
/**
 * Class following Singleton pattern for specific extension configuration
 * for Projectintake PUM
 *
 * @author Erik Hommel (CiviCooP) <erik.hommel@civicoop.org>
 * @date 3 Nov 2015
 * @license AGPL-3.0
 */

class CRM_Projectintake_Config {
  /*
   * singleton pattern
   */
  static private $_singleton = NULL;

  protected $_caseTypeId = NULL;
  protected $_caseTypeName = NULL;

  /**
   * Constructor method
   *
   * @access public
   */
  function __construct() {
    $this->setCaseType();
  }

  /**
   * Method to get the project intake case type name
   *
   * @return string
   * @access public
   */
  public function getCaseTypeName() {
    return $this->_caseTypeName;
  }

  /**
   * Method to get the project intake case type id
   *
   * @return int
   * @access public
   */
  public function getCaseTypeId() {
    return $this->_caseTypeId;
  }

  /**
   * Method to set the case type id for projectintake
   *
   * @throws Exception when API OptionValue Getvalue throws error
   */
  private function setCaseType() {
    $optionGroupId = CRM_Threepeas_Utils::getCaseTypeOptionGroupId();
    $this->_caseTypeName = "Projectintake";
    $params = array(
      'option_group_id' => $optionGroupId,
      'name' => $this->_caseTypeName,
      'return' => 'value');
    try {
      $this->_caseTypeId = civicrm_api3('OptionValue', 'Getvalue', $params);
    } catch (CiviCRM_API3_Exception $ex) {
      throw new Exception('Could not find case type Projectintake, error from API OptionValue Getvalue: '
        .$ex->getMessage());
    }
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
      self::$_singleton = new CRM_Projectintake_Config();
    }
    return self::$_singleton;
  }

}