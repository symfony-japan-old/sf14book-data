<?php

require_once dirname(__FILE__) . '/../../../../lib/vendor/symfony/lib/autoload/sfCoreAutoload.class.php';
sfCoreAutoload::register();

$configuration = new sfProjectConfiguration(dirname(__FILE__).'/../fixtures/project');
require_once $configuration->getSymfonyLibDir().'/vendor/lime/lime.php';

function sjFormExtraPlugin_autoload_again($class)
{
  $autoload = sfSimpleAutoload::getInstance();
  $autoload->reload();
  return $autoload->autoload($class);
}
spl_autoload_register('sjFormExtraPlugin_autoload_again');

if (file_exists($config = dirname(__FILE__).'/../../config/sjFormExtraPluginConfiguration.class.php'))
{
  require_once $config;
  $plugin_configuration = new sjFormExtraPluginConfiguration($configuration, dirname(__FILE__).'/../..', 'sjFormExtraPlugin');
}
else
{
  $plugin_configuration = new sfPluginConfigurationGeneric($configuration, dirname(__FILE__).'/../..', 'sjFormExtraPlugin');
}
