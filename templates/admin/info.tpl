{adminheader}
<div class="z-admin-content-pagetitle">
    {icon type="info" size="small"}
    <h3>{gt text='Zichat info'}</h3>
</div>

<div>
    <p>
    {gt text="This module integrates chat rooms in various places you may need."}
    <br /><br />
    <a href="https://github.com/nmpetkov/Zichat" target="_blank"><b>{gt text="Project page"}</b></a>
    &nbsp;|&nbsp;<a href="{modurl modname='Zichat' type='user' func='main'}"><b>{gt text="Frontend"}</b></a>
    <br /><br />
    </p>
</div>

<table class="z-datatable">
    <thead>
        <tr>
            <th>{gt text="Chat software"}</th>
            <th>{gt text="Description"}</th>
            <th>{gt text="Data storage"}</th>
            <th>{gt text="Technology"}</th>
            <th>{gt text="Zikula integration"}</th>
            <th>{gt text="How to"}</th>
            <th class="z-right">{gt text="Actions"}</th>
        </tr>
    </thead>
    <tbody>
        <tr class="{cycle values="z-odd,z-even"}">
            <td>
                phpFreeChat 2.1.0<br /><br />
                <a href="http://www.phpfreechat.net/" target="_blank">www.phpfreechat.net</a><br />
                <a href="https://github.com/kerphi/phpfreechat" target="_blank">github.com/</a>
            </td>
            <td>
                Major browsers compatible.<br />Php >= 5.3.0<br />
                Still lack of many features, but they are under development.<br />
                Simple design. Load faster.
            </td>
            <td>
                File system (no database needed)
            </td>
            <td>
                AJAX, JQuery
            </td>
            <td>
                Integrations with iframes or embedded with script.<br />
                Users are not still available/integrated.
            </td>
            <td>
                1. With block.<br />
                2. With module URL:<br />{literal}{Zichat:user:display:chat=freechat}{/literal}<br />
                3. With hook.<br />
                4. With iframe tag in templates.
            </td>
            <td>
                <a href="{modurl modname="Zichat" type="user" func="display" chat="freechat" itype="script"}">{gt text='View embeded'}</a><br />
                <a href="{modurl modname="Zichat" type="user" func="display" chat="freechat" itype="iframe"}">{gt text='View iframed'}</a>
            </td>
        </tr>
        <tr class="{cycle values="z-odd,z-even"}">
            <td>
                phpFreeChat 1.6<br /><br />
                <a href="http://www.phpfreechat.net/" target="_blank">www.phpfreechat.net</a><br />
                <a href="http://sourceforge.net/projects/phpfreechat/" target="_blank">sourceforge.net/</a>
            </td>
            <td>
                Major browsers compatible.<br />
                Many features, but will be depreciated in future.
            </td>
            <td>
                File system (no database needed)
            </td>
            <td>
                AJAX, Prototype
            </td>
            <td>
                Integrated with iframes.<br />
                Users are integrated.
            </td>
            <td>
                1. With block.<br />
                2. With module URL:<br />{literal}{Zichat:user:display:chat=freechat1}{/literal}<br />
                3. With hook.<br />
                4. With iframe tag in templates.
            </td>
            <td>
                <a href="{modurl modname="Zichat" type="user" func="display" chat="freechat1"}">{gt text='View'}</a>
            </td>
        </tr>
        <tr class="{cycle values="z-odd,z-even"}">
            <td>
                AJAX Chat 0.8.6<br /><br />
                <a href="http://frug.github.com/AJAX-Chat/" target="_blank">frug.github.com/AJAX-Chat</a><br />
                <a href="https://github.com/Frug/AJAX-Chat" target="_blank">github.com/</a>
            </td>
            <td>
                Major browsers compatible.<br />
                Full of features.
            </td>
            <td>
                MySql database tables.
            </td>
            <td>
                AJAX
            </td>
            <td>
                Integrated with iframes.<br />
                Zikula users are integrated.
            </td>
            <td>
                1. With block.<br />
                2. With module URL:<br />{literal}{Zichat:user:display:chat=ajaxchat}{/literal}<br />
                3. With hook.<br />
                4. With iframe tag in templates.
            </td>
            <td>
                <a href="{modurl modname="Zichat" type="user" func="display" chat="ajaxchat"}">{gt text='View'}</a>
            </td>
        </tr>
    </tbody>
</table>

{adminfooter}