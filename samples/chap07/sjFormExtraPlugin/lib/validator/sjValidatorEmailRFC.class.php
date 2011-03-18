<?php
class sjValidatorEmailRFC extends sfValidatorEmail
{
  // この正規表現は、以下のURLにある大崎氏作のPerl版のものをPHP構文に書きなおしたもの
  // http://www.din.or.jp/~ohzaki/mail_regex.htm
  // (2009年3月●日バージョン)
  static $REGEX_EMAIL_RFC = '{^(?:[-!#-\'*+/-9=?A-Z^-~]+(?:\.[-!#-\'*+/-9=?A-Z^-~]+)*|"(?:[!#-\[\]-~]|\\\\[\x09 -~])*")@[-!#-\'*+/-9=?A-Z^-~]+(?:\.[-!#-\'*+/-9=?A-Z^-~]+)*$}i';

  protected function configure($options = array(), $messages = array())
  {
    parent::configure($options, $messages);

    $this->setOption('pattern', self::$REGEX_EMAIL_RFC);
  }
}
