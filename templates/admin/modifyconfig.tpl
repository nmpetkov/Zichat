{adminheader}
<div class="z-admin-content-pagetitle">
    {icon type="config" size="small"}
    <h3>{gt text='Module settings'}</h3>
</div>

<form class="z-form" action="{modurl modname="Zichat" type="admin" func="updateconfig"}" method="post" enctype="application/x-www-form-urlencoded">
    <div>
    <input type="hidden" name="csrftoken" value="{insert name="csrftoken"}" />
    <fieldset>
        <legend>{gt text='General settings'}</legend>
        <div class="z-formrow">
            <label for="zichat_type">{gt text='Default chat'}</label>
            <select id="zichat_type" name="zichat_type" size="1">
                <option value="freechat"{if $modvars.Zichat.zichat_type eq 'freechat'} selected="selected"{/if}>phpFreeChat</option>
                <option value="freechat1"{if $modvars.Zichat.zichat_type eq 'freechat1'} selected="selected"{/if}>phpFreeChat 1.6</option>
                <option value="ajaxchat"{if $modvars.Zichat.zichat_type eq 'ajaxchat'} selected="selected"{/if}>AJAX Chat</option>
            </select>
            <div class="z-sub z-formnote">phpFreeChat - {gt text='Current version'}</div>
            <div class="z-sub z-formnote">phpFreeChat 1.6 - {gt text='Old version, may not exist in future versions of Zichat'}</div>
            <div class="z-sub z-formnote">AJAX Chat - {gt text='Current version'}</div>
        </div>
        <div class="z-formrow">
            <label for="zichat_title">{gt text='Default chat title'}</label>
            <input id="zichat_title" type="text" name="zichat_title" size="80" value="{$modvars.Zichat.zichat_title|safetext}" />
        </div>
        <div class="z-formrow">
            <label for="zichat_typehooked">{gt text='Hooked chat'}</label>
            <select id="zichat_typehooked" name="zichat_typehooked" size="1">
                <option value="freechat"{if $modvars.Zichat.zichat_typehooked eq 'freechat'} selected="selected"{/if}>phpFreeChat</option>
                <option value="freechat1"{if $modvars.Zichat.zichat_typehooked eq 'freechat1'} selected="selected"{/if}>phpFreeChat 1.6</option>
                <option value="ajaxchat"{if $modvars.Zichat.zichat_typehooked eq 'ajaxchat'} selected="selected"{/if}>AJAX Chat</option>
            </select>
        </div>
        <div class="z-formrow">
            <label for="zichat_titlehooked">{gt text='Hooked chat title'}</label>
            <input id="zichat_titlehooked" type="text" name="zichat_titlehooked" size="80" value="{$modvars.Zichat.zichat_titlehooked|safetext}" />
        </div>
    </fieldset>
    <fieldset>
        <legend>{gt text='Permissions'}</legend>
            <div class="z-formrow">
                <label for="user_groups">{gt text='Available user groups'}</label>
                <span>
                <select name="user_groups" id="user_groups" size="{$groups.count}" disabled="disabled">
                    {foreach item=group from=$groups}
                        <option value="{$group.gid|safetext}">{$group.gid|safetext}  -  {$group.name|safetext}  -  {$group.description|safetext}</option>
                    {/foreach}
                </select>
                </span>
            </div>
            <div class="z-formrow">
                <label for="zichat_admingroups">{gt text='Groups with admin roles'}</label>
                <input type="text" id="zichat_admingroups" name="zichat_admingroups" value="{$modvars.Zichat.zichat_admingroups|safetext}" />
                <p class="z-formnote z-sub">{gt text='Comma separated list of user groups IDs.'}</p>
            </div>
            <div class="z-formrow">
                <label for="zichat_moderatorgroups">{gt text='Groups with moderator roles'}</label>
                <input type="text" id="zichat_moderatorgroups" name="zichat_moderatorgroups" value="{$modvars.Zichat.zichat_moderatorgroups|safetext}" />
                <p class="z-formnote z-sub">{gt text='Comma separated list of user groups IDs.'}</p>
            </div>
    </fieldset>
    <fieldset>
        <legend>{gt text='PhpFreeChat settings'}</legend>
        <div class="z-formrow">
            <label for="freechat_theme">{gt text='Default theme'}</label>
            <select id="freechat_theme" name="freechat_theme" size="1">
                <option value="default"{if $modvars.Zichat.freechat_theme eq 'default'} selected="selected"{/if}>Default</option>
                <option value="carbon"{if $modvars.Zichat.freechat_theme eq 'carbon'} selected="selected"{/if}>Carbon</option>
                <option value="gamer"{if $modvars.Zichat.freechat_theme eq 'gamer'} selected="selected"{/if}>Gamer</option>
            </select>
        </div>
        <div class="z-formrow">
            <label for="freechat_itype">{gt text='Default integration'}</label>
            <select id="freechat_itype" name="freechat_itype" size="1">
                <option value="iframe"{if $modvars.Zichat.freechat_itype eq 'iframe'} selected="selected"{/if}>Iframe</option>
                <option value="script"{if $modvars.Zichat.freechat_itype eq 'script'} selected="selected"{/if}>Script</option>
            </select>
        </div>
        <div class="z-formrow">
            <label for="freechat_height">{gt text='Height in pixels'}</label>
            <input id="freechat_height" type="text" name="freechat_height" size="20" value="{$modvars.Zichat.freechat_height|safetext}" />
            <div class="z-sub z-formnote">{gt text='Height of the chat area, default is 400px.'}</div>
        </div>
        <div class="z-formrow">
            <label for="freechat_refresh_delay">{gt text='Refresh_delay'}</label>
            <input id="freechat_refresh_delay" type="text" name="freechat_refresh_delay" size="10" value="{$modvars.Zichat.freechat_refresh_delay|safetext}" />
            <div class="z-formnote">{gt text='Miliseconds to wait before next pending messages are checked.'}</div>
        </div>
        <div class="z-formrow">
            <label for="freechat_focus_on_connect">{gt text='Focus on connect'}</label>
            <input type="checkbox" value="1" id="freechat_focus_on_connect" name="freechat_focus_on_connect"{if $modvars.Zichat.freechat_focus_on_connect eq true} checked="checked"{/if}/>
            <div class="z-sub z-formnote">{gt text='If to focus to the input text box when connecting to the chat.'}</div>
        </div>
    </fieldset>
    <fieldset>
        <legend>{gt text='PhpFreeChat 1.6 settings'}</legend>
        <div class="z-formrow">
            <label for="freechat1_theme">{gt text='Default theme'}</label>
            <select id="freechat1_theme" name="freechat1_theme" size="1">
                <option value="default"{if $modvars.Zichat.freechat1_theme eq 'default'} selected="selected"{/if}>Default</option>
                <option value="zichat"{if $modvars.Zichat.freechat1_theme eq 'zichat'} selected="selected"{/if}>Zichat</option>
                <option value="zilveer"{if $modvars.Zichat.freechat1_theme eq 'zilveer'} selected="selected"{/if}>Zilveer</option>
                <option value="blune"{if $modvars.Zichat.freechat1_theme eq 'blune'} selected="selected"{/if}>Blune</option>
                <option value="green"{if $modvars.Zichat.freechat1_theme eq 'green'} selected="selected"{/if}>Green</option>
                <option value="phoenity"{if $modvars.Zichat.freechat1_theme eq 'phoenity'} selected="selected"{/if}>Phoenity</option>
                <option value="cerutti"{if $modvars.Zichat.freechat1_theme eq 'cerutti'} selected="selected"{/if}>Cerutti</option>
                <option value="phpbb2"{if $modvars.Zichat.freechat1_theme eq 'phpbb2'} selected="selected"{/if}>Phpbb2</option>
                <option value="msn"{if $modvars.Zichat.freechat1_theme eq 'msn'} selected="selected"{/if}>Msn</option>
            </select>
        </div>
        <div class="z-formrow">
            <label for="freechat1_height">{gt text='Height in pixels'}</label>
            <input id="freechat1_height" type="text" name="freechat1_height" size="20" value="{$modvars.Zichat.freechat1_height|safetext}" />
            <div class="z-sub z-formnote">{gt text='Height of the chat area, default is 400px.'}</div>
        </div>
        <div class="z-formrow">
            <label for="freechat1_refresh_delay">{gt text='Refresh_delay'}</label>
            <input id="freechat1_refresh_delay" type="text" name="freechat1_refresh_delay" size="10" value="{$modvars.Zichat.freechat1_refresh_delay|safetext}" />
            <div class="z-sub z-formnote">{gt text='Miliseconds to wait before next pending messages are checked.'}</div>
        </div>
        <div class="z-formrow">
            <label for="freechat1_focus_on_connect">{gt text='Focus on connect'}</label>
            <input type="checkbox" value="1" id="freechat1_focus_on_connect" name="freechat1_focus_on_connect"{if $modvars.Zichat.freechat1_focus_on_connect eq true} checked="checked"{/if}/>
            <div class="z-sub z-formnote">{gt text='If to focus to the input text box when connecting to the chat.'}</div>
        </div>
    </fieldset>
    <fieldset>
        <legend>{gt text='AJAX Chat settings'}</legend>
        <div class="z-formrow">
            <label for="ajaxchat_theme">{gt text='Default theme'}</label>
            <select id="ajaxchat_theme" name="ajaxchat_theme" size="1">
                <option value="grey"{if $modvars.Zichat.ajaxchat_theme eq 'grey'} selected="selected"{/if}>Grey</option>
                <option value="beige"{if $modvars.Zichat.ajaxchat_theme eq 'beige'} selected="selected"{/if}>Beige</option>
                <option value="Cobalt"{if $modvars.Zichat.ajaxchat_theme eq 'Cobalt'} selected="selected"{/if}>Cobalt</option>
                <option value="Uranium"{if $modvars.Zichat.ajaxchat_theme eq 'Uranium'} selected="selected"{/if}>Uranium</option>
                <option value="prosilver"{if $modvars.Zichat.ajaxchat_theme eq 'prosilver'} selected="selected"{/if}>Prosilver</option>
                <option value="Core"{if $modvars.Zichat.ajaxchat_theme eq 'Core'} selected="selected"{/if}>Core</option>
                <option value="MyBB"{if $modvars.Zichat.ajaxchat_theme eq 'MyBB'} selected="selected"{/if}>MyBB</option>
                <option value="vBulletin"{if $modvars.Zichat.ajaxchat_theme eq 'vBulletin'} selected="selected"{/if}>vBulletin</option>
                <option value="Mercury"{if $modvars.Zichat.ajaxchat_theme eq 'Mercury'} selected="selected"{/if}>Mercury</option>
            </select>
        </div>
        <div class="z-formrow">
            <label for="ajaxchat_height">{gt text='Height in pixels'}</label>
            <input id="ajaxchat_height" type="text" name="ajaxchat_height" size="20" value="{$modvars.Zichat.ajaxchat_height|safetext}" />
            <div class="z-sub z-formnote">{gt text='Height of the chat area, default is 400px.'}</div>
        </div>
        <div class="z-formrow">
            <label for="ajaxchat_channels">{gt text='Available channels to users'}</label>
            <input id="ajaxchat_channels" type="text" name="ajaxchat_channels" size="100" value="{$modvars.Zichat.ajaxchat_channels|safetext}" />
            <div class="z-sub z-formnote">{gt text='Comma separated list. Example: Public,Private'}</div>
            <div class="z-sub z-formnote">{gt text='First in list is default channel and is available always to guests.'}</div>
        </div>
        <div class="z-formrow">
            <label for="ajaxchat_channelsguest">{gt text='Available channels to guests'}</label>
            <input id="ajaxchat_channelsguest" type="text" name="ajaxchat_channelsguest" size="100" value="{$modvars.Zichat.ajaxchat_channelsguest|safetext}" />
            <div class="z-sub z-formnote">{gt text='Names have to exist in list of channels available to users.'}</div>
        </div>
    </fieldset>
    <div class="z-buttons z-formbuttons">
        {button src="button_ok.png" set="icons/extrasmall" __alt="Save" __title="Save" __text="Save"}
        <a href="{modurl modname="Zichat" type="admin" func='modifyconfig'}" title="{gt text="Cancel"}">{img modname=core src="button_cancel.png" set="icons/extrasmall" __alt="Cancel" __title="Cancel"} {gt text="Cancel"}</a>
    </div>
    </div>
</form>
{adminfooter}