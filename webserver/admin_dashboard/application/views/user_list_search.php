<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mid_top_padding">
    <div class="breadcome-list">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="product-status-wrap">
                    <h4>Searching Users</h4>
                <table>    
                    <tr>
                        <th>No</th>
                        <th>User Name</th>
                        <th>Email</th>
                        <th>Type</th>
                              
                    </tr>
                    <?php
                    $i=1;
                        foreach($userlist->result() as $row):
                        ?>
                    <tr>
                        <td><?php echo $i; ?></td>
                        <td><a href="Admin/user_detail/<?php echo $row->userid; ?>"><?php echo $row->name; ?></a></td>
                        <td><?php echo $row->email; ?></td>
                        <?php if(empty($row->withdrawal_id)){ ?>                                         
				<td>Deposit</td>
			<?php }else{ ?>
				<td>Withdrawal</td>
		 	<?php } ?>
                    </tr>
                    <?php 
                        $i++;
                        endforeach; ?>
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
