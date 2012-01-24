{extends file="base.tpl"}

{block name="pagetitle"}{message name={$pagetitle}}{/block}
{block name="header"}{include file="mgmt/header.tpl"}{/block}
{block name="subnav"}{include file="mgmt/subnav.tpl"}{/block}
{block name="prebody"}{if $showError == "yes"}{include file="mgmt/errorbar.tpl"}{/if}{/block}

{* Disable display of these bits *}
{block name="langlinks"}{/block}
{block name="image"}{/block}
