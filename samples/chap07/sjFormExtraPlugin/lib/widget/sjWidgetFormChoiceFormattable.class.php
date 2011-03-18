<?php

class sjWidgetFormChoiceFormattable extends sfWidgetFormChoice
{
  protected function configure($options = array(), $attributes = array())
  {
    parent::configure($options, $attributes);

    $this->addOption('item_format', '<li>%s</li>');
    $this->addOption('all_format',  '<ul>%s</ul>');
    $this->setOption('renderer_options', array('formatter'=> array($this, 'formatter')));
    $this->setOption('expanded',    true);
  }

  public function formatter($widget, $inputs)
  {
    $rows = array();
    $item_format = $this->getOption('item_format');
    foreach ($inputs as $input)
    {
      $rows[] = sprintf($item_format, $input['input'] . $this->getOption('label_separator') . $input['label']);
    }

    return !$rows ? '' : sprintf($this->getOption('all_format'), implode($this->getOption('separator'), $rows));
  }
}

