<form id='mumie_sso_form' name='mumie_sso_form' method='post' action='<?= $task->task_url; ?>'>
    <input type='hidden' name='userId' id='userId' type ='text' value='{$ssotoken->the_user}'/>
    <input type='hidden' name='token' id='token' type ='text' value='{$ssotoken->token}'/>
    <input type='hidden' name='org' id='org' type ='text' value='{$org}'/>
    <input type='hidden' name='resource' id='resource' type ='text' value='{$problemurl}'/>
</form>
<script>
    document.forms['mumie_sso_form'].submit();
</script>   