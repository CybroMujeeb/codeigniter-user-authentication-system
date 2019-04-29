<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2019, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2019, British Columbia Institute of Technology (https://bcit.ca/)
 * @license	https://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter Authentication Class
 *
 * This class enables the creation of Authentication
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		EllisLab Dev Team
 * @link		
 */

class CI_Authentication {

	/**
	 * authentication class
	 *
	 * @var mixed
	 */
	private $debug 						= false;
	private $table_name					= '';
	private $data						= array();
	private $__response 				= array(
											"error" 	=> false,
											"message" 	=> "Authentication succesfull"
										);

	// --------------------------------------------------------------------

	/**
	 * CI Singleton
	 *
	 * @var object
	 */
	protected $CI;

	// --------------------------------------------------------------------

	/**
	 * Class constructor
	 *
	 *
	 * 
	 * @param	array	$config	authentication options
	 * @return	void
	 */

	public function __construct($config = array())
	{
		$this->CI =& get_instance();
		empty($config) OR $this->initialize($config);
		log_message('info', 'authentication Class Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * Initialize the user preferences
	 *
	 * Accepts an associative array as input, containing display preferences
	 *
	 * @param	array	config preferences
	 * @return	CI_Authentication
	 */
	public function initialize($config = array())
	{
		foreach ($config as $key => $val)
		{
			if (isset($this->$key))
			{
				$this->$key = $val;
			}
		}
		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Generate the Authentication
	 * @return	array
	 */

	//function to authenticate the user credentials
	public function authenticate( $params = array() )
	{	
		if(empty($params))
		{
			$params 							= $this->data;
		}
		if(!is_array($params) || empty($params))
		{
			$this->__response['error'] 			= true;
			$this->__response['message']		= 'please check the parameters provided';
			$this->CI->output->set_status_header(401, 'parameter invalid');
			return $this->__response;
		}
		if($this->__response['error'])
		{
			$this->CI->output->set_status_header(401);
			return $this->__response; 
		}
		$authentication = $this->CI->authenticate_model->auth($params);
		if(isset($authentication) && $authentication['error'])
		{
			$this->__response['error'] 			= true;
			$this->__response['message']		= $authentication['message'];
			$this->CI->output->set_status_header(401);
			return $this->__response;
		}
		else
		{
			$this->CI->session->set_userdata('user_loggedin', $authentication);
			$this->__response['error'] 			= false;
			$this->__response['message']		= 'succesfully logged in';
			$this->CI->output->set_status_header(200);
			return $this->__response;
		}
		$this->__response['error'] 				= true;
		$this->__response['message']			= 'Login failed, Uncaught error occured';
		$this->CI->output->set_status_header(401);
		return $this->__response;
	}

	//function to insert data to DB
	public function save_data($params = array())
	{	
		if(empty($params))
		{
			$params 							= $this->data;
		}
		$params 								= $this->CI->security->xss_clean($params);
		if(!is_array($params) || empty($params))
		{
			$this->__response['error'] 			= true;
			$this->__response['message']		= 'please check the parameters provided';
			$this->CI->output->set_status_header(401, 'parameter invalid');
			return $this->__response;
		}
		if($this->__response['error'])
		{
			$this->CI->output->set_status_header(401);
			return $this->__response; 
		}
		$user_id 								= $this->CI->authenticate_model->user_register($params, $this->table_name);
		if(isset($user_id) && $user_id)
		{
			$this->__response['user_id'] 		= $user_id;
			$this->__response['message']		= 'Registration successfull';
			$this->CI->output->set_status_header(200);
			return $this->__response;
		}
			$this->__response['error'] 			= true;
			$this->__response['message']		= 'Data insertion failed, Uncaught error occured';
			$this->CI->output->set_status_header(401);
			return $this->__response; 
	}

	//function to destroy or unset session
	public function clear_session($session_name = 'user_loggedin', $destroy = FALSE)
	{
		$this->CI->session->unset_userdata($session_name);

		if($destroy)
		{
			$this->CI->session->sess_destroy();
		}
		$this->__response['error'] 			= false;
		$this->__response['message']		= 'Successfully logged out';
		$this->CI->output->set_status_header(401);
		return $this->__response;
	}

	//function to handle all flashdata messages
	public function notification()
	{
		if($params = $this->CI->session->flashdata('notification'))
		{
		?>
			<div class="alert alert-<?php echo $params['type']?> alert-dismissible">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong><?php echo $params['message']?></strong>
			</div>
		<?php
		}
	}

	//validating the current user
	public function is_loggedin($checking = true)
	{
		$user_details = $this->CI->session->userdata('user_loggedin');
		if(isset($user_details['user_email']) && !empty($user_details['user_email']))
		{
			return true;
		}
		if($checking)
		{
			$this->CI->session->set_flashdata('notification', array('type' => 'danger', 'message' => 'Session expired! please login again'));
		}
		return false;
	}

}