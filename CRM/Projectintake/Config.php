<?php

/* 
 * Singleton class for config settings (relation names)
 */

class CRM_Projectintake_Config {
  
  protected static $_instance = false;
  
  private $customerContactRelation = false;
  
  private $country_id_custom_field = false;
  
  private $ccRelation = false;
  
  private $locRepRelation = false;
  
  private function __construct() {
    $this->customerContactRelation = civicrm_api3('RelationshipType', 'getsingle', array('name_b_a' => 'Authorised contact for'));
    $this->ccRelation = civicrm_api3('RelationshipType', 'getsingle', array('name_a_b' => 'Country Coordinator is'));
    $this->locRepRelation = civicrm_api3('RelationshipType', 'getsingle', array('name_a_b' => 'Representative'));

    $gid = civicrm_api3('CustomGroup', 'getvalue', array('return' => 'id', 'name' => 'pumCountry'));
    $this->country_id_custom_field = civicrm_api3('CustomField', 'getsingle', array('custom_group_id' => $gid, 'name' => 'civicrm_country_id'));
  }
  
  public static function singleton() {
    if (!self::$_instance) {
      self::$_instance = new CRM_Projectintake_Config();
    }
    return self::$_instance;
  }
  
  public function getCustomerContactRelationTypeId() {
    if (!isset($this->customerContactRelation['id'])) {
      return false;
    }
    return $this->customerContactRelation['id'];
  }
  
  public function getCountryCoordinatorRelationTypeId() {
    if (!isset($this->ccRelation['id'])) {
      return false;
    }
    return $this->ccRelation['id'];
  }
  
  public function getLocalRepRelationTypeId() {
    if (!isset($this->locRepRelation['id'])) {
      return false;
    }
    return $this->locRepRelation['id'];
  }
  
  public function getCountryCustomFieldId() {
    if (!isset($this->country_id_custom_field['id'])) {
      return false;
    }
    return $this->country_id_custom_field['id'];
  }
}

