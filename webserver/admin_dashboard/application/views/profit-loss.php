]<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mid_top_padding">
    <div class="breadcome-list">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="product-status-wrap">
                    <?=form_open('Admin/profitloss_search/')?>
                        <h4>Personal Profit & Loss</h4>
                        <div class="col-md-4">
                            <input type="text" name="username" class="form-control" placeholder="Name">
                        </div>
                        <div class="col-md-4 xs_padding">
                            <select class="form-control" name="type">
                            <option value="">..Select..</option>
<<<<<<< HEAD
                            <option value="deposit">Profit</option>
                            <option value="widthdraw">Loss</option>
=======
                            <option value="profit">Profit</option>
                            <option value="loss">Loss</option>
>>>>>>> a9cb4f9ca1392d7e8f6b8269b7ee4b9a8340d974
                            </select>
                        </div>
                        <div class="col-md-2 xs_padding">
                            <button type="submit" value="submit" name="submit" class="btn btn-success mobile-button">Filter</button>
                        </div>
                    <?=form_close()?>
		
                    <table>
                        <tr>
                            <th>USER</th>
                            <th>BET</th>
                            
                            <th>Profit or Loss</th>
			<th>Amount</th>
			   <th>Date</th>
                        </tr>
			<?php
                    $i=1;
                        foreach($profitdata->result() as $row):
                        ?>
                        <tr>
                            <td><?php echo $row->name; ?></td>
                            <td><?php echo $row->bet; ?></td>
			<?php	if(empty($row->cash_out)){ ?>
				<td>Loss</td>
				<td><?php echo $row->bet; ?></td>
		<?php	}else{ ?>
			<td>Profit</td>
			<td><?php echo $row->cash_out; ?></td>
		<?php	 } ?>
                            
			
		
                            <td><?php echo $row->created; ?></td>
                        </tr>
			<?php 
                        $i++;
                        endforeach; ?>
                    </table>
	
                </div>
<<<<<<< HEAD

=======
<?php echo $this->pagination->create_links(); ?>
>>>>>>> a9cb4f9ca1392d7e8f6b8269b7ee4b9a8340d974
            </div>
        </div>
    </div>
</div>

                
