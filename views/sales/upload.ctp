
<table class="table table-bordered">
	<thead>
		<tr>
			<th>Item Code</th>
			<th>Item Name</th>
			<th>Qty Sold</th>
			<th>Unit Price</th>
			<th>Amount Payable</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($data as $d):?>
		<tr>
			<td><?php echo $d['id'];?></td>
			<td><?php echo $d['desc'];?></td>
			<td><?php echo $d['qtySold'];?></td>
			<td><?php echo $d['unitPrice'];?></td>
			<td><?php echo $d['amountPayable'];?></td>
		</tr>
		<?php endforeach;?>
	</tbody>
</table>