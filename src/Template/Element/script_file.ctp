<script>
    /***Global Variable Start***/
    var siteUrl = '<?= HTTP_ROOT; ?>';
    var isLoggedIn = '<?= $this->request->session()->read('Auth.User.id') ? 'yes' : 'no'; ?>';
</script>
