<div>
{if isset($vars.blockid) && $vars.blockid}
    {block bid=$vars.blockid}
{else}
    {include file='chatinclude.tpl'}
{/if}
</div>
