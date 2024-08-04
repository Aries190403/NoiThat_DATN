<script>
    function checkAndBlockFunctionality() {
        if (<?php echo json_encode(config('settingconfig.lock')); ?> == 'true') {
            document.onkeydown = function(e) {
                if (e.keyCode == 123) { // F12
                    return false;
                }
                if (e.ctrlKey && e.shiftKey && e.keyCode == 73) { // Ctrl+Shift+I
                    return false;
                }
                if (e.ctrlKey && e.shiftKey && e.keyCode == 74) { // Ctrl+Shift+J
                    return false;
                }
                if (e.ctrlKey && e.keyCode == 85) { // Ctrl+U
                    return false;
                }
            };

            document.addEventListener('contextmenu', function(e) {
                e.preventDefault();
            });
        }
    }


    function detectDevTools() {
        if(<?php echo json_encode(config('settingconfig.lock')); ?> == 'true'){
            var threshold = 160;
            var checkStatus = function() {
                if (window.outerWidth - window.innerWidth > threshold || window.outerHeight - window.innerHeight > threshold) {
                    window.location.href = '/errorDevtools';
                }
            }
            window.addEventListener('resize', checkStatus);
            checkStatus();
        }
    }

    window.onload = function() {
        checkAndBlockFunctionality();
        detectDevTools();
    }
</script>