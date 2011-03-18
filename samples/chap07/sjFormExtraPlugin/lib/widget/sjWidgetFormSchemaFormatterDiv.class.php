<?php
class sjWidgetFormSchemaFormatterDiv extends sfWidgetFormSchemaFormatter
{
  protected
    $rowFormat       = "<div class="formrow">\n  %error%%label%\n  %field%%help%\n%hidden_fields%</div>\n",
    $errorRowFormat  = "<li>\n%errors%</li>\n",
    $helpFormat      = '<br />%help%',
    $decoratorFormat = "<div class="formcontent">\n  %content%</div>";
}

