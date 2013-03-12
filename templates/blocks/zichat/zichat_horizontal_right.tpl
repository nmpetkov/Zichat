{if $blockvars.chat_tophtml}
<div>
    {$blockvars.chat_tophtml}
</div>
{/if}
{if $blockvars.chat_sidehtml}
<table border="0" cellpadding="0" cellspacing="0">
    <tr style="vertical-align: top;">
        <td>{$blockvars.chat_sidehtml}</td>
        <td style="width: 70%;">{include file='chatinclude.tpl'}</td>
    </tr>
</table>
{else}
    {include file='chatinclude.tpl'}
{/if}
