<?php

namespace Drupal\site_info\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\site_info\Service\SiteInfoService;
use Drupal\Core\Config\ConfigFactoryInterface;

/**
 * Provides a 'Site Information' Block.
 *
 * @Block(
 *   id = "siteinfo",
 *   admin_label = @Translation("Site Information"),
 * )
 */
class SiteInfoBlock extends BlockBase implements ContainerFactoryPluginInterface {
  /**
   * Config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  protected $configFactory;

  /**
   * SiteInfoService.
   *
   * @var \Drupal\site_info\Service\SiteInfoService
   */
  protected $siteinfo;

  /**
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   * @param \Drupal\Core\Session\AccountInterface $account
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, SiteInfoService $siteinfo, ConfigFactoryInterface $configFactory) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->siteinfo = $siteinfo;
    // Get SiteSettingsForm settings.
    $this->config = $configFactory->get('site_info.settings');
  }

  /**
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   *
   * @return static
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('site_info.site_services'),
      $container->get('config.factory')
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $build = [];
    //Retrive AdminConfigForm values
    $country = empty($this->config->get('country')) ? ' - ' : $this->config->get('country');
    $city = empty($this->config->get('city')) ? ' - ' : $this->config->get('city').' ';

    $timezone = $this->config->get('timezone');
    //Call to service method to get Current Time
    $datetime = $this->siteinfo->getCurrentDateTime($timezone);

    $build = [
      '#theme' => 'site_info',
      '#location' => $city.$country,
      '#datetime' => $datetime,
      '#cache' =>[
          'max-age' => 0,
        ]
     ];

    return $build;
  }
    
}