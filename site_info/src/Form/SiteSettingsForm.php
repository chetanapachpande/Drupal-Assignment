<?php

namespace Drupal\site_info\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Datetime\DrupalDateTime;
use Drupal\datetime\Plugin\Field\FieldType\DateTimeItemInterface;

/**
 * Configure site_info settings for this site.
 */
class SiteSettingsForm extends ConfigFormBase {

  /** 
   * Config settings.
   *
   * @var string
   */
  const SETTINGS = 'site_info.settings';

  /** 
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'site_admin_settings';
  }

  /** 
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return [
      static::SETTINGS,
    ];
  }

  /** 
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config(static::SETTINGS);
    $timezone_arr = ['America/Chicago' => 'America/Chicago', 'America/New_York'=>'America/New_York','Asia/Tokyo'=>'Asia/Tokyo', 'Asia/Dubai' => 'Asia/Dubai', 'Asia/Kolkata'=>'Asia/Kolkata', 'Europe/Amsterdam'=>'Europe/Amsterdam', 'Europe/Oslo'=>'Europe/Oslo', 'Europe/London'=>'Europe/London'
      ];

    $form['country'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Country'),
      '#default_value' => $config->get('country'),
    ];  

    $form['city'] = [
      '#type' => 'textfield',
      '#title' => $this->t('City'),
      '#default_value' => $config->get('city'),
    ];  

    $form['timezone'] = [
      '#type' => 'select',
      '#empty_option' => '- Select -',
      '#title' =>  t('Select Timezone:'),
      '#default_value' => $config->get('timezone'),
      '#options' => $timezone_arr,
    ];

    return parent::buildForm($form, $form_state);
  }

  /** 
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->configFactory->getEditable(static::SETTINGS)
      ->set('country', $form_state->getValue('country'))
      ->set('city', $form_state->getValue('city'))
      ->set('timezone', $form_state->getValue('timezone'))
      ->save();

    parent::submitForm($form, $form_state);
  }

}