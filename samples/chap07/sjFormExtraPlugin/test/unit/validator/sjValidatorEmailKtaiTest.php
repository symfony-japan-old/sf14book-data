<?php

require_once(dirname(__FILE__).'/../../bootstrap/unit.php');

$t = new lime_test(32);

mb_internal_encoding('UTF8');

$v = new sjValidatorEmailKtai();

// ->clean()
$t->diag('->clean()');
foreach (array(
  'example@docomo.ne.jp',
  'example@biz.ezweb.ne.jp',
  'example@ezweb.ne.jp',
  'example@softbank.ne.jp',
  'example@willcom.com',
  'example@disney.ne.jp',
  'example@i.softbank.jp',
  'example@t.vodafone.ne.jp',
  'example@jp-c.ne.jp',
  'example@a.pdx.ne.jp',
  'example@pdx.ne.jp',
  'da.me..@docomo.ne.jp',
  'da...me@docomo.ne.jp',
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
  'fabien@symfony-project.com',
  'info@symfony.gr.jp',
//  'da.me..@docomo.ne.jp', ok
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

$t->diag('error_multibyte option');

$v->setOption('error_multibyte', false);

foreach (array(
  '日本語@docomo.ne.jp',
) as $email)
{
  try
  {
    $v->clean($email);
    $t->pass('マルチバイトがあってもエラーとしない：' . $email);
  }
  catch (sfValidatorError $e)
  {
    $t->fail('マルチバイトがあってもエラーとしない：' . $email);
    $t->is($e->getCode(), 'invalid', '->clean() throws a sfValidatorError');
  }
}

$v->setOption('error_multibyte', true);

foreach (array(
  '日本語@docomo.ne.jp',
) as $email)
{
  try
  {
    $v->clean($email);
    $t->fail('マルチバイトを含む場合はエラー：' . $email);
    $t->skip('', 1);
  }
  catch (sfValidatorError $e)
  {
    $t->pass('マルチバイトを含む場合はエラー：' . $email);
    $t->is($e->getCode(), 'invalid', '->clean() throws a sfValidatorError');
  }
}



$t->diag('convert_multibyte option');

$v = new sjValidatorEmailKtai();
$v->setOption('error_multibyte',   false);
$v->setOption('convert_multibyte', false);

$ret = $v->clean('日本語@docomo.ne.jp');
$t->is($ret, '日本語@docomo.ne.jp', 'マルチバイト半角変換なしでも通過：' . $email);


$v = new sjValidatorEmailKtai();
$v->setOption('error_multibyte',   false);
$v->setOption('convert_multibyte', false);

try
{
  $v->clean('ｅｘａｍｐｌｅ＠ｄｏｃｏｍｏ．ｎｅ．ｊｐ');
  $t->fail('マルチバイト半角変換していないのでエラー：' . $email);
  $t->skip('', 1);
}
catch (sfValidatorError $e)
{
  $t->pass('マルチバイト半角変換していないのでエラー：' . $email);
  $t->is($e->getCode(), 'invalid', '->clean() throws a sfValidatorError');
}




$v = new sjValidatorEmailKtai();
$v->setOption('error_multibyte',   false);
$v->setOption('convert_multibyte', true);

$ret = $v->clean('ｅｘａｍｐｌｅ＠ｄｏｃｏｍｏ．ｎｅ．ｊｐ');
$t->is($ret, 'example@docomo.ne.jp', 'マルチバイト半角変換しているので通過：' . $email);


