<?php if(!empty($result)){?> <!-- Cek data -->
<link href="<?= base_url('assets/');?>css/sb-admin-2.min.css" rel="stylesheet">
<h1 class="text-center">Redwash Report</h1>
<?php if(!empty($start)){ ?> <!-- Cek tanggal untuk generate PDF -->
	<a href="<?= base_url().'admin/grtReport?start='.$start.'&end='.$end;?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm float-right"><i class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
<?php } ?>
<table class="table table-borderless table-sm">
	<tr>
		<td width="220px"><span class="gt">Month</span></td>
		<td width="20px"><span class="gt">:</span></td>
		<?php 
			$mArray = array();
			foreach ($date as $key => $m) {
				$mArray[] = ($m->month);
			}
			$mArray = array_unique($mArray)
		?>
		<!-- Menggabung elemen array dengan string -->
		<td><span class="gt"><?= implode(', ',$mArray); ?></span></td>
	</tr>
	<tr>
		<td width="220px"><span class="gt">Year</span></td>
		<td width="20px"><span class="gt">:</span></td>
		<?php 
			$yArray = array();
			foreach ($date as $key => $y) {
				$yArray[] = ($y->year);
			}
			$yArray = array_unique($yArray)
		?>
		<!-- Menggabung elemen array dengan string -->
		<td><span class="gt"><?= implode(', ',$yArray); ?></span></td>
	</tr>
	<tr>
		<td width="220px"><span class="gt">Total Income</span></td>
		<td width="20px"><span class="gt">:</span></td>
		<td><span class="gt">Rp. <?= number_format($total->tcost, 0, ",", "."); ?></span></td>
	</tr>
	<tr>
		<td width="220px"><span class="gt">Number of transactions</span></td>
		<td width="20px"><span class="gt">:</span></td>
		<td><span class="gt"><?= $total->tbook; ?></span></td>
	</tr>
</table>

<div class="table align-center">
	<table class="table table-bordered" width="100%" cellspacing="0">
		<thead>
		<tr>
			<th>Code Booking</th>
			<th>No Plat</th>
			<th>Pay</th>
			<th>Total Cost</th>
			<th>Change</th>
			<th>Cashier</th>
			<th>Date</th>
		</tr>
		</thead>
		<tbody>
		<?php foreach ($result as $key => $rs):?>
		<tr>
			<td><?= $rs['code_booking']?></td>
			<td><?= $rs['noplat']?></td>
			<td><?= $rs['pay']?></td>
			<td><?= $rs['tot_cost']?></td>
			<td><?= $rs['ch_cost']?></td>
			<td><?= $rs['cashier']?></td>
			<td><?= $rs['ctime']?></td>
		</tr>
		<?php endforeach;?>
	</tbody>
</table>
</div>
<?php }else{?>
<div><h3 class="text-center text-danger">Cannot load data</h3>
</div>
<?php }?>