<?php

namespace Drupal\site_info\Service;

use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\datetime\Plugin\Field\FieldType\DateTimeItemInterface;

/**
 * Class SiteInfoService.
 */
class SiteInfoService {

	/**
   * Gives curretn date and itme based on provided Timezone
   *
   * @param string $timezone
   *   Selected Timezone value.
   *
   * @return string
   *   Returns the DateTime.
   */
  public function getCurrentDateTime($timezone){
  	$datetime = '';
    if(!isset($timezone) || empty($timezone)){
      $timezone = drupal_get_user_timezone();
    }
 	  $now = DrupalDateTime::createFromTimestamp(time());
    $now->setTimezone(new \DateTimeZone($timezone));
    $datetime = $now->format('jS M Y - h:i A');
    return $datetime;
  }

}