<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
    die();
}?>
<script>
    window.optionFormData = JSON.parse(<?=CUtil::PhpToJSObject($arResult['FORM_SCHEMA'])?>);
</script>
<div id="app"></div>
<div class="version"><?=$arResult['VERSION']?></div>
