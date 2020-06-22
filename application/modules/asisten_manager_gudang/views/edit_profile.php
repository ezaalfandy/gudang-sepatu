<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
        <?php
            if($this->session->flashdata('status') === 'success')
            {
            echo '
                <div class="alert alert-success">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="material-icons">close</i>
                </button>
                <span>
                    <b> Success - </b> '.$this->session->userdata('message').'</span>
                </div>
            ';
            }elseif ($this->session->flashdata('status') === 'failed') {
            echo '
                <div class="alert alert-danger">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="material-icons">close</i>
                </button>
                <span>
                    <b> Failed- </b> '.$this->session->userdata('message').'</span>
                </div>
            ';
            }
        ?>
        </div>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header card-header-icon card-header-primary">
                    <div class="card-icon">
                        <i class="material-icons">perm_identity</i>
                    </div>
                    <h4 class="card-title">Edit Profile
                    </h4>
                </div>
                <form action="<?= base_url('asisten-manager-gudang/edit-profile')?>" method="post" accept-charset="utf-8"
                novalidate="novalidate" id="formEditProfile">
                    <div class="card-body ">
                        <div class="form-group">
                            <label for="edit_nama">Nama</label>
                            <input type="text" name="edit_nama" 
                            value="<?= (set_value('nama') == NULL)?  $this->session->userdata('nama') : set_value('nama');
                             ?>" id="edit_nama"
                                class="form-control" required="true" />
                        </div>

                        <div class="form-group">
                            <label for="edit_username">Username</label>
                            <input type="text" name="edit_username" 
                            value="<?= (set_value('username') == NULL)?  $this->session->userdata('username') : set_value('username');
                             ?>" id="edit_username"
                                class="form-control" required="true" />
                        </div>

                        <div class="form-group">
                            <label for="password_lama">Password Lama</label>
                            <input type="password" name="password_lama" 
                            value="" id="password_lama"
                                class="form-control" required="true" />
                        </div>
                        
                        <div class="form-group">
                            <label for="edit_password">Password Baru (kosongkan bila tidak perlu)</label>
                            <input type="password" name="edit_password" 
                            value="" id="edit_password"
                                class="form-control"/>
                        </div>
                        
                        <div class="form-group">
                            <label for="edit_retype_password">Ketik Ulang Password Baru</label>
                            <input type="password" name="edit_retype_password" 
                            value="" id="edit_retype_password"
                                class="form-control" equalTo="#edit_password"/>
                        </div>
                    
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-fill btn-primary">Ubah Password</button>
                    </div>
                </form>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-profile">
                <div class="card-avatar">
                    <img src="<?= base_url('uploads/admin/').$this->session->userdata('foto');?>" />
                </div>
                <div class="card-body">
                    <h6 class="card-category text-gray">Modern Shoes</h6>
                    <h4 class="card-title"><?= $this->session->userdata('nama')?></h4>
                    <a href="#pablo" class="btn btn-rose btn-round">Ganti foto</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    $(document).ready(function () {
        md.setFormValidation($('#formEditProfile'));
    });
</script>