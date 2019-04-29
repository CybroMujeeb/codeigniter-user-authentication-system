<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('form');
	}

	public function index()
	{
		if($this->authentication->is_loggedin(false))
		{
			redirect('/dashboard');
		}

		$this->load->view('registration');
	}

	public function user_register()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('full_name', 'Full Name', 'trim|required|alpha_numeric_spaces');
		$this->form_validation->set_rules('email_address', 'Email Address', 'trim|required|valid_email|is_unique[registration.user_email]', array('is_unique' => 'This email address is already exists'));
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		$this->form_validation->set_rules('password_repeat', 'Password Confirmation', "trim|required|matches[password]");
		$this->form_validation->set_rules('country_code', 'Country Code', 'trim');
		$this->form_validation->set_rules('phone_number', 'Phone Number', 'trim|required|numeric|is_unique[registration.user_phone]', array('is_unique' => 'This phone number is already exists'));
		$this->form_validation->set_rules('user_type', 'User Type', 'trim');

		if( $this->form_validation->run() == FALSE )
		{
			$this->load->view('registration');
			return false;
		}
		else
		{
			$this->authentication->initialize(
										array(
											'debug' 			=> true,
											'table_name'		=> NULL,
											'data'				=> $this->input->post()
										)
									);

			$result 				= $this->authentication->save_data();
			
			if(!$result['error'] && $result['user_id'])
			{
				$this->session->set_flashdata('notification', array('type' => 'success', 'message' => 'user registration succesfull'));
				redirect('/login');
				die();
			}

			$this->session->set_flashdata('notification', array('type' => 'danger', 'message' => 'user registration filed'));
			redirect('/register');
		}
	}

	public function user_login()
	{
		if($this->authentication->is_loggedin(false))
		{
			redirect('/dashboard');
		}
		$this->load->view('login_view');
	}

	public function authenticate_user()
	{
		$this->load->library('form_validation');
		$this->form_validation->set_rules('password', 'Password', 'trim|required');
		$this->form_validation->set_rules('email_address', 'Email Address', 'trim|required');
		if( $this->form_validation->run() == FALSE )
		{
			$this->user_login();
			return false;
		}

		$this->authentication->initialize(
									array(
										'debug' 			=> true,
										'table_name'		=> NULL,
										'data'				=> $this->input->post()
									)
								);

		$result 					= $this->authentication->authenticate();

		if(!$result['error'])
		{
			$this->session->set_flashdata('notification', array('type' => 'success', 'message' => 'user succesfully logged in'));
			redirect('/dashboard');
			die();
		}
		$this->session->set_flashdata('notification', array('type' => 'danger', 'message' => 'Authentication failed'));
		redirect('/login');
		die();
	}

	public function user_dashboard()
	{
		if(!$this->authentication->is_loggedin())
		{
			redirect('/login');
		}

		$data['user_details'] 		= $this->session->userdata('user_loggedin');
		$this->load->view('user_view', $data);
	}

	public function logout()
	{
		$this->authentication->clear_session('user_loggedin', FALSE);
		$this->session->set_flashdata('notification', array('type' => 'success', 'message' => 'Successfully logged out'));
		redirect('/login');
	}
}