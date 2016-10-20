<div id="successMsg" class="message success" onclick="this.classList.add('hidden')"><?= h($message) ?></div>
<script>setTimeout(function () { document.getElementById('successMsg').style.display = 'none'; }, 4000);</script>
