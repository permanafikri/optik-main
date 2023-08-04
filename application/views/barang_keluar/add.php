<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-bottom-primary">
            <div class="card-header bg-white py-3">
                <div class="row">
                    <div class="col">
                        <h4 class="h5 align-middle m-0 font-weight-bold text-primary">
                            Form Input Barang Keluar
                        </h4>
                    </div>
                    <div class="col-auto">
                        <a href="<?= base_url('barangkeluar') ?>" class="btn btn-sm btn-secondary btn-icon-split">
                            <span class="icon">
                                <i class="fa fa-arrow-left"></i>
                            </span>
                            <span class="text">
                                Kembali
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <?= $this->session->flashdata('pesan'); ?>
                <?= form_open(); ?>
                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="id_barang_keluar">ID Transaksi Barang Keluar</label>
                    <div class="col-md-4">
                        <input hidden value="<?= $user; ?>" name="barang[0][user_id]" type="text" readonly="readonly" class="form-control">
                        <input value="<?= $id_barang_keluar; ?>" name="barang[0][id_barang_keluar]" type="text" readonly="readonly" class="form-control">
                        <?= form_error('id_barang_keluar', '<small class="text-danger">', '</small>'); ?>
                    </div>
                    <div class="input-group-append">
                        <button type="button" class="btn btn-primary btn-sm mr-2" onclick="addBarang()"><i class="fa fa-plus"></i>Tambah Barang</button>
                        <button type="button" class="btn btn-warning btn-sm" onclick="cancelForm()">Cancel</button>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="tanggal_keluar">Tanggal Keluar</label>
                    <div class="col-md-4">
                        <input value="<?= set_value('tanggal_keluar', date('Y-m-d')); ?>" name="barang[0][tanggal_keluar]" id="tanggal_keluar" type="text" class="form-control date" placeholder="Tanggal Masuk...">
                        <?= form_error('tanggal_keluar', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div id="form-container">


                    <div class="barang">
                        <div class="row form-group">
                            <label class="col-md-4 text-md-right" for="barang_id">Barang</label>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <select name="barang[0][barang_id]" id="barang_id" class="custom-select">
                                        <option value="" selected disabled>Pilih Barang</option>
                                        <?php foreach ($barang as $b) : ?>
                                            <option value="<?= $b['id_barang'] ?>"><?= $b['id_barang'] . ' | ' . $b['nama_barang'] ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="input-group-append">
                                        <a class="btn btn-primary" href="<?= base_url('barang/add'); ?>"><i class="fa fa-plus"></i></a>
                                    </div>
                                </div>
                                <?= form_error('barang_id', '<small class="text-danger">', '</small>'); ?>
                            </div>
                        </div>

                        <!-- <div class="row form-group">
                            <label class="col-md-4 text-md-right" for="stok">Stok</label>
                            <div class="col-md-5">
                                <input readonly="readonly" id="stok" type="number" class="form-control">
                            </div>
                        </div> -->
                        <div class="row form-group">
                            <label class="col-md-4 text-md-right" for="jumlah_keluar">Jumlah Keluar</label>
                            <div class="col-md-5">
                                <div class="input-group">
                                    <input value="<?= set_value('jumlah_keluar'); ?>" name="barang[0][jumlah_keluar]" id="jumlah_keluar" type="number" class="form-control" placeholder="Jumlah Keluar...">
                                    <div class="input-group-append">
                                        <span class="input-group-text" id="satuan">Satuan</span>
                                    </div>
                                </div>
                                <?= form_error('jumlah_keluar', '<small class="text-danger">', '</small>'); ?>
                            </div>
                        </div>
                        <!-- <div class="row form-group">
                            <label class="col-md-4 text-md-right" for="total_stok">Total Stok</label>
                            <div class="col-md-5">
                                <input readonly="readonly" id="total_stok" type="number" class="form-control">
                            </div>
                        </div> -->
                    </div>
                </div>
                <div class="row form-group">
                    <div class="col offset-md-4">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="reset" class="btn btn-secondary">Reset</button>
                    </div>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>
</div>


<script>
    var counter = 1;

    function addBarang() {
        var div = document.createElement('div');
        div.className = 'barang';
        div.innerHTML = `
        <input hidden value="<?= $user; ?>" name="barang[${counter}][user_id]" type="text" readonly="readonly" class="form-control">
        <input hidden value="<?= $this->admin->ubahKode($id_barang_keluar); ?>" name="barang[${counter}][id_barang_keluar]" type="text" readonly="readonly" class="form-control">
        <input hidden value="<?= set_value('tanggal_keluar', date('Y-m-d')); ?>" name="barang[${counter}][tanggal_keluar]" id="tanggal_keluar" type="text" class="form-control date" placeholder="Tanggal Masuk...">
        <div class="row form-group mt-2">
                    <label class="col-md-4 text-md-right" for="barang_id">Barang</label>
                    <div class="col-md-5">
                        <div class="input-group">
                            <select name="barang[${counter}][barang_id]" id="barang_id" class="custom-select">
                                <option value="" selected disabled>Pilih Barang</option>
                                <?php foreach ($barang as $b) : ?>
                                    <option value="<?= $b['id_barang'] ?>"><?= $b['id_barang'] . ' | ' . $b['nama_barang'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <div class="input-group-append">
                                <a class="btn btn-primary" href="<?= base_url('barang/add'); ?>"><i class="fa fa-plus"></i></a>
                            </div>
                        </div>
                        <?= form_error('barang_id', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
                <div class="row form-group">
                    <label class="col-md-4 text-md-right" for="jumlah_keluar">Jumlah Keluar</label>
                    <div class="col-md-5">
                        <div class="input-group">
                            <input value="<?= set_value('jumlah_keluar'); ?>" name="barang[${counter}][jumlah_keluar]" id="jumlah_keluar" type="number" class="form-control" placeholder="Jumlah Keluar...">
                            <div class="input-group-append">
                                <span class="input-group-text" id="satuan">Satuan</span>
                            </div>
                        </div>
                        <?= form_error('jumlah_keluar', '<small class="text-danger">', '</small>'); ?>
                    </div>
                </div>
        `;
        document.querySelector('#form-container').appendChild(div);
        counter++;
    }

    function cancelForm() {
        // Hapus semua elemen "barang" kecuali yang pertama
        var forms = document.querySelectorAll('.barang');
        for (var i = 1; i < forms.length; i++) {
            forms[i].remove();
        }
        // Reset counter menjadi 1
        counter = 1;
    }
</script>