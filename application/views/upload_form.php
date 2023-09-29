<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<title>Upload File</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>

<body>
	<div class="container">
		<h2 class="text-center">Upload Multiple Files</h2>

		<?php if (isset($error)) { ?>
			<div class="alert alert-danger"><?= $error; ?></div>
		<?php } ?>

		<?= form_open_multipart('upload/do_upload'); ?>
		<div class="form-group">
			<label for="userfile">Pilih File:</label>
			<input type="file" name="userfile[]" id="userfile" class="form-control" multiple />
		</div>
		<input type="submit" value="Upload" class="btn btn-primary" />
		</form>

		<h3 class="text-center">Daftar File yang Diunggah</h3>

		<?php if (empty($files)) { ?>
			<p>Tidak ada file yang diunggah.</p>
		<?php } else { ?>
			<table class="table">
				<thead>
					<tr>
						<th>Nama File</th>
						<th>Aksi</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($files as $file) { ?>
						<tr>
							<td><?= $file->file_name; ?></td>
							<td>
								<a href="<?= base_url('upload/delete/' . $file->id); ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus file ini?')">Hapus</a>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		<?php } ?>
		<footer class="footer">
			<div class="container text-center">
				<p>&copy; <?= date('Y'); ?> Muhamad Rifqi Hilmy Apriadi|FSWD</p>
			</div>
		</footer>
	</div>
</body>

</html>