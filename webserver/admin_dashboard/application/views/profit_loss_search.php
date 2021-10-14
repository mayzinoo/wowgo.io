<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mid_top_padding">
    <div class="breadcome-list">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="product-status-wrap">
                    <h4>Searching Users</h4>
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
                        foreach($userlist->result() as $row):
                        ?>
                    <tr>
                        <td><?php echo $row->name; ?></td>
                        <td><?php echo $row->bet; ?></a></td>
                        <?php if(empty($row->cash_out)){ ?>
                        	<td>Loss</td>
                        	<td><?php echo $row->bet; ?></td>
                        <?php }else{ ?>
                        	<td>Profit</td>
                        	<td><?php echo $row->cash_out; ?></td>
                        <?php } ?>
                        
                        <td><?php echo $row->created;?></td>                                               
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
