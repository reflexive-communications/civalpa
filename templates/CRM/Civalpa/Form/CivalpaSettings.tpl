<div class="crm-container">
    {* HEADER *}
    <div class="crm-submit-buttons">{include file="CRM/common/formButtons.tpl" location="top"}</div>

    {* Debug header *}
    <h3>Debug header options</h3>
    <table class="form-layout">
        <tr class="crm-section crm-civalpa_debugMode">
            <td class="label">{$form.debugMode.label}</td>
            <td class="content"></td>
            <td class="content">{$form.debugMode.html}</td>
        </tr>
    </table>
    {* Line width manipulation *}
    <h3>Text manipulation options</h3>
    <table class="form-layout">
        <thead>
            <tr>
                <th>{ts}Rule name{/ts}</th>
                <th>{ts}Value{/ts}</th>
                <th>{ts}Use{/ts}</th>
            </tr>
        </thead>
        <tbody>
            <tr class="crm-section crm-civalpa_textLine">
                <td class="label"><b>{$form.textLineWidth.label}</b></td>
                <td class="content">{$form.textLineWidth.html}</td>
                <td class="content">{$form.useTextRule.html}</td>
            </tr>
            <tr class="crm-section crm-civalpa_htmlLine">
                <td class="label"><b>{$form.htmlLineWidth.label}</b></td>
                <td class="content">{$form.htmlLineWidth.html}</td>
                <td class="content">{$form.useHtmlRule.html}</td>
            </tr>
        </tbody>
    </table>

    {* FOOTER *}
    <div class="crm-submit-buttons">{include file="CRM/common/formButtons.tpl" location="bottom"}</div>
</div>
