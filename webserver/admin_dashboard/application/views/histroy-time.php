<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mid_top_padding">
    <div class="breadcome-list">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="product-status-wrap">
                    <h4>User Login History Time</h4>                            

                    <table>
                        <tr>
                            <th>User</th>
                            <th>Time</th>
                            <th>IP Address</th>
                            <th>Location</th>

                        </tr>
		<?php foreach($historytime->result() as $row): ?>
                        <tr>                                    
                            <td><?php echo $row->name; ?></td>
                            <td><?php echo $row->login_time; ?></td>
                            <td><?php echo $row->ip; ?></td>                                    
                            <td><?php echo $row->location; ?></td>
                        </tr>
		<?php endforeach; ?>
                       
                        </tr>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
                   
                
