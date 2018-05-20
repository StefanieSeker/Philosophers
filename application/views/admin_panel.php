<?php echo javascript("validator.js"); ?>

<?php
$attributes = array('name' => 'myform');
echo form_open('admin/createPhilosopher', $attributes);
?>

<h2>Add philosopher</h2><hr>
<div class="form-group">
    <table>
        <tr>
            <td style="padding: 10px">
                <label for="Name" class="control-label">Name</label>
                <?php echo form_input(array('name' => 'Name', 'id' => 'Name', 'class' => 'form-control', 'placeholder' => 'Name', 'required' => 'required')); ?>
            </td>
        </tr>
        <tr>
            <td style="padding: 10px">
                <label for="Birthdate" class="control-label">Birthdate</label>
                <?php echo form_input(array('name' => 'Birthdate', 'id' => 'Birthdate', 'class' => 'form-control', 'placeholder' => 'Birthdate', 'required' => 'required')); ?>
            </td>
        </tr>
        <tr>
            <td style="padding: 10px">
                <label for="PlaceOfBirth" class="control-label">Place Of Birth</label>
                <?php echo form_input(array('name' => 'PlaceOfBirth', 'id' => 'PlaceOfBirth', 'class' => 'form-control', 'placeholder' => 'Place Of Birth', 'required' => 'required')); ?>
            </td>
        </tr>
        <tr>
            <td style="padding: 10px">
                <label for="DateOfDeath" class="control-label">Date Of Death</label>
                <?php echo form_input(array('name' => 'DateOfDeath', 'id' => 'DateOfDeath', 'class' => 'form-control', 'placeholder' => 'Date Of Death', 'required' => 'required')); ?>
            </td>
        </tr>
        <tr>
            <td>
                <label for="EraID" class="control-label">Era</label>
                <?php

                foreach ($eras as $era) {
                    $options[$era->ID] = $era->Era;
                }
                echo form_dropdown('EraID', $options, '', 'class="form-control"');
                ?>
            </td>
        </tr>
        </br>

    </table>
    </br>
    <?php echo form_submit('mysubmit', 'Voeg toe', 'class="btn btn-success"'); ?>

    <div class="help-block with-errors"></div>
</div>

</br>
<?php

echo form_close(); 