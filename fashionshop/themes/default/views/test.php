<?php

echo 'hello';
?>
<?php foreach ($answerYN as $node_entry): ?>

    <div class="row">
        <div class="span8">
            <div class="control-group">
                <label for="<?php echo $node_entry->nodesNode; ?>"></label>


            </div>
        </div>
    </div>

<?php endforeach; ?>
