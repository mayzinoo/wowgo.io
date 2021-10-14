<<<<<<< HEAD

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mid_top_padding">
    <div class="breadcome-list">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="product-status-wrap">
                    <div class="col-md-4">
                        <h5>User Detail</h5>
                        <div class="userdetail">
                            <table>
                                <tr>
                                    <td>ID</td>
                                    <td><?php echo $userdata->userid; ?></td>
                                </tr>
                                <tr>
                                    <td>Name</td>
                                    <td><?php echo $userdata->username; ?></td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td><?php echo $userdata->email; ?></td>
                                </tr>
                             
                                <tr>
                                    <td>Referral System</td>
                                    <td>
                                        <?php if($userdata->referral=="yes") { ?>
                                        <button class="btn btn-success btn-xs"> on </button>
                                        <?php }else{ ?>
					No
					<?php } ?>
                                    </td>
                                </tr> 
                                <tr>
                                    <td>Commission Rate</td>
                                    <td><?php echo $userdata->rate; ?></td>
                                </tr>
				<tr>
					<td>User Action</td>
				<?php if($userdata->status=="block") { ?>
					<td><p style="color:red">Block</p></td>
				<?php }else{ ?>
					<td><p style="color:yellow">Suspend</p></td>
				<?php } ?>
				</tr>
				<tr>
				<td>Deposit</td>
				<td><?php echo $deposit->deposit; ?></td>
				</tr>                                     
				<tr>
				<td>Withdraws</td>
				<td><?php echo $withdraw->withdraw; ?></td>
				</tr>
				
				<tr>	
					<td>Net Profit</td>
					<td><?php echo $netprofit->netprofit; ?></td>
				</tr>
                            </table>
                            
                        </div>
                        <div class="mid_top_padding useraction">
                            <h5>User Action</h5>
                            <div class="userdetail"> 
                                <div id="notif"></div>
                                <div class="row">
                                <form class="form-horizontal">


                                    <fieldset>
                                        <input type="hidden" name="id" id="id" value="<?php echo $this->uri->segment(3); ?>">
                                        <input type="hidden" name="name" id="name" value="<?php echo $userdata->name; ?>">
                                        <input type="hidden" name="address" id="address" value="<?php echo $userdata->address; ?>">
                                        <input type="hidden" name="type" id="type" value="<?php echo $userdata->type; ?>">
                                        <input type="hidden" name="referral_action" id="referral_action" value="<?php echo $userdata->referral_action; ?>">
                                        <input type="hidden" name="referral_fee" id="referral_fee" value="<?php echo $userdata->referral_fee; ?>">

                                            <div class="col-md-8 xs_padding">

                                            <div class="col-md-8">
                                                
                                                <select name="action" id="action" class="form-control">
                                                    <option value="suspend">Suspend</option>
                                                    <option value="block">Block</option>
                                                </select>
                                                
                                            </div>
                                            <div class="col-md-4">

                                                <button type="button" id="submit" class="btn btn-primary mobile-button" onclick="return confirm('Are you sure to Update?')">Submit</button>


                                            </div> 
                                    </fieldset>
                                </form> 
                                </div>                                                        
                            </div>
                        </div>
                        <div class="mid_top_padding blockaction">
                            <h5>REFERRAL System</h5>
                            <div class="userdetail"> 
                                <div class="row">
                                <form class="form-horizontal">
                                <input type="hidden" name="id" id="id" value="<?php echo $this->uri->segment(3); ?>">
                                    <div class="col-md-8 xs_padding">
                                        <select name="referralfee" id="referralfee" class="form-control">
                                            <option value="">..Select..</option>
                                            <option value="0.1">0.1</option>
                                            <option value="0.15">0.15</option>
                                            <option value="0.2">0.2</option>
                                            <option value="0.25">0.25</option>
                                            <option value="0.45">0.45</option>
                                            <option value="0.5">0.5</option>
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="button" id="submit_rate" class="btn btn-primary mobile-button" onclick="return confirm('Are you sure to Update?')">Submit</button>
                                    </div>
                                </form>   
                                </div>                     
                            </div>
                        </div>
                        <div class="mid_top_padding blockaction">
                            <h5>REFERRAL</h5>
                            <ul class="tabs">
                                  <li class="active"><a href="#">Overview</a></li>
                                  <li><a href="#">Referral Map</a></li>
                                  <!-- add as many as you want -->
                            </ul>
                            <div id="tabcontainer">
                                  <section>
                                
                                    <div class="mid_top_padding history">
                                    <table class="table table-responsive">
                                        <tr>
                                            <td class="a1">1st Recommendee / Total</td>
                                            <td class="a2">8/9</td>
                                            <td class="a1">Available amount</td>
                                            <td class="a2">24.54</td>
                                        </tr>
                                    </table>
                                    </div>
                                    <div class="small_top_padding history">
                                    <table class="table table-responsive">
                                        <tr>
                                            <td class="a1">Referal URL</td>
                                            <td class="a2">wowgo.com/register</td>
                                            <td class="a1">Copy</td>
                                        </tr>
                                    </table>
                                    </div>
                                    <div class="small_top_padding history">
                                        <p>BREAKDOWN</p>
                                        <table class="table table-responsive">
                                            <tr class="black">                                           
                                                <td>TYPE</td>
                                                <td>CRUSH</td>
                                            </tr>
                                            <tr class="a41">
                                                <td>Profit</td>
                                                <td>8998.54 CRUSH</td>
                                            </tr>
                                            <tr class="a42">
                                                <td>Withdraw</td>
                                                <td>8998.54 CRUSH</td>
                                            </tr>
                                            <tr class="a41">
                                                <td>Available Amount</td>
                                                <td>8998.54 CRUSH</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="small_top_padding">
                                        <p>Referral Affiliated (0.15%)</p>
                                        <table class="table table-responsive">
                                            <tr class="black">                                           
                                                <td>ID</td>
                                                <td>Betting Referral's Profit</td>
                                                <td>Registered Date</td>
                                            </tr>
                                            <tr class="a41">
                                                <td>BAIE</td>
                                                <td>152.71</td>
                                                <td>19-9-18 13:32</td>
                                            </tr>
                                            <tr class="a42">
                                                <td>QW7500</td>
                                                <td>0.03</td>
                                                <td>19-9-18 13:32</td>
                                            </tr>
                                            <tr class="a41">
                                                <td>QW7600</td>
                                                <td>0</td>
                                                <td>19-9-18 13:32</td>
                                            </tr>
                                            <tr class="a42">
                                                <td>JAHONG</td>
                                                <td>0</td>
                                                <td>19-9-18 13:32</td>
                                            </tr>
                                            <tr class="a41">
                                                <td>ZOOM</td>
                                                <td>0</td>
                                                <td>19-9-18 13:32</td>
                                            </tr>
                                        </table>
                                    </div>
                                    
                                  </section>
                                  <section>
                                    <div class="mid_top_padding">
                                        <div class="tree">
                                            <ul>
                                                <li>
                                                    GAYA
                                                    <ul>    
                                                        <li>
                                                            1 EMUKWS (0)
                                                        </li>
                                                        <li>
                                                            1 EMUKWS (0)
                                                        </li>
                                                        <li>
                                                            1 EMUKWS (0)
                                                            <ul>
                                                                <li>2 EMUKWS (0)</li>
                                                            </ul>
                                                        </li>
                                                        <li>
                                                            1 EMUKWS (0)
                                                        </li>
                                                        <li>
                                                            1 EMUKWS (0)
                                                        </li>
                                                        <li>
                                                            1 EMUKWS (0)
                                                        </li>
                                                        <li>
                                                            1 EMUKWS (0)
                                                        </li>
                                                        <li>
                                                            1 EMUKWS (0)
                                                        </li>   
                                                        
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                  </section>
                                  <!-- add as many as you want -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 history-time">                        
                            <h5>Login History Time</h5>                            
                            <div class="userdetail historytime">
                            <table class="table table-responsive">
                                <tr>
                                    <th>User</th>
                                    <th>Time</th>
                                    <th>IP Address</th>
                                    <th>Location</th>

                                </tr>
		<?php foreach($userlog->result() as $row): ?>
                                <tr>                                    
                                    <td><?php echo $row->name; ?></td>
                                    <td><?php echo $row->login_time; ?></td>
                                    <td><?php echo $row->ip; ?></td>                                    
                                    <td><?php echo $row->location; ?></td>
                                </tr>                              
				<?php endforeach; ?>                                  
                            </table>
                        </div><!-- history time -->
                        <h5 class="mid_top_padding xs_padding">Transaction</h5>
                        <div class="userdetail transaction">
                        
                        <table class="table table-responsive">
                            <tr>
                         
                                <th>Tx Hash</th>
                         
                                <th>Transaction Type</th>
                                <th>Transaction Status</th>
                                <th>Amount</th>
			<th>Date</th>
                            </tr>
			<?php foreach($transaction->result() as $row): ?>
                            <tr>

                         
                                <?php if(empty($row->withdrawal_id)) { ?>
					<td><?php echo $row->ethereum_deposit_txid; ?>
					<td>Deposit</td>
			<?php 	}else{ ?>
					<td><?php echo $row->withdrawal_id; ?></td>
					<td>Withdrawal</td>
				<?php } ?>
                                <td><p style="color:green">Success</p></td>
                                <td><?php echo $row->amount; ?></td>
                                <td><?php echo $row->created; ?></td>
                                
                           
                           
                            </tr>
			<?php endforeach; ?>
                        </table>
                        </div><!-- transaction -->
                        <div class="mid_top_padding">
                            <h5>Profit & Loss</h5>
                            <div class="userdetail profitloss transaction">
                            <table class="table table-responsive">
                                <tr>
                                    <th>USER</th>
                                    <th>BET</th>
                                    <th>Profit or Loss</th>
                                    <th>Amount</th>
				
                                </tr>
				<?php foreach($profitdata->result() as $row):
			?>
                                <tr>
                                    <td><?php echo $row->name; ?></td>
                                    <td><?php echo $row->bet; ?></td>
                                   <?php if(empty($row->cash_out)){ ?>
				<td>Loss</td>
                                    <td><?php echo $row->bet; ?></td>
				<?php }else{ ?>
				<td>Profit</td>
				<td><?php echo $row->cash_out; ?></td>
				<?php } ?>
				
                                </tr>
			<?php endforeach; ?>
                            </table>
                        </div>
                        </div>  
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>           


    
=======

<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mid_top_padding">
    <div class="breadcome-list">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="product-status-wrap">
                    <div class="col-md-4">
                        <h5>User Detail</h5>
                        <div class="userdetail">
                            <table>
                                <tr>
                                    <td>ID</td>
                                    <td><?php echo $userdata->userid; ?></td>
                                </tr>
                                <tr>
                                    <td>Name</td>
                                    <td><?php echo $userdata->username; ?></td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td><?php echo $userdata->email; ?></td>
                                </tr>
                             
                                <tr>
                                    <td>Referral System</td>
                                    <td>
                                        <?php if($userdata->referral=="yes") { ?>
                                        <button class="btn btn-success btn-xs"> on </button>
                                        <?php }else{ ?>
					No
					<?php } ?>
                                    </td>
                                </tr> 
                                <tr>
                                    <td>Commission Rate</td>
                                    <td><?php echo $userdata->rate; ?></td>
                                </tr>
				<tr>
					<td>User Action</td>
				<?php if($userdata->status=="block") { ?>
					<td><p style="color:red">Block</p></td>
				<?php }else{ ?>
					<td><p style="color:yellow">Suspend</p></td>
				<?php } ?>
				</tr>
				<tr>
				<td>Deposit</td>
				<td><?php echo $deposit->deposit; ?></td>
				</tr>                                     
				<tr>
				<td>Withdraws</td>
				<td><?php echo $withdraw->withdraw; ?></td>
				</tr>
				
				<tr>	
					<td>Net Profit</td>
					<td><?php echo $netprofit->netprofit; ?></td>
				</tr>
                            </table>
                            
                        </div>
                        <div class="mid_top_padding useraction">
                            <h5>User Action</h5>
                            <div class="userdetail"> 
                                <div id="notif"></div>
                                <div class="row">
                                <form class="form-horizontal">


                                    <fieldset>
                                        <input type="hidden" name="id" id="id" value="<?php echo $this->uri->segment(3); ?>">
                                        <input type="hidden" name="name" id="name" value="<?php echo $userdata->name; ?>">
                                        <input type="hidden" name="address" id="address" value="<?php echo $userdata->address; ?>">
                                        <input type="hidden" name="type" id="type" value="<?php echo $userdata->type; ?>">
                                        <input type="hidden" name="referral_action" id="referral_action" value="<?php echo $userdata->referral_action; ?>">
                                        <input type="hidden" name="referral_fee" id="referral_fee" value="<?php echo $userdata->referral_fee; ?>">

                                            <div class="col-md-8 xs_padding">

                                            <div class="col-md-8">
                                                
                                                <select name="action" id="action" class="form-control">
                                                    <option value="suspend">Suspend</option>
                                                    <option value="block">Block</option>
                                                </select>
                                                
                                            </div>
                                            <div class="col-md-4">

                                                <button type="button" id="submit" class="btn btn-primary mobile-button" onclick="return confirm('Are you sure to Update?')">Submit</button>


                                            </div> 
                                    </fieldset>
                                </form> 
                                </div>                                                        
                            </div>
                        </div>
                        <div class="mid_top_padding blockaction">
                            <h5>REFERRAL System</h5>
                            <div class="userdetail"> 
                                <div class="row">
                                <form class="form-horizontal">
                                <input type="hidden" name="id" id="id" value="<?php echo $this->uri->segment(3); ?>">
                                    <div class="col-md-8 xs_padding">
                                        <select name="referralfee" id="referralfee" class="form-control">
                                            <option value="">..Select..</option>
                                    <option value="0.1" <?php if($userdata->rate=='0.1')echo  ' selected="selected"' ; ?>>0.1</option>

                                    <option value="0.15" <?php if($userdata->rate=='0.15')echo  ' selected="selected"' ; ?>>0.15</option>
                                    <option value="0.2" <?php if($userdata->rate=='0.2')echo  ' selected="selected"' ; ?>>0.2</option>
                                    <option value="0.25" <?php if($userdata->rate=='0.25')echo  ' selected="selected"' ; ?>>0.25</option>
                                    <option value="0.45" <?php if($userdata->rate=='0.45')echo  ' selected="selected"' ; ?>>0.45</option>
                                    <option value="0.5" <?php if($userdata->rate=='0.5')echo  ' selected="selected"' ; ?>>0.5</option>
                                  


                                          <!--   <option value="0.15">0.15</option>
                                            <option value="0.2">0.2</option>
                                            <option value="0.25">0.25</option>
                                            <option value="0.45">0.45</option>
                                            <option value="0.5">0.5</option> -->
                                        </select>
                                    </div>
                                    <div class="col-md-4">
                                        <button type="button" id="submit_rate" class="btn btn-primary mobile-button" onclick="return confirm('Are you sure to Update?')">Submit</button>
                                    </div>
                                </form>   
                                </div>                     
                            </div>
                        </div>
                        <div class="mid_top_padding blockaction">
                            <h5>REFERRAL</h5>
                            <ul class="tabs">
                                  <li class="active"><a href="#">Overview</a></li>
                                  <li><a href="#">Referral Map</a></li>
                                  <!-- add as many as you want -->
                            </ul>
                            <div id="tabcontainer">
                                  <section>
                                
                                    <div class="mid_top_padding history">
                                    <table class="table table-responsive">
                                        <tr>
                                            <td class="a1">1st Recommendee / Total</td>
                                            <td class="a2">8/9</td>
                                            <td class="a1">Available amount</td>
                                            <td class="a2">24.54</td>
                                        </tr>
                                    </table>
                                    </div>
                                    <div class="small_top_padding history">
                                    <table class="table table-responsive">
                                        <tr>
                                            <td class="a1">Referal URL</td>
                                            <td class="a2">wowgo.com/register</td>
                                            <td class="a1">Copy</td>
                                        </tr>
                                    </table>
                                    </div>
                                    <div class="small_top_padding history">
                                        <p>BREAKDOWN</p>
                                        <table class="table table-responsive">
                                            <tr class="black">                                           
                                                <td>TYPE</td>
                                                <td>CRUSH</td>
                                            </tr>
                                            <tr class="a41">
                                                <td>Profit</td>
                                                <td>8998.54 CRUSH</td>
                                            </tr>
                                            <tr class="a42">
                                                <td>Withdraw</td>
                                                <td>8998.54 CRUSH</td>
                                            </tr>
                                            <tr class="a41">
                                                <td>Available Amount</td>
                                                <td>8998.54 CRUSH</td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div class="small_top_padding">
                                        <p>Referral Affiliated (0.15%)</p>
                                        <table class="table table-responsive">
                                            <tr class="black">                                           
                                                <td>ID</td>
                                                <td>Betting Referral's Profit</td>
                                                <td>Registered Date</td>
                                            </tr>
                                            <tr class="a41">
                                                <td>BAIE</td>
                                                <td>152.71</td>
                                                <td>19-9-18 13:32</td>
                                            </tr>
                                            <tr class="a42">
                                                <td>QW7500</td>
                                                <td>0.03</td>
                                                <td>19-9-18 13:32</td>
                                            </tr>
                                            <tr class="a41">
                                                <td>QW7600</td>
                                                <td>0</td>
                                                <td>19-9-18 13:32</td>
                                            </tr>
                                            <tr class="a42">
                                                <td>JAHONG</td>
                                                <td>0</td>
                                                <td>19-9-18 13:32</td>
                                            </tr>
                                            <tr class="a41">
                                                <td>ZOOM</td>
                                                <td>0</td>
                                                <td>19-9-18 13:32</td>
                                            </tr>
                                        </table>
                                    </div>
                                    
                                  </section>
                                  <section>
                                    <div class="mid_top_padding">
                                        <div class="tree">
                                            <ul>
                                                <li>
                                                    GAYA
                                                    <ul>    
                                                        <li>
                                                            1 EMUKWS (0)
                                                        </li>
                                                        <li>
                                                            1 EMUKWS (0)
                                                        </li>
                                                        <li>
                                                            1 EMUKWS (0)
                                                            <ul>
                                                                <li>2 EMUKWS (0)</li>
                                                            </ul>
                                                        </li>
                                                        <li>
                                                            1 EMUKWS (0)
                                                        </li>
                                                        <li>
                                                            1 EMUKWS (0)
                                                        </li>
                                                        <li>
                                                            1 EMUKWS (0)
                                                        </li>
                                                        <li>
                                                            1 EMUKWS (0)
                                                        </li>
                                                        <li>
                                                            1 EMUKWS (0)
                                                        </li>   
                                                        
                                                    </ul>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                  </section>
                                  <!-- add as many as you want -->
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 history-time">                        
                            <h5>Login History Time</h5>                            
                            <div class="userdetail historytime">
                            <table class="table table-responsive">
                                <tr>
                                    <th>User</th>
                                    <th>Time</th>
                                    <th>IP Address</th>
                                    <th>Location</th>

                                </tr>
		<?php foreach($userlog->result() as $row): ?>
                                <tr>                                    
                                    <td><?php echo $row->name; ?></td>
                                    <td><?php echo $row->login_time; ?></td>
                                    <td><?php echo $row->ip; ?></td>                                    
                                    <td><?php echo $row->location; ?></td>
                                </tr>                              
				<?php endforeach; ?>                                  
                            </table>
                        </div><!-- history time -->
                        <h5 class="mid_top_padding xs_padding">Transaction</h5>
                        <div class="userdetail transaction">
                        
                        <table class="table table-responsive">
                            <tr>
                         
                                <th>Tx Hash</th>
                         
                                <th>Transaction Type</th>
                                <th>Transaction Status</th>
                                <th>Amount</th>
			<th>Date</th>
                            </tr>
			<?php foreach($transaction->result() as $row): ?>
                            <tr>

                         
                                <?php if(empty($row->withdrawal_id)) { ?>
					<td><?php echo $row->ethereum_deposit_txid; ?>
					<td>Deposit</td>
			<?php 	}else{ ?>
					<td><?php echo $row->withdrawal_id; ?></td>
					<td>Withdrawal</td>
				<?php } ?>
                                <td><p style="color:green">Success</p></td>
                                <td><?php echo $row->amount; ?></td>
                                <td><?php echo $row->created; ?></td>
                                
                           
                           
                            </tr>
			<?php endforeach; ?>
                        </table>
                        </div><!-- transaction -->
                        <div class="mid_top_padding">
                            <h5>Profit & Loss</h5>
                            <div class="userdetail profitloss transaction">
                            <table class="table table-responsive">
                                <tr>
                                    <th>USER</th>
                                    <th>BET</th>
                                    <th>Profit or Loss</th>
                                    <th>Amount</th>
				
                                </tr>
				<?php foreach($profitdata->result() as $row):
			?>
                                <tr>
                                    <td><?php echo $row->name; ?></td>
                                    <td><?php echo $row->bet; ?></td>
                                   <?php if(empty($row->cash_out)){ ?>
				<td>Loss</td>
                                    <td><?php echo $row->bet; ?></td>
				<?php }else{ ?>
				<td>Profit</td>
				<td><?php echo $row->cash_out; ?></td>
				<?php } ?>
				
                                </tr>
			<?php endforeach; ?>
                            </table>
                        </div>
                        </div>  
                    </div>


                </div>
            </div>
        </div>
    </div>
</div>           


    
>>>>>>> a9cb4f9ca1392d7e8f6b8269b7ee4b9a8340d974
