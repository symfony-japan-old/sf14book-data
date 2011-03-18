<?php

require_once(dirname(__FILE__).'/../../bootstrap/unit.php');

$t = new lime_test(16);

$v = new sjValidatorEmailRFC();

// ->clean()
$t->diag('->clean()');
foreach (array(
  'fabien.potencier@symfony-project.com',
  'example@example.co.uk',
  'fabien_potencier@example.fr',
  'example@localhost',
) as $email)
{
  $t->is($v->clean($email), $email, '->clean() checks that the value is a valid email:' . $email);
}

foreach (array(
  'example',
  'example@',
//  'example@localhost',  ok
  'example@example.com@example.com',
  'example.@example.com',
  'da.me..@docomo.ne.jp',
  '日本語@gmail.com',
) as $nonEmail)
{
  try
  {
    $v->clean($nonEmail);
    $t->fail('->clean() throws an sfValidatorError if the value is not a valid email:' . $nonEmail);
    $t->skip('', 1);
  }
  catch (sfValidatorError $e)
  {
    $t->pass('->clean() throws an sfValidatorError if the value is not a valid email:' . $nonEmail);
    $t->is($e->getCode(), 'invalid', '->clean() throws a sfValidatorError');
  }
}

