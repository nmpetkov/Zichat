<div class="z-formrow">
    <label for="chat_type">{gt text='Chat type'}</label>
    <select id="chat_type" name="chat_type" size="1">
        <option value="freechat"{if $vars.chat_type eq 'freechat'} selected="selected"{/if}>phpFreeChat</option>
        <option value="freechat1"{if $vars.chat_type eq 'freechat1'} selected="selected"{/if}>phpFreeChat 1.6</option>
        <option value="ajaxchat"{if $vars.chat_type eq 'ajaxchat'} selected="selected"{/if}>AJAX Chat</option>
    </select>
    <div class="z-sub z-formnote">phpFreeChat - {gt text='Current version'}</div>
    <div class="z-sub z-formnote">phpFreeChat 1.6 - {gt text='Old version, may not exist in future versions of Zichat'}</div>
    <div class="z-sub z-formnote">AJAX Chat - {gt text='Current version'}</div>
</div>
<div class="z-formrow">
    <label for="chat_title">{gt text='Chat title'}</label>
    <input id="chat_title" type="text" name="chat_title" size="80" value="{$vars.chat_title|safetext}" />
</div>
<div class="z-formrow">
    <label for="chat_template">{gt text="Template"}</label>
    <select id="chat_template" name="chat_template" size="{$vars.templates|@count}">
    {foreach from=$vars.templates item=template}
        <option value="{$template}"{if $vars.chat_template eq $template} selected="selected"{/if}>{$template}</option>
    {/foreach}
    </select>
    <div class="z-sub z-formnote">{gt text='Up/down and left/right are for Chat/Side html placement position.'}</div>
</div>
<div class="z-formrow">
    <label for="chat_tophtml">{gt text='Top html content'}</label>
    <textarea id="chat_tophtml" name="chat_tophtml" cols="65" rows="15" />{$vars.chat_tophtml|safehtml}</textarea>
    <div class="z-sub z-formnote">{gt text='This content can be empty or any allowed for the site html, from simple text to iframe with live stream.'}</div>
</div>
<div class="z-formrow">
    <label for="chat_sidehtml">{gt text='Side html content'}</label>
    <textarea id="chat_sidehtml" name="chat_sidehtml" cols="65" rows="15" />{$vars.chat_sidehtml|safehtml}</textarea>
    <div class="z-sub z-formnote">{gt text='This content can be empty or any allowed for the site html, from simple text to iframe with live stream.'}</div>
</div>
{notifydisplayhooks eventname='blocks.ui_hooks.htmlblock.content.form_edit' id=$bid}
