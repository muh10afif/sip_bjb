<div class="row">
	<div class="col-md-12">

		<?php if ($aktif == 'npl'): ?>
			<h3>Debitur NPL</h3>

			<table border="1">
				<thead>
					<tr>
						<th>No</th>
						<th>Kantor Wilayah</th>
						<th>Kantor Cabang Induk</th>
						<th>Kantor Cabang</th>
						<th>Segmen</th>
						<th>Loan Type</th>
						<th>Deal Reff</th>
						<th>Nama Debitur</th>
						<th>Kolektibilitas</th>
						<th>DPD</th>
						<th>Plafond</th>
						<th>Outstanding</th>
						<th>Tunggakan Pokok</th>
						<th>Tunggakan Bunga</th>
						<th>Denda</th>
						<th>Nama AO PPK</th>
					</tr>
				</thead>
				<tbody>
					<?php $no=1; foreach ($data_deb as $d): ?>
						<tr>
							<td><?= $no++ ?></td>
							<td><?= $d['kanwil'] ?></td>
							<td><?= $d['cabang_induk'] ?></td>
							<td><?= $d['kantor'] ?></td>
							<td><?= $d['segmen'] ?></td>
							<td><?= $d['loan_type'] ?></td>
							<td><?= $d['deal_reff'] ?></td>
							<td><?= $d['nama'] ?></td>
							<td><?= $d['kolektibilitas'] ?></td>
							<td><?= $d['dpd'] ?></td>
							<td><?= $d['plafond'] ?></td>
							<td><?= $d['outstanding'] ?></td>
							<td><?= $d['tunggakan_pokok'] ?></td>
							<td><?= $d['tunggakan_bunga'] ?></td>
							<td><?= $d['denda'] ?></td>
							<td><?= $d['name'] ?></td>
						</tr>
					<?php endforeach ?>
					
				</tbody>
			</table>

		<?php else: ?>

			<h3>Debitur WO</h3>

			<table border="1">
				<thead>
					<tr>
						<th>No</th>
						<th>Kantor Wilayah</th>
						<th>Kantor Cabang Induk</th>
						<th>Kantor Cabang</th>
						<th>Segmen</th>
						<th>Loan Type</th>
						<th>Deal Reff</th>
						<th>Nama Debitur</th>
						<th>Status</th>
						<th>Tanggal WO</th>
						<th>Plafond</th>
						<th>Pokok Pelaporan</th>
						<th>Bunga Pelaporan</th>
						<th>Bunga Extra Plus</th>
						<th>Denda Pelaporan</th>
						<th>Nama AO PPK</th>
					</tr>
				</thead>
				<tbody>
					<?php $no=1; foreach ($data_deb as $d): ?>
						<tr>
							<td><?= $no++ ?></td>
							<td><?= $d['kanwil'] ?></td>
							<td><?= $d['cabang_induk'] ?></td>
							<td><?= $d['kantor'] ?></td>
							<td><?= $d['segmen'] ?></td>
							<td><?= $d['loan_type'] ?></td>
							<td><?= $d['deal_reff'] ?></td>
							<td><?= $d['nama'] ?></td>
							<td><?= $d['jenis_debitur'] ?></td>
							<td><?= $d['tgl_wo'] ?></td>
							<td><?= $d['plafond'] ?></td>
							<td></td>
							<td><?= $d['bunga_lapor'] ?></td>
							<td></td>
							<td><?= $d['denda'] ?></td>
							<td><?= $d['name'] ?></td>
						</tr>
					<?php endforeach ?>
					
				</tbody>
			</table>
			
		<?php endif ?>

		
	</div>
</div>