<div class="col-md-12 large_top_padding">

<?=form_open_multipart('Admin/update_setting/')?>
    <div class="col-md-4 padding_md setting-form">
        <h4 class="">Update Setting</h4>
          <div class="mid_padding">
          <input type="hidden" name="id" value="<?=$this->session->userdata('id')?>">
            <label>Email</label>
            <input type="text" name="username" class="form-control" value="<?=$admindata->username?>" required>

            <label>New Password</label>
            <input type="password" name="password" class="form-control" required>

            <label>Confirm Password</label>
            <input type="password" name="password" class="form-control" required>
          </div>
    
        <div class="bottompadding_md right">
            <button class="btn btn-primary" onclick="return confirm('Are you sure to save changes?')">Save changes</button>
           
        </div>
    </div>
<?=form_close()?> 
</div>