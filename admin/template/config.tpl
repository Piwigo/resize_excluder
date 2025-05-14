<form method="post" id="resize_excluder">

  <fieldset class="mainConf">
    <legend><span class="icon-cog icon-purple"></span>{'Basic settings'|translate}</legend>

{if isset($group_options)}
    <div id="excluded_group">
      <label>{'Which group should be excluded from the resize on upload setting ?'|translate}</label>
      <select name="excluded_group">
        <option value="">--</option>
        {html_options options=$group_options selected=$excluded_group}
      </select>
    </div>
{else}
  {'You need to have at least one groupe to use this setting.'|translate}
{/if}

</fieldset>

<div class="savebar-footer">
  <div class="savebar-footer-start">
  </div>
  <div class="savebar-footer-end">

  {if isset($save_success)}
    <div class="savebar-footer-block">
      <div class="badge info-message">
        <i class="icon-ok"></i>{$save_success}
      </div>
    </div>
  {/if}

    <div class="savebar-footer-block">
      <button class="buttonLike" type="submit" name="resize_excluder"><i class="icon-floppy"></i> {'Save settings'|translate}</button>
    </div>
  </div>
</div>

</form>