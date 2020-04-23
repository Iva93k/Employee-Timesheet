<?php
if (!isset($params['escape']) || $params['escape'] !== false) {
    $message = h($message);
}
?>
<div class="alert alert-block alert-danger fade in" onclick="this.classList.add('hidden');"><?= $message ?></div>
