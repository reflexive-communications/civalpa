<div class="crm-container">
    {* HEADER *}
    <div class="crm-submit-buttons">{include file="CRM/common/formButtons.tpl" location="top"}</div>

    <div class="crm-section">
        <div class="label">{$form.debugMode.label}</div>
        <div class="content">{$form.debugMode.html}</div>
        <div class="clear"></div>
    </div>
    <div class="crm-section">
        <div class="label">{$form.textLineWidth.label}</div>
        <div class="content">{$form.textLineWidth.html}</div>
        <div class="label">{$form.useTextRule.label}</div>
        <div class="content">{$form.useTextRule.html}</div>
        <div class="clear"></div>
    </div>
    <div class="crm-section">
        <div class="label">{$form.htmlLineWidth.label}</div>
        <div class="content">{$form.htmlLineWidth.html}</div>
        <div class="label">{$form.useHtmlRule.label}</div>
        <div class="content">{$form.useHtmlRule.html}</div>
        <div class="clear"></div>
    </div>

    {* FOOTER *}
    <div class="crm-submit-buttons">{include file="CRM/common/formButtons.tpl" location="bottom"}</div>
</div>
