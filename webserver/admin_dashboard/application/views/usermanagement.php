 
    <!-- Start Welcome area -->  
                 
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mid_top_padding">
    <div class="breadcome-list">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="product-status-wrap">
                <?=form_open('Admin/user_search/')?>
                    <h4>Users Mangement</h4>
                    <div class="col-md-3 xs_padding">
                        <select class="form-control" name="type">
                            <option value="">..Select..</option>
                            <option value="deposit">Deposit</option>
                            <option value="withdrawal">Withdraw</option>
                        </select>
                    </div>
                    <div class="col-md-3 xs_padding">
                        <input type="text" name="username" class="form-control" placeholder="Name">
                    </div>
                    <div class="col-md-2 xs_padding">
                        <button type="submit" value="submit" name="submit" class="btn btn-success mobile-button">Filter</button>
                    </div>
                <?=form_close()?>

                <table id="mytable">
                    <thead>
                        <tr>
                            <!-- <th>No</th> -->
                            <th>User Name</th>
                            
                            <th>Email</th>
<<<<<<< HEAD
                           
=======
                 		<th>Type</th>          
>>>>>>> a9cb4f9ca1392d7e8f6b8269b7ee4b9a8340d974
                        </tr>
                    </thead>
                    <tbody id="message-tbody">
                    <?php
                    $i=1;
                        foreach($user->result() as $row):
                        ?>
                    <tr>



                     

                        <td><a href="Admin/user_detail/<?php echo $row->userid; ?>"><?php echo $row->username; ?></a></td>
                     
                        <td><?php echo $row->email; ?>
<<<<<<< HEAD
                        
                        
                                   
=======
                        <?php if(empty($row->withdrawal_id)) {?>
				
				<td>Deposit</td>
		<?php }else { ?>
                        <td>Withdrawal</td>
		<?php } ?>                                   
>>>>>>> a9cb4f9ca1392d7e8f6b8269b7ee4b9a8340d974

                    </tr>
                    <?php 
                        $i++;
                        endforeach; ?>
                    </tbody>
                </table>
    
            </div>
            </div>
        </div>
    </div>
</div>


      

        
       
    
    
