<?php
/*
 * $topic
 */
?>
<script>
    loadInlineCode.push(
            function(){
                createEventSource("<?php echo base_url()."serversend/newpost/".$topic['id']; ?>");
            });
</script>