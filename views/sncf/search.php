<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	
	<title>Welcome to CodeIgniter Sncf library</title>
	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">

</head>
<body>

<div class="container">
	<h1>Welcome to CodeIgniter Sncf Libray demo !</h1>
	
	<?php echo validation_errors(); ?>

	<?=form_open('sncf_example/search', ['class' => 'form-inline'])?>
		<div class="form-group">
			<label for="trainNumber">Train number</label>
			<?php
			$trainNumberInput = [
			    'id' => 'trainNumber',
			    'name' => 'trainNumber',
			    'class' => 'form-control',
			];
			echo form_input($trainNumberInput,
			                isset($trainNumber) ? $trainNumber : null,
			                'required');
			?>
		</div>
		<div class="form-group">
    		<label for="departureDate">Departure date</label>
            <?php
			$inputDate = [
			    'id' => 'departureDate',
			    'name' => 'departureDate',
			    'class' => 'form-control',
			    'placeholder' => 'yyyymmdd'
			];
			echo form_input($inputDate,
			                set_value('departureDate'),
			                'required');
			?>
       	</div>
       	<div class="form-group">
            <button type="submit" class="btn btn-default btn-block">
    			Search
    		</button>
        </div>
		
	<?=form_close()?>
	
</div>

<br>

<div class="container">
	<?php if (isset($trainNumber)) :?>
    	<p>Train n° : <?=$trainNumber?></p>
    	<p>Date de circulation : <?=$dateCirculation->format('d/m/Y')?></p>
    	
    	<?php
    	if (isset($error)) :
    	   echo $error;
    	else :?>
        	<table>
        		<?php foreach($trajet as $row) :?>
        		<?php $vDateTime = new DateTime($row->arrival_time);?>
        		<tr>
                    <td><?=$row->stop_point->name?></td>
        			<td><?=$vDateTime->format('H:i')?></td>
        		</tr>
                <?php endforeach;?>
        	</table>
    	<?php endif;?>
	<?php endif;?>
</div>

</body>
</html>