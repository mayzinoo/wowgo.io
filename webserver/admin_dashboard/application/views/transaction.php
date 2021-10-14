<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mid_top_padding">
    <div class="breadcome-list">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="product-status-wrap">
		<?=form_open('Admin/transaction_search')?>
                    <h4>Transaction</h4>
                    <div class="col-md-6 xs_padding">
                        <select class="form-control" name="type">
                        <option value="">..Select..</option>
                        <option value="deposit">Deposit</option>
                        <option value="withdrawal">Withdraw</option>
                        </select>
                    </div>
                    <div class="col-md-2 xs_padding">
                        <button type="submit" value="submit" name="submit" class="btn btn-success">Filter</button>
                    </div>
		<?=form_close()?>

                    <table>
                        <tr>
			<th>Username</th>
                            <th>Tx Hash</th>
                            
                            <th>Transaction Type</th>
                            <th>Transaction Status</th>
                            <th>Amount</th>
				<th>Date</th>
                        </tr>
		<?php foreach($transactiondata->result() as $row): ?>
                        <tr>
                            <td><?php echo $row->name; ?></td>
                           <?php if(empty($row->withdrawal_id)) { ?>
				<td><?php echo $row->ethereum_deposit_txid; ?></td>
				<td>Deposit</td>
			<?php }else{ ?>
				<td><?php echo $row->withdrawal_id; ?>	
				<td>Withdrawal</td>
		<?php	} ?>
                            <td><p style="color:green;">Success</p></td>
                            <td><?php echo $row->amount; ?></td>
				<td><?php echo $row->created; ?></td>
                  
                        </tr>
		<?php endforeach; ?>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
                   
                
