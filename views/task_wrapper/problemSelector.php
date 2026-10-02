<form id='mumie_problem_selector_form' name='mumie_problem_selector_form' method='post' action='<?= htmlReady($ssoUrl); ?>'>
    <input type='hidden' name='userId' id='userId' value='<?= htmlReady($ssoToken->the_user); ?>'/>
    <input type='hidden' name='token' id='token' value='<?= htmlReady($ssoToken->token); ?>'/>
    <input type='hidden' name='org' id='org' value='<?= htmlReady($org); ?>'/>
    <input type='hidden' name='uiLang' id='uiLang' value='<?= htmlReady($uiLang); ?>'/>
    <input type='hidden' name='serverUrl' id='serverUrl' value='<?= htmlReady($serverUrl); ?>'/>
    <input type='hidden' name='gradingType' id='gradingType' value='<?= htmlReady($gradingType); ?>'/>
    <input type='hidden' name='problemLang' id='problemLang' value='<?= htmlReady($problemLang); ?>'/>
    <input type='hidden' name='origin' id='origin' value='<?= htmlReady($origin); ?>'/>
    <?php if ($selection): ?>
    <input type='hidden' name='selection' id='selection' value='<?= htmlReady($selection); ?>'/>
    <?php endif ?>
</form>
<script>
    document.forms['mumie_problem_selector_form'].submit();
</script>
