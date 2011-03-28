<script type="text/javascript">
        var auto_refresh = setInterval( function()
        {
                jQuery('#chatpane').load('index.php?ajx');
                var objDiv = document.getElementById("chatpane");
                objDiv.scrollTop = objDiv.scrollHeight;
        }, <?php echo REFRESHMS; ?>);
        var objDiv = document.getElementById("chatpane");
        objDiv.scrollTop = objDiv.scrollHeight;
</script>
</body>
</html>
