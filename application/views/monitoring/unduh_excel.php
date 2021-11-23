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
						<th>Total Tunggakan</th>
						<th>Nama AO PPK</th>
						<th>Tanggal Monitoring</th>
						<th>Jenis Monitoring</th>
						<th>Tanggal Komitmen</th>
						<th>Komitmen</th>
						<th>Sumber Penyelesaian</th>
						<th>Nominal</th>
						<th>Auto Text</th>
						<th>Free Text</th>
						<th>Nama Agent ODC</th>
						<th>Tanggal Telpon</th>
						<th>Hasil</th>
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
							<td><?= number_format($d['plafond']) ?></td>
							<td><?= $d['outstanding'] ?></td>
							<td><?php $pk = $d['tunggakan_pokok']; echo number_format($pk); ?></td>
							<td><?php $bg = $d['tunggakan_bunga']; echo number_format($bg); ?></td>
							<td><?php $dn = $d['denda']; echo number_format($dn); ?></td>
							<td><?php $tt = $pk+$bg+$dn; echo number_format($tt); ?></td>
							<td><?= $d['name'] ?></td>
							<td><?= $a = substr($d['waktu_kunjungan'], 0,10) ?></td>
							<td><?= $d['monitoring'] ?></td>
							<td><?= date("d-m-Y", strtotime($d['tgl_komitmen'])) ?></td>
							<td><?= $d['komitmen'] ?></td>
							<td></td>
							<td><?= number_format($d['nominal']) ?></td>
							<td><?= $d['auto_text'] ?></td>
							<td><?= $d['free_text'] ?></td>
							<td></td>
							<td></td>
							<td></td>
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
						<th>Total Tunggakan</th>
						<th>Nama AO PPK</th>
						<th>Tanggal Monitoring</th>
						<th>Jenis Monitoring</th>
						<th>Tanggal Komitmen</th>
						<th>Komitmen</th>
						<th>Sumber Penyelesaian</th>
						<th>Nominal</th>
						<th>Auto Text</th>
						<th>Free Text</th>
						<th>Nama Agent ODC</th>
						<th>Tanggal Telpon</th>
						<th>Hasil</th>
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
							<td><?= date("d-m-Y", strtotime($d['tgl_wo'])) ?></td>
							<td><?= number_format($d['plafond']) ?></td>
							<td></td>
							<td><?php $bl = $d['bunga_lapor']; echo number_format($bl); ?></td>
							<td><?php $be = $d['bunga_ekstra']; echo number_format($be); ?></td>
							<td><?php $de = $d['denda']; echo number_format($de); ?></td>
							<td><?php $ttg = $bl+$be+$de; echo number_format($ttg); ?></td>
							<td><?= $d['name'] ?></td>
							<td><?= $a = substr($d['waktu_kunjungan'], 0,10) ?></td>
							<td><?= $d['monitoring'] ?></td>
							<td><?= $d['tgl_komitmen'] ?></td>
							<td><?= $d['komitmen'] ?></td>
							<td></td>
							<td><?= number_format($d['nominal']) ?></td>
							<td><?= $d['auto_text'] ?></td>
							<td><?= $d['free_text'] ?></td>
							<td></td>
							<td></td>
							<td></td>
						</tr>
					<?php endforeach ?>
					
				</tbody>
			</table>
			
		<?php endif ?>

		
	</div>
</div>