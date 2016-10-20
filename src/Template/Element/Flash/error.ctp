<div id="errorMsg" class="message error" onclick="this.classList.add('hidden');"><?= h($message) ?></div>
<script>setTimeout(function () { document.getElementById('errorMsg').style.display = 'none'; }, 4000);</script>
