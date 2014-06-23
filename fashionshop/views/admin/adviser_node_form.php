<?php echo form_open($this->config->item('admin_folder') . '/adviser_node/form/' . $nodesNode); ?>
<fieldset>
    <div class="control-group">

        <?php
        if($nodesNode != ''){
            echo '<label class=\"control-label\" for=\"name\">Đang chỉnh sửa cho nút: <b>'.$nodesNode.'</b></label>';
        }
        ?>
        <div class="controls">
            <?php
            $data = array('name' => 'nodesNode', 'type' => 'hidden', 'value' => set_value('nodesNode', $nodesNode), 'required' => '', 'class' => 'span2', 'maxlength' => '20');
            if($nodesNode != ''){
                $data['readonly'] = 'readonly';
            }
            echo form_input($data);
            ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label" for="name">Nội Dung Nút</label>

        <div class="controls">
<!--            --><?php
//            $data = array('name' => 'nodesContent', 'value' => set_value('nodesContent', $nodesContent), 'required' => '', 'class' => 'span6');
//            echo form_input($data);
//            ?>
            <?php
            $data	= array('name'=>'nodesContent', 'class'=>'redactor', 'value'=>set_value('nodesContent', $nodesContent), 'required' => '');
            echo form_textarea($data);
            ?>
        </div>
    </div>

    <div class="page-header">
        <h3>Gán nút cho sản phẩm</h3>
    </div>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Sale Price</th>
            <th>Current node</th>
            <th>
            </th>
        </tr>
        </thead>
        <tbody>
        <?php echo (count($products) < 1)?'<tr><td style="text-align:center;" colspan="7">'.lang('no_products').'</td></tr>':''?>
        <?php foreach ($products as $product):?>
            <tr>
                <td><?php echo $product->id;?></td>
                <td><?php echo $product->name;?></td>
                <td><?php echo $product->price;?></td>
                <td><?php echo $product->saleprice;?></td>
                <td><?php echo $product->adviserNode;?></td>
                <td>
					<span class="btn-group pull-right">
                        <?php
                            if($product->adviserNode == $nodesNode){
                        ?>
						<a class="btn btn-danger" href="" onclick="return areyousure();"><i class="icon-plus icon-white"></i> Hủy Gán</a>
                        <?php
                            } elseif ($product->adviserNode == 0){
                        ?>
                            <a class="btn btn-primary" href="" onclick="return areyousure();"><i class="icon-plus icon-white"></i> Gán</a>
                        <?php
                            } elseif($product->adviserNode != $nodesNode) {
                        ?>
                            <a class="btn btn-primary" href="" onclick="return areyousure();"><i class="icon-plus icon-white"></i> Gán lại</a>
                        <?php
                            }
                        ?>
					</span>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <hr>
    <div class="control-group">
        <label class="control-label" for="password"></label>

        <div class="controls">
            <input type="submit" value="Submit" name="submit" class="btn btn-primary"/>
        </div>
    </div>
</fieldset>
</form>
<script type="text/javascript">
    $('form').submit(function () {
        $('.btn').attr('disabled', true).addClass('disabled');
    });
</script>