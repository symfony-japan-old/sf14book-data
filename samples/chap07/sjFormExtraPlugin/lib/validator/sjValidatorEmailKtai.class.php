<?php
class sjValidatorEmailKtai extends sfValidatorEmail
{
  // 携帯電話のドメインに限定
  public static $KTAI_DOMAINS = array(
    'docomo\.ne\.jp',
    'ezweb\.ne\.jp',
    '[^\.]*\.biz\.ezweb\.ne\.jp',
    'disney\.ne\.jp',
    '[^\.]*\.softbank\.jp',
    'softbank\.ne\.jp',
    '[^\.]*\.vodafone\.ne\.jp',
    'jp-[^\.]*\.ne\.jp',
    'willcom\.com',
    '[^\.]*\.pdx\.ne\.jp',
    'pdx\.ne\.jp',
  );

  protected function configure($options = array(), $messages = array())
  {
    $this->addOption('error_multibyte',   true);
    $this->addOption('convert_multibyte', false);
    parent::configure($options, $messages);

    $pattern = '{^([^@\s]+)@(' . implode(self::$KTAI_DOMAINS ,')|(') . ')$}i';

    $this->setOption('pattern', $pattern);
  }

  protected function doClean($value)
  {
    if ($this->getOption('convert_multibyte'))
    {
        $value = mb_convert_kana($value, 'ak');
    }

    $clean = parent::doClean($value);

    if ($this->getOption('error_multibyte'))
    {
      if (strlen($value) !== mb_strlen($value))
      {
        throw new sfValidatorError($this, 'invalid', array('value' => $value));
      }
    }

    return $clean;
  }
}
