{if $vars.chat_type == 'freechat'}
    {if isset($vars.chat_title) && $vars.chat_title}{$vars.chat_title}<br /><br />{/if}
    {include file='chatinclude_freechat.tpl'}
{elseif $vars.chat_type == 'freechat1'}
    {include file='chatinclude_freechat1.tpl'}
{elseif $vars.chat_type == 'ajaxchat'}
    {include file='chatinclude_ajaxchat.tpl'}
{/if}
