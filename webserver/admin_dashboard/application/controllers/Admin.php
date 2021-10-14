<?php
	/**
	*
	*/
if(!defined('BASEPATH'))
exit('No direct script acceess allowed');

class Admin extends CI_Controller
{
	function __construct()
	{
	parent::__construct();
	error_reporting(1);
	$this->load->model('Admin_model');
	$this->load->library('pagination');
	}
function index()
{
<<<<<<< HEAD
	if($this->session->userdata("username") && $this->session->userdata("password"))
    {
		$data['user']=$this->db->get("users");	
		$data['content']='usermanagement';

		$this->load->view('admin_login',$data);
	}
	else{
		$this->load->view('admin_login');
	}
=======
	$this->load->view('admin_login');
	
>>>>>>> a9cb4f9ca1392d7e8f6b8269b7ee4b9a8340d974
}				
/*login form*/
function admin_form()
{
	$this->load->view('admin_login',$data);
}
function admin_login()
{
	ob_start();		

	$username=$this->input->post("username");
	$password=$this->input->post("password");
	$this->db->select('*');
	$this->db->from('admin');
	$this->db->where(array('username'=>$username,'password'=>$password));
	$query=$this->db->get();

	if($query->num_rows()==1)
	{

		$user=$query->row();
<<<<<<< HEAD
		$userdata=array('id'=>$user->id,'username'=>$user->username,'password'=>$user->password);
=======
		$userdata=array('username'=>$user->username,'password'=>$user->password);
>>>>>>> a9cb4f9ca1392d7e8f6b8269b7ee4b9a8340d974
		$this->session->set_userdata($userdata);

		redirect("Admin/users/","refresh");
	}
	else
	{
		$this->load->view('admin_login',$data);
		?> <script>
		arert("User name and password do not match")
		</script><?php
	}
}
function history_time(){
	if($this->session->userdata("username") && $this->session->userdata("password"))
	{

	$data['historytime']=$this->db->query("SELECT user_logs.*,users.username as name from user_logs LEFT JOIN users ON user_logs.user_id=users.id order by id desc");
	$data['content']='histroy-time';
	$this->load->view("template",$data);
	}
	else{
		
	$this->load->view('admin_login');
	}
}
function profit_losss(){
<<<<<<< HEAD
=======
	$this->load->library('pagination');
>>>>>>> a9cb4f9ca1392d7e8f6b8269b7ee4b9a8340d974
	if($this->session->userdata("username") && $this->session->userdata("password"))
	{
	$data['profitdata']=$this->db->query("SELECT users.*,plays.bet as bet,plays.cash_out as cash_out,users.username as name FROM plays LEFT JOIN users ON plays.user_id=users.id order by plays.id desc");
	$data['netprofit']=$this->db->select("coalesce(sum(cash_out),0)+coalesce(sum(bonus),0)-coalesce(sum(bet),0) as netprofit")
				->get("plays");
<<<<<<< HEAD
	
	$config["base_url"]=base_url()."Admin/profit_losss/";
	$config['total_rows'] = $this->db->get("plays")->num_rows();
    $config['per_page'] = 5;
=======
	$data['totalrow']=$this->db->query("SELECT * from plays")->row();

	$config["base_url"]=base_url()."Admin/profit_loss/";
	$row=$this->db->query("Select * from plays");
	$config['total_rows'] = $row->num_rows();
    $config["per_page"] = 3;
>>>>>>> a9cb4f9ca1392d7e8f6b8269b7ee4b9a8340d974
    $config['uri_segment'] = 3;
    $config['num_links'] = 3;
    $config['full_tag_open'] = '<ul class="pagegi">';
    $config['full_tag_close'] = '</ul>';
    $config['num_tag_open'] = '<li>';
    $config['num_tag_close'] = '</li>';
    $config['cur_tag_open'] = '<li><a class="current">';
    $config['cur_tag_close'] = '</a></li>';
    $config['prev_tag_open'] = '<li>';
    $config['prev_tag_close'] = '</li>';
    $config['next_tag_open'] = '<li>';
    $config['next_tag_close'] = '</li>';
<<<<<<< HEAD
    $config['prev_link'] = 'Prev';
    $config['next_link'] = 'Next';  
=======
    $config['prev_link'] = '<< Prev';
    $config['next_link'] = 'Next >>';  
>>>>>>> a9cb4f9ca1392d7e8f6b8269b7ee4b9a8340d974
    $this->pagination->initialize($config);
	
	$data['content']='profit-loss';
	$this->load->view("template",$data);
	}
	else{
		
	$this->load->view('admin_login');
	}
}
function transaction(){
	if($this->session->userdata("username") && $this->session->userdata("password"))
	{
	$data['transaction']=$this->db->query("select plays.*,game_hashes.* from plays LEFT JOIN game_hashes ON plays.game_id=game_hashes.game_id order by created desc");
	$data['transactiondata']=$this->db->select("users.username as name,fundings.*")
					->join("users","users.id=fundings.user_id","left")
					->get("fundings");

	$data['content']='transaction';
	$this->load->view("template",$data);
	}
	else{
		
	$this->load->view('admin_login');
	}
}
function user_detail(){
	if($this->session->userdata("username") && $this->session->userdata("password"))
	{
	$id=$this->uri->segment(3);

	$data['userdata']=$this->db->select("users.*,users.id as userid,fundings.*")
	->join("fundings","fundings.user_id=users.id","left")
	->get_where("users",array("users.id"=>$id))->row();
	$data['deposit']=$this->db->query("SELECT SUM(amount) AS deposit FROM fundings WHERE user_id=$id AND amount>0")->row();
				
	$data['withdraw']=$this->db->query("select sum(amount) as withdraw from fundings where user_id=$id AND amount<=0")->row();
	$data['netprofit']=$this->db->select('coalesce(sum(cash_out),0)+coalesce(sum(bonus),0)-coalesce(sum(bet),0) as netprofit')
				->get_where("plays",array("user_id"=>$id))->row();
	$data['userfunding']=$this->db->query("select * from fundings where user_id=$id")->row();
	$data['profitdata']=$this->db->query("SELECT plays.bet as bet,plays.cash_out as cash_out,users.username as name FROM plays LEFT JOIN users ON plays.user_id=users.id WHERE plays.user_id=$id order by plays.id desc");
	$data['userlog']=$this->db->query("SELECT user_logs.*,users.username as name from user_logs LEFT JOIN users ON user_logs.user_id=users.id WHERE user_id=$id order by id desc");

	$data['transaction']=$this->db->select("users.username as name,fundings.*")
					->join("users","users.id=fundings.user_id","left")
					->get_where("fundings",array("user_id"=>$id));	
	$data['content']='user-detail';
	$this->load->view("template",$data);
	}
	else{
		
	$this->load->view('admin_login');
	}
}
function users(){
<<<<<<< HEAD
	if(($this->session->userdata("username")) && ($this->session->userdata("password")))
=======
	if($this->session->userdata("username") && ($this->session->userdata("password")))
>>>>>>> a9cb4f9ca1392d7e8f6b8269b7ee4b9a8340d974
	{
	$data['user']=$this->db->select("users.*,users.id as userid,fundings.*")
				->join('fundings','fundings.user_id=users.id','left')
				->get("users");
	$data['content']='usermanagement';

	$this->load->view('template',$data);
	}
	else{
		
		$this->load->view('admin_login');
	}
}
function transaction_search()
{
	
	if($this->input->post('submit')==true)
	{
		
		$type=$this->input->post("type");

		$data=array(
			'type'=>$type
		);
		$this->session->set_userdata($data);
	}
	else{
	
		$type=$this->session->userdata("type");
	}
	
	if($type=="deposit"){

		$query=$this->db->query("SELECT fundings.*,users.username as name FROM fundings LEFT JOIN users ON users.id=fundings.user_id WHERE ethereum_deposit_txid!=''");
		
	}
	elseif($type=="withdrawal"){
		$query=$this->db->query("SELECT fundings.*,users.username as name from fundings LEFT JOIN users ON users.id=fundings.user_id WHERE withdrawal_id is not NULL");
	}	
	
	if($query->num_rows()>=1)
	{
	$data["message"]="";
	$data["lists"]=$query;		

	$data["content"]="transaction-search";
	$this->load->view("template",$data);
	}
	else{		

	$data["message"]="No Data Found!";
	$data["content"]="nodata";
	$this->load->view("template",$data);
	}
}
function user_search(){
	if($this->input->post('submit')==true)
	{			
	$type=$this->input->post("type");
	$username=$this->input->post("username");

	$userdata=array(				
	'type'=>$type,
	'username'=>$username
	);
	$this->session->set_userdata($userdata);
	}
	else{			
	$type=$this->session->userdata("type");
	$username=$this->session->userdata("username");
	}

	// echo $type;exit;
	if(($type=="deposit") && empty($username))
	{

	$query=$this->db->query("SELECT users.*,users.username as name,users.id as userid,fundings.* FROM users LEFT JOIN fundings ON fundings.user_id=users.id WHERE ethereum_deposit_txid!=''");
	$data["userlist"]=$query;			
	}
	elseif(($type=="withdrawal") && empty($username))
	{
	$query=$this->db->query("SELECT users.*,users.username as name,users.id as userid,fundings.* FROM users LEFT JOIN fundings ON fundings.user_id=users.id WHERE withdrawal_id is not NULL");
	$data["userlist"]=$query;
	}
	elseif(empty($type) && !empty($username))
	{
	$query=$this->db->query("SELECT users.*,fundings.*,users.username as name,users.id as userid FROM users LEFT JOIN fundings ON fundings.user_id=users.id WHERE username LIKE '%$username%'");
	$data["userlist"]=$query;			
	}
	elseif($type=="deposit" && !empty($username))
	{
	$query=$this->db->query("SELECT users.*,fundings.*,users.username as name,users.id as userid FROM users LEFT JOIN fundings ON fundings.user_id=users.id WHERE ethereum_deposit_txid!='' AND username LIKE '%$username%'");
	$data["userlist"]=$query;
	}
	elseif($type=="withdrawal" && !empty($username))
	{
	$query=$this->db->query("SELECT users.*,fundings.*,users.username as name,users.id as userid FROM users LEFT JOIN fundings ON fundings.user_id=users.id WHERE username LIKE '%username%' AND withdrawal_id is not NULL");
	$data["userlist"]=$query;
	}
	elseif(empty($type) && empty($username))
	{
<<<<<<< HEAD
	$query=$this->db->query("SELECT * FROM users");
	$data["userlist"]=$query;
	}
 echo $this->db->last_query();exit;
=======
	$query=$this->db->query("SELECT users.*,fundings.*,users.username as name,users.id as userid FROM users LEFT JOIN fundings ON fundings.user_id=users.id");
	$data["userlist"]=$query;
	}
 
>>>>>>> a9cb4f9ca1392d7e8f6b8269b7ee4b9a8340d974
	if($query->num_rows()>=1)
	{
	$data["message"]="";
	$data["lists"]=$query;		

	$data["content"]="user_list_search";
	$this->load->view("template",$data);
	}
	else{		

	$data["message"]="No Data Found!";
	$data["content"]="nodata";
	$this->load->view("template",$data);
	}
}
function profitloss_search(){
	if($this->input->post('submit')==true)
	{			
	$type=$this->input->post("type");
	$username=$this->input->post("username");

	$userdata=array(		
	'type'=>$type,
	'username'=>$username
	);
	$this->session->set_userdata($userdata);
	}
	else{			
	$type=$this->session->userdata("type");
	$username=$this->session->userdata("username");
	}

	// echo $type;exit;
<<<<<<< HEAD
	if(!empty($type) && empty($username))
	{
	$query=$this->db->query("SELECT * FROM users WHERE type='$type'");
	$data["userlist"]=$query;			
	}
	elseif(empty($type) && !empty($username))
	{
	$query=$this->db->query("SELECT * FROM users WHERE name LIKE '%$username%'");
	$data["userlist"]=$query;			
	}
	elseif(!empty($type) && !empty($username))
	{
	$query=$this->db->query("SELECT * FROM users WHERE type='$type' AND name LIKE '%$username%'");
=======
	if($type=="profit" && empty($username))
	{
	$query=$this->db->query("SELECT users.*,plays.cash_out as cash_out,plays.bet as bet,users.username as name FROM plays LEFT JOIN users ON plays.user_id=users.id WHERE cash_out is not NULL");
	$data["userlist"]=$query;			
	}
	elseif($type=="loss" && empty($username))
	{
	$query=$this->db->query("SELECT users.*,plays.cash_out as cash_out,plays.bet as bet,users.username as name FROM plays LEFT JOIN users ON plays.user_id=users.id WHERE cash_out is NULL");
	$data["userlist"]=$query;
	}
	elseif(empty($type) && !empty($username))
	{
	$query=$this->db->query("SELECT users.*,plays.cash_out as cash_out,plays.bet as bet,users.username as name FROM plays LEFT JOIN users ON plays.user_id=users.id WHERE username LIKE '%$username%'");
	$data["userlist"]=$query;			
	}
	elseif($type=="profit" && !empty($username))
	{
	$query=$this->db->query("SELECT users.*,plays.cash_out as cash_out,plays.bet as bet,users.username as name FROM plays LEFT JOIN users ON plays.user_id=users.id WHERE cash_out is not NULL AND username LIKE '%$username%'");
	$data["userlist"]=$query;
	}
	elseif($type=="loss" && !empty($username))
	{
	$query=$this->db->query("SELECT users.*,plays.cash_out as cash_out,plays.bet as bet,users.username as name FROM plays LEFT JOIN users ON plays.user_id=users.id WHERE cash_out is NULL AND username LIKE '%username%'");
>>>>>>> a9cb4f9ca1392d7e8f6b8269b7ee4b9a8340d974
	$data["userlist"]=$query;
	}
	elseif(empty($type) && empty($username))
	{
<<<<<<< HEAD
	$query=$this->db->query("SELECT * FROM users");
=======
	$query=$this->db->query("SELECT users.*,plays.cash_out as cash_out,plays.bet as bet,users.username as name FROM plays LEFT JOIN users ON plays.user_id=users.id");
>>>>>>> a9cb4f9ca1392d7e8f6b8269b7ee4b9a8340d974
	$data["userlist"]=$query;
	}
	// echo $this->db->last_query();exit;
	if($query->num_rows()>=1)
	{
	$data["message"]="";
	$data["lists"]=$query;		

<<<<<<< HEAD
	$data["content"]="user_list_search";
=======
	$data["content"]="profit_loss_search";
>>>>>>> a9cb4f9ca1392d7e8f6b8269b7ee4b9a8340d974
	$this->load->view("template",$data);
	}
	else{		

	$data["message"]="No Data Found!";
	$data["content"]="nodata";
	$this->load->view("template",$data);
	}
}

function update_action(){

	$this->form_validation->set_rules('id', '<b>id</b>', 'trim|required');
	$this->form_validation->set_rules('action', '<b>action</b>', 'trim|required');
	// $id=$this->input->post('id');
	// $action=$this->input->post("action");	

	
	$arr2=array(
		"status"=>$this->input->post("action")
	);
	$this->db->where('id',$this->input->post('id'));
	$this->db->update("users",$arr2);
		// $this->Admin_model->update_user_data($arr, $this->input->post('id'));
		$useraction=$this->db->get_where("users",array("id"=>$id))->row();
		$arr = array();
		$arr["name"]=$useraction->name;
		$arr["address"]=$useraction->address;
		$arr["type"]=$useraction->type;
		$arr["action"]=$this->input->post("action");
		$arr["referral_action"]=$useraction->referral_action;
		$arr["referral_fee"]=$useraction->referral_fee;
		$arr['success'] = true;
		// $arr["name"]="ppa";
		//  $arr["address"]="No44";
		//  $arr["type"]="M";
		//  $arr["action"]="BB";
		//  $arr["referral_action"]="Yes";
		//  $arr["referral_fee"]="0.1";
		//  $arr['success'] = true;
	//echo $arr[0];		
	//print_r($arr[0]); exit();
	
	
	echo json_encode($arr);
	// redirect('Admin/users');

}
function referral_system()
{
	$this->form_validation->set_rules('id', '<b>id</b>', 'trim|required');
	$this->form_validation->set_rules('referralfee', '<b>referralfee</b>', 'trim|required');

	$arr2=array(
		"referral"=>'yes',
		"rate"=>$this->input->post('referralfee')
	);
	$this->db->where('id',$this->input->post('id'));
	$this->db->update("users",$arr2);
	$arr=array();
	$arr["referral_action"]="yes";	
	$arr["referralfee"]=$this->input->post("referralfee");	
	$arr['success'] = true;
	echo json_encode($arr);
}
function admin_profile(){
	if($this->session->userdata("username") && $this->session->userdata("password"))
	{
	$data["admindata"]=$this->db->get("admin")->row();

	$data["content"]="admin_profile";
	$this->load->view("template",$data);
	}
	else{
			
		$this->load->view('admin_login');
	}
}
function setting(){
	if($this->session->userdata("username") && $this->session->userdata("password"))
	{
	$data["admindata"]=$this->db->get("admin");
	$data["content"]="setting";
	$this->load->view("template",$data);
	}
	else{
			
		$this->load->view('admin_login');
	}
}
function update_setting()
{
	// $id=$this->session->userdata('id');
    $username=$this->input->post('username');
	$password=$this->input->post('password');
	$data=array(
	    "username" =>$username,
	    "password" =>$password);
	// $this->db->where('id',$id);
	$this->db->update("admin",$data);
	session_destroy();
	redirect('Admin/admin_login',"refresh");
}
/*logout*/
function logout()
{
	session_destroy();
	redirect('Admin/admin_login',"refresh");
}
/**/
}
?>
