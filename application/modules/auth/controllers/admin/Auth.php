<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends Core_Controller {

    public function __construct()
    { 
        parent::__construct();
        // ini_set('display_errors',1);
        $this->load->database();
        $this->load->library(array('ion_auth','form_validation'));
        $this->load->helper(array('url','language'));

        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));

        $this->lang->load('auth');
        $this->template->set_layout('dashboard');

    }

    // redirect if needed, otherwise display the user list
    public function index()
    {

        if (!$this->ion_auth->logged_in())
        {
            // redirect them to the login page
            redirect('auth/login', 'refresh');
        }
        elseif (!$this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
        {
            // redirect them to the home page because they must be an administrator to view this
            redirect('Dashboard','refresh');
            //return show_error('You must be an administrator to view this page.');
        }
        else
        {
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            //list the users
            $this->data['users'] = $this->ion_auth->users()->result();
            foreach ($this->data['users'] as $k => $user)
            {
                $this->data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
            }

            $this->template
                ->set_layout('Dashboard')
                ->title('User Group')
                ->build('auth/index', $this->data);
        }
    }


    /**
     * function to check if user is logged in
     */

    public function loginCheck(){
        $response=$this->session->userdata('user_id');
        if($response){
            echo json_encode(array('status'=>1));
        }else{
            echo json_encode(array('status'=>0));
        }
        exit;
    }

    // log the user in
    public function login()
    {

        if(isset($_GET['referrer'])){
            $referrer=$_GET['referrer'];
        }else{
            $referrer='/';
        }

        if (!$this->ion_auth->logged_in()) {
            // redirect them to the login page
            //redirect('auth/login', 'refresh');
        } elseif ($this->ion_auth->is_admin()) // remove this elseif if you want to enable this for non-admins
        {
            // redirect them to the home page because they must be an administrator to view this
            redirect('admin/dashboard', 'refresh');
            //return show_error('You must be an administrator to view this page.');
        } else {
            redirect(base_url());
        }

        $this->theme = "frontend";
        $this->config->load('asset');
        $this->config->config['assets']['path'] = "themes/" . $this->theme.'/';
        $this->load->helper('asset');

        
        $this->data['title'] = $this->lang->line('login_heading');

        //validate form input
        $this->form_validation->set_rules('identity', str_replace(':', '', $this->lang->line('login_identity_label')), 'required');
        $this->form_validation->set_rules('password', str_replace(':', '', $this->lang->line('login_password_label')), 'required');

        if ($this->form_validation->run() == true)
        {
           // check to see if the user is logging in
			// check for "remember me"
            $remember = (bool)$this->input->post('remember');

            $login = $this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember);
            if (!$login) {
                $this->ion_auth_model->identity_column = 'email';
                // check for email
                $login = $this->ion_auth->login($this->input->post('identity'), $this->input->post('password'), $remember);

            }

            if ($login) {
                point_add('login');
                apply_hook('after_success_login');
                echo json_encode(array('message' => $this->ion_auth->messages(), 'status' => 1, 'referrer' => site_url($referrer)));
                exit;

            } else {
				// if the login was un-successful
				// redirect them back to the login page
                echo json_encode(array('message' => $this->ion_auth->errors(), 'status' => 0, 'referrer' => site_url($referrer)));
                exit;

            }
        }
        else
        {
            // the user is not logging in so display the login page
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $this->data['identity'] = array('name' => 'identity',
                'id'    => 'identity',
                'type'  => 'text',
                'class' =>'form-control m-input form-control-lg text-4',
                'placeholder'=>'Email',
                'required'  =>'required',
                'autofocus'=>'',
                'value' => $this->form_validation->set_value('identity'),
                'autocomplete'=>'off'
            );
            $this->data['password'] = array('name' => 'password',
                'id'   => 'password',
                'type' => 'password',
                'class'=>'form-control m-input m-login__form-input--last form-control-lg text-4',
                'placeholder'=>'Password',
                'required'=>'required'
            );


                $this->template
                    ->title('Sign In')
                    ->set_theme('frontend')
                    ->set_layout('login')
                ->append_metadata(css('bootstrap.min.css'))
                ->append_metadata(css('theme.css'))
                ->append_metadata(css('theme-elements.css'))
                ->append_metadata(css('skins/skin-corporate-3.css'))
                    ->build('login',$this->data);

            //$this->_render_page('auth/login', $this->data);
        }
    }

    // log the user out

    public function change_password()
    {
        $this->form_validation->set_rules('old', $this->lang->line('change_password_validation_old_password_label'), 'required');
        $this->form_validation->set_rules('new', $this->lang->line('change_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
        $this->form_validation->set_rules('new_confirm', $this->lang->line('change_password_validation_new_password_confirm_label'), 'required');

        if (!$this->ion_auth->logged_in())
        {
            redirect('auth/login', 'refresh');
        }

        $user = $this->ion_auth->user()->row();

        if ($this->form_validation->run() == false)
        {
            // display the form
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
            $this->data['old_password'] = array(
                'name' => 'old',
                'id'   => 'old',
                'type' => 'password',
            );
            $this->data['new_password'] = array(
                'name'    => 'new',
                'id'      => 'new',
                'type'    => 'password',
                'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
            );
            $this->data['new_password_confirm'] = array(
                'name'    => 'new_confirm',
                'id'      => 'new_confirm',
                'type'    => 'password',
                'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
            );
            $this->data['user_id'] = array(
                'name'  => 'user_id',
                'id'    => 'user_id',
                'type'  => 'hidden',
                'value' => $user->id,
            );

            // render
            message('error' , validation_errors());
            redirect('admin/profile');
        }
        else
        {
            $identity = $this->session->userdata('identity');

            $change = $this->ion_auth->change_password($identity, $this->input->post('old'), $this->input->post('new'));

            if ($change)
            {
                //if the password was successfully changed
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                $this->logout();
            }
            else
            {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect('admin/profile', 'refresh');
            }
        }
    }

    // change password

    public function _render_page($view, $data=null, $returnhtml=false)//I think this makes more sense
    {

        $this->viewdata = (empty($data)) ? $this->data: $data;

        $view_html = $this->load->view($view, $this->viewdata, $returnhtml);

        if ($returnhtml) return $view_html;//This will return html on 3rd argument being true
    }

    // forgot password

    public function logout()
    {
        $this->data['title'] = "Logout";

        // log the user out
        $logout = $this->ion_auth->logout();

        // redirect them to the login page
        $this->session->set_flashdata('message', $this->ion_auth->messages());
        redirect('auth/login', 'refresh');
    }

    public function user_logout()
    {
        $this->data['title'] = "Logout";

        // log the user out
        $logout = $this->ion_auth->logout();

        // redirect them to the login page
        $this->session->set_flashdata('message', $this->ion_auth->messages());
        redirect('user_login', 'refresh');
    }

    // reset password - final step for forgotten password

    public function forgot_password()
    {
        // setting validation rules by checking whether identity is username or email
        if($this->config->item('identity', 'ion_auth') != 'email' )
        {
            $this->form_validation->set_rules('identity', $this->lang->line('forgot_password_identity_label'), 'required');
        }
        else
        {
            $this->form_validation->set_rules('identity', $this->lang->line('forgot_password_validation_email_label'), 'required|valid_email');
        }


        if ($this->form_validation->run() == false)
        {
            $this->data['type'] = $this->config->item('identity','ion_auth');
            // setup the input
            $this->data['identity'] = array('name' => 'identity',
                'id' => 'identity',
            );

            if ( $this->config->item('identity', 'ion_auth') != 'email' ){
                $this->data['identity_label'] = $this->lang->line('forgot_password_identity_label');
            }
            else
            {
                $this->data['identity_label'] = $this->lang->line('forgot_password_email_identity_label');
            }

            // set any errors and display the form
            $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
            $this->template
                ->set_theme('login')
                ->title('Forgot Password')
                ->build('auth/forgot_password',$this->data);
            //$this->_render_page('auth/forgot_password', $this->data);
        }
        else
        {
            $identity_column = $this->config->item('identity','ion_auth');
            $identity = $this->ion_auth->where($identity_column, $this->input->post('identity'))->users()->row();

            if(empty($identity)) {

                if($this->config->item('identity', 'ion_auth') != 'email')
                {
                    $this->ion_auth->set_error('forgot_password_identity_not_found');
                }
                else
                {
                    $this->ion_auth->set_error('forgot_password_email_not_found');
                }

                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect("auth/forgot_password", 'refresh');
            }

            // run the forgotten password method to email an activation code to the user
            $forgotten = $this->ion_auth->forgotten_password($identity->{$this->config->item('identity', 'ion_auth')});

            if ($forgotten)
            {
                // if there were no errors
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("auth/login", 'refresh'); //we should display a confirmation page here instead of the login page
            }
            else
            {
                $this->session->set_flashdata('message', $this->ion_auth->errors());
                redirect("auth/forgot_password", 'refresh');
            }
        }
    }


    // activate the user

    public function reset_password($code = NULL)
    {
        if (!$code)
        {
            show_404();
        }

        $user = $this->ion_auth->forgotten_password_check($code);

        if ($user)
        {
            // if the code is valid then display the password reset form

            $this->form_validation->set_rules('new', $this->lang->line('reset_password_validation_new_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[new_confirm]');
            $this->form_validation->set_rules('new_confirm', $this->lang->line('reset_password_validation_new_password_confirm_label'), 'required');

            if ($this->form_validation->run() == false)
            {
                // display the form

                // set the flash data error message if there is one
                $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

                $this->data['min_password_length'] = $this->config->item('min_password_length', 'ion_auth');
                $min_password_length = $this->config->item('min_password_length','ion_auth');
                $this->data['new_password'] = array(
                    'name' => 'new',
                    'id'   => 'new',
                    'type' => 'password',
                    'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
                    'class' =>  'form-control',
                    'placeholder'   => sprintf(lang('reset_password_new_password_label'), $min_password_length)
                );
                $this->data['new_password_confirm'] = array(
                    'name'    => 'new_confirm',
                    'id'      => 'new_confirm',
                    'type'    => 'password',
                    'class'   => 'form-control',
                    'placeholder'   => 'Confirm New Password:',
                    'pattern' => '^.{'.$this->data['min_password_length'].'}.*$',
                );
                $this->data['user_id'] = array(
                    'name'  => 'user_id',
                    'id'    => 'user_id',
                    'type'  => 'hidden',
                    'value' => $user->id,
                );
                $this->data['csrf'] = $this->_get_csrf_nonce();
                $this->data['code'] = $code;

                // render
                $this->template
                    ->title('Reset Password')
                    ->build('auth/reset_password', $this->data);
            }
            else
            {
                // do we have a valid request?
                if ($this->_valid_csrf_nonce() === FALSE || $user->id != $this->input->post('user_id'))
                {

                    // something fishy might be up
                    $this->ion_auth->clear_forgotten_password_code($code);

                    show_error($this->lang->line('error_csrf'));

                }
                else
                {
                    // finally change the password
                    $identity = $user->{$this->config->item('identity', 'ion_auth')};

                    $change = $this->ion_auth->reset_password($identity, $this->input->post('new'));

                    if ($change)
                    {
                        // if the password was successfully changed
                        $this->session->set_flashdata('message', $this->ion_auth->messages());
                        redirect("auth/login", 'refresh');
                    }
                    else
                    {
                        $this->session->set_flashdata('message', $this->ion_auth->errors());
                        redirect('auth/reset_password/' . $code, 'refresh');
                    }
                }
            }
        }
        else
        {
            // if the code is invalid then send them back to the forgot password page
            $this->session->set_flashdata('message', $this->ion_auth->errors());
            redirect("auth/forgot_password", 'refresh');
        }
    }

    // deactivate the user

    public function _get_csrf_nonce()
    {
        $this->load->helper('string');
        $key   = random_string('alnum', 8);
        $value = random_string('alnum', 20);
        $this->session->set_flashdata('csrfkey', $key);
        $this->session->set_flashdata('csrfvalue', $value);

        return array($key => $value);
    }

    // create a new user

    public function _valid_csrf_nonce()
    {
        $csrfkey = $this->input->post($this->session->flashdata('csrfkey'));
        if ($csrfkey && $csrfkey == $this->session->flashdata('csrfvalue'))
        {
            return TRUE;
        }
        else
        {
            return TRUE;
        }
    }

    // edit a user

    public function activate($id, $code=false)
    {
        if ($code !== false)
        {
            $activation = $this->ion_auth->activate($id, $code);
        }
        else if ($this->ion_auth->is_admin())
        {
            $activation = $this->ion_auth->activate($id);
        }

        if ($activation)
        {
            // redirect them to the auth page
            $this->session->set_flashdata('message', $this->ion_auth->messages());
            redirect("auth", 'refresh');
        }
        else
        {
            // redirect them to the forgot password page
            $this->session->set_flashdata('message', $this->ion_auth->errors());
            redirect("auth/forgot_password", 'refresh');
        }
    }

    // create a new group

    public function deactivate($id = NULL)
    {
        if (!$this->ion_auth->logged_in() )
        {
            // redirect them to the home page because they must be an administrator to view this
            return show_error('You must be logged in to view this page.');
        }

        if(!empty($id) && ($this->session->userdata('user_id')!==$id)){
            return show_error('You are not allowed to perform this action');
        }

        $id = (int) $id;

        //if user id is not provided, deactivate the logged in user
        // important if user want his account deactivated

        if($id==NULL){
            $id=$this->session->userdata('user_id');
        }

        $this->load->library('form_validation');
        $this->form_validation->set_rules('confirm', $this->lang->line('deactivate_validation_confirm_label'), 'required');
        $this->form_validation->set_rules('id', $this->lang->line('deactivate_validation_user_id_label'), 'required|alpha_numeric');

        if ($this->form_validation->run() == FALSE)
        {
            // insert csrf check
            $this->data['csrf'] = $this->_get_csrf_nonce();
            $this->data['user'] = $this->ion_auth->user($id)->row();

            $this->template
                ->title('User Deactivation')
                ->set_layout('dashboard')
                ->build('auth/deactivate_user', $this->data);
        }
        else
        {
            // do we really want to deactivate?
            if ($this->input->post('confirm') == 'yes')
            {
                // do we have a valid request?
                if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
                {
                    return show_error($this->lang->line('error_csrf'));
                }

                // do we have the right userlevel?
                if ($this->ion_auth->logged_in())
                {

                    $deactive=$this->ion_auth->deactivate($id);

                    if($deactive){
                        $logout = $this->ion_auth->logout();

                    }



                }
            }

            // redirect them back to the auth page
            redirect('auth', 'refresh');
        }
    }

    // edit a group

    public function create_user()
    {

        $this->data['title'] = $this->lang->line('create_user_heading');

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
        {
            //redirect('auth', 'refresh');
        }

        $tables = $this->config->item('tables','ion_auth');
        $identity_column = $this->config->item('identity','ion_auth');
        $this->data['identity_column'] = $identity_column;

        // validate form input
        $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required');
        $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required');
        if($identity_column!=='email')
        {
            $this->form_validation->set_rules('identity',$this->lang->line('create_user_validation_identity_label'),'required|is_unique['.$tables['users'].'.'.$identity_column.']');
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email');
        }
        else
        {
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email|is_unique[' . $tables['users'] . '.email]');
        }
        $this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'trim');
        $this->form_validation->set_rules('company', $this->lang->line('create_user_validation_company_label'), 'trim');
        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');

        if ($this->form_validation->run() == true)
        {
            $email    = strtolower($this->input->post('email'));
            $identity = ($identity_column==='email') ? $email : $this->input->post('identity');
            $password = $this->input->post('password');

            $additional_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name'  => $this->input->post('last_name'),
                'company'    => $this->input->post('company'),
                'phone'      => $this->input->post('phone'),
            );
        }
        if ($this->form_validation->run() == true && $this->ion_auth->register($identity, $password, $email, $additional_data))
        {
            // check to see if we are creating the user
            // redirect them back to the admin page
            echo $response=json_encode(
                array(
                    'message'=>$this->ion_auth->messages(),
                    'status'=>1
                )
            );

            exit;

        }
        else
        {
            // display the create user form
            // set the flash data error message if there is one
            $message= (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
            echo json_encode(array('message'=>$message,'status'=>0));
            exit;

//            $this->data['first_name'] = array(
//                'name'  => 'first_name',
//                'id'    => 'first_name',
//                'type'  => 'text',
//                'class' =>  'form-control',
//                'placeholder'=>'First Name',
//                'value' => $this->form_validation->set_value('first_name'),
//            );
//            $this->data['last_name'] = array(
//                'name'  => 'last_name',
//                'id'    => 'last_name',
//                'type'  => 'text',
//                'class' =>  'form-control',
//                'placeholder'=>'Surname',
//                'value' => $this->form_validation->set_value('last_name'),
//            );
//            $this->data['identity'] = array(
//                'name'  => 'identity',
//                'id'    => 'identity',
//                'type'  => 'text',
//                'class' =>  'form-control',
//                'placeholder'=>'Identity',
//                'value' => $this->form_validation->set_value('identity'),
//            );
//            $this->data['email'] = array(
//                'name'  => 'email',
//                'id'    => 'email',
//                'type'  => 'text',
//                'class' =>  'form-control',
//                'placeholder'=>'Email',
//                'value' => $this->form_validation->set_value('email'),
//            );
//            $this->data['company'] = array(
//                'name'  => 'company',
//                'id'    => 'company',
//                'type'  => 'text',
//                'class' =>  'form-control',
//                'placeholder'=>'Company',
//                'value' => $this->form_validation->set_value('company'),
//            );
//            $this->data['phone'] = array(
//                'name'  => 'phone',
//                'id'    => 'phone',
//                'type'  => 'text',
//                'class' =>  'form-control',
//                'placeholder'=>'Phone',
//                'value' => $this->form_validation->set_value('phone'),
//            );
//            $this->data['password'] = array(
//                'name'  => 'password',
//                'id'    => 'password',
//                'type'  => 'password',
//                'class' =>  'form-control',
//                'placeholder'=>'Password',
//                'value' => $this->form_validation->set_value('password'),
//            );
//            $this->data['password_confirm'] = array(
//                'name'  => 'password_confirm',
//                'id'    => 'password_confirm',
//                'type'  => 'password',
//                'class' =>  'form-control',
//                'placeholder'=>'Confirm Password',
//                'value' => $this->form_validation->set_value('password_confirm'),
//            );
//
//            $this->template->title('User Registration')
//            ->build('create_user', $this->data);
        }
    }

    public function register()
    {
        $this->template->set_theme('frontend')
            ->set_layout('login');

        $this->data['title'] = $this->lang->line('create_user_heading');

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
        {
            // redirect('auth', 'refresh');
        }


        $tables = $this->config->item('tables','ion_auth');
        $identity_column = $this->config->item('identity','ion_auth');
        $this->data['identity_column'] = $identity_column;

        // validate form input
        $this->form_validation->set_rules('first_name', $this->lang->line('create_user_validation_fname_label'), 'required');
        $this->form_validation->set_rules('last_name', $this->lang->line('create_user_validation_lname_label'), 'required');
        if($identity_column!=='email')
        {
            $this->form_validation->set_rules('identity',$this->lang->line('create_user_validation_identity_label'),'required|is_unique['.$tables['users'].'.'.$identity_column.']');
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email');
        }
        else
        {
            $this->form_validation->set_rules('email', $this->lang->line('create_user_validation_email_label'), 'required|valid_email|is_unique[' . $tables['users'] . '.email]');
        }
        //$this->form_validation->set_rules('phone', $this->lang->line('create_user_validation_phone_label'), 'trim');
        //$this->form_validation->set_rules('company', $this->lang->line('create_user_validation_company_label'), 'trim');
        $this->form_validation->set_rules('password', $this->lang->line('create_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
        $this->form_validation->set_rules('password_confirm', $this->lang->line('create_user_validation_password_confirm_label'), 'required');


        if ($this->form_validation->run() == true)
        {
            $username=$this->input->post('first_name').'.'.$this->input->post('last_name');
            $username=strtolower($username);
            for($i=0; $i<10; $i++){
                if($i==0){
                    $res=$this->form_validation->is_unique($username,$tables['users'].'.username');
                    if($res!==FALSE){
                        $identity=$username;
                        break;
                    }
                }else{

                    $res=$this->form_validation->is_unique($username.$i,$tables['users'].'.username');
                    if($res!==FALSE){
                        $identity=$username.$i;
                        break;
                    }
                }

            }

            //echo $identity; exit;


            $email    = strtolower($this->input->post('email'));
            //$identity = ($identity_column==='email') ? $email : $this->input->post('identity');
            $password = $this->input->post('password');

            $additional_data = array(
                'first_name' => $this->input->post('first_name'),
                'last_name'  => $this->input->post('last_name'),
                'company'    => '',
                'phone'      => '',
            );
        }
        if ($this->form_validation->run() == true && $this->ion_auth->register($identity, $password, $email, $additional_data))
        {
            // check to see if we are creating the user
            // redirect them back to the admin page
            $this->session->set_flashdata('success',$this->ion_auth->messages());
            redirect('user_login');
            exit;
        }
        else
        {
            // display the create user form
            // set the flash data error message if there is one
            $this->data['message']= (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));


            $this->data['first_name'] = array(
                'name'  => 'first_name',
                'id'    => 'first_name',
                'type'  => 'text',
                'class' =>  'form-control m-input',
                'placeholder'=>'First Name',
                'value' => $this->form_validation->set_value('first_name'),
            );
            $this->data['last_name'] = array(
                'name'  => 'last_name',
                'id'    => 'last_name',
                'type'  => 'text',
                'class' =>  'form-control m-input',
                'placeholder'=>'Surname',
                'value' => $this->form_validation->set_value('last_name'),
            );
            $this->data['identity'] = array(
                'name'  => 'identity',
                'id'    => 'identity',
                'type'  => 'text',
                'class' =>  'form-control m-input',
                'placeholder'=>'Username',
                'value' => $this->form_validation->set_value('identity'),
            );
            $this->data['email'] = array(
                'name'  => 'email',
                'id'    => 'email',
                'type'  => 'text',
                'class' =>  'form-control m-input',
                'placeholder'=>'Email',
                'value' => $this->form_validation->set_value('email'),
            );
//            $this->data['company'] = array(
//                'name'  => 'company',
//                'id'    => 'company',
//                'type'  => 'text',
//                'class' =>  'form-control',
//                'placeholder'=>'Company',
//                'value' => $this->form_validation->set_value('company'),
//            );
            $this->data['phone'] = array(
                'name'  => 'phone',
                'id'    => 'phone',
                'type'  => 'text',
                'class' =>  'form-control m-input',
                'placeholder'=>'Phone',
                'value' => $this->form_validation->set_value('phone'),
            );
            $this->data['password'] = array(
                'name'  => 'password',
                'id'    => 'password',
                'type'  => 'password',
                'class' =>  'form-control m-input',
                'placeholder'=>'Password',
                'value' => $this->form_validation->set_value('password'),
            );
            $this->data['password_confirm'] = array(
                'name'  => 'password_confirm',
                'id'    => 'password_confirm',
                'type'  => 'password',
                'class' =>  'form-control m-input',
                'placeholder'=>'Confirm Password',
                'value' => $this->form_validation->set_value('password_confirm'),
            );

            $this->template->title('User Registration')
                ->build('create_user', $this->data);
        }
    }

    public function edit_user($id)
    {
        
        $this->data['title'] = $this->lang->line('edit_user_heading');

        if (!$this->ion_auth->logged_in() || (!$this->ion_auth->is_admin() && !($this->ion_auth->user()->row()->id == $id)))
        {
            redirect('auth', 'refresh');
            exit;
        }

        $tables = $this->config->item('tables','ion_auth');
        $identity_column = $this->config->item('identity','ion_auth');
        $this->data['identity_column'] = $identity_column;


        $user = $this->ion_auth->user($id)->row();
        $groups=$this->ion_auth->groups()->result_array();
        $currentGroups = $this->ion_auth->get_users_groups($id)->result();

        // validate form input
        if($this->input->post('first_name')){
            $this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'required');
        }

        if($this->input->post('last_name')){
            $this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'required');
        }

        if($this->input->post('phone')){
            $this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), 'required');
        }

        if($this->input->post('alias')){
            $this->form_validation->set_rules('alias', 'Alias', 'required');
        }


        //$this->form_validation->set_rules('company', $this->lang->line('edit_user_validation_company_label'), 'required');

        if (isset($_POST) && !empty($_POST))
        {
            // do we have a valid request?
            if ($this->_valid_csrf_nonce() === FALSE || $id != $this->input->post('id'))
            {
                show_error($this->lang->line('error_csrf'));
            }

            // update the password if it was posted
            if ($this->input->post('password'))
            {
                $this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
                $this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
            }

            if($this->input->post('username')){
                $this->form_validation->set_rules('username', 'username', 'required|min_length[8]|is_unique['.$tables['users'].'.username]');
            }

            if($this->input->post('email') && $user->email != $this->input->post('email')){
                $this->form_validation->set_rules('email', 'email', 'required|is_unique[' . $tables['users'] . '.email]');
            }



            if ($this->form_validation->run() === TRUE)
            {
                $data=array();

                if($this->input->post('first_name')){
                    $data['first_name']=$this->input->post('first_name');
                }
                if($this->input->post('last_name')){
                    $data['last_name']=$this->input->post('last_name');
                }

                if($this->input->post('alias')){
                    $data['alias']=$this->input->post('alias');
                }

                if($this->input->post('phone')){
                    $data['phone']=$this->input->post('phone');
                }

                if($this->input->post('avatar')){
                    $data['avatar'] = $this->input->post('avatar');
                }


                // update the password if it was posted
                if ($this->input->post('password'))
                {
                    $data['password'] = $this->input->post('password');
                }

                if($this->input->post('email') && $user->email != $this->input->post('email')){
                    $data['email']=$this->input->post('email');
                }

                if($this->input->post('username')){
                    $data['username']=$this->input->post('username');
                }


                // Only allow updating groups if user is admin
                if ($this->ion_auth->is_admin())
                {
                    //Update the groups user belongs to
                    $groupData = $this->input->post('groups');

                    if (isset($groupData) && !empty($groupData)) {

                        $this->ion_auth->remove_from_group('', $id);

                        foreach ($groupData as $grp) {
                            $this->ion_auth->add_to_group($grp, $id);
                        }

                    }
                }

                // check to see if we are updating the user
                if($this->ion_auth->update($user->id, $data))
                {
                    // redirect them back to the admin page if admin, or to the base url if non admin
                    $this->session->set_flashdata('message', $this->ion_auth->messages() );
                    if ($this->ion_auth->is_admin())
                    {
                        if($this->input->post('redirect')){
                            redirect($this->input->post('redirect'));
                            exit;
                        }
                        redirect('admin/profile');
                        exit;
                    }
                    else
                    {
                        if($this->input->post('redirect')){
                            redirect($this->input->post('redirect'));
                            exit;
                        }
                        redirect('admin/profile');
                        exit;
                    }

                }
                else
                {
                    // redirect them back to the admin page if admin, or to the base url if non admin
                    $this->session->set_flashdata('message', $this->ion_auth->errors() );
                    if ($this->ion_auth->is_admin())
                    {
                        if($this->input->post('redirect')){
                            redirect($this->input->post('redirect'));
                            exit;
                        }

                    }
                    else
                    {
                        if($this->input->post('redirect')){
                            redirect($this->input->post('redirect'));
                            exit;
                        }
                        redirect('/', 'refresh');
                        exit;
                    }

                }

            }else{
                // display the edit user form
                $this->data['csrf'] = $this->_get_csrf_nonce();

                // set the flash data error message if there is one
                $message = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));
                $this->session->set_flashdata('error',$message);
                redirect('admin/profile');

            }
        }
    }

    public function create_group()
    {
        $this->data['title'] = $this->lang->line('create_group_title');

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
        {
            redirect('auth', 'refresh');
        }

        // validate form input
        $this->form_validation->set_rules('group_name', $this->lang->line('create_group_validation_name_label'), 'required|alpha_dash');

        if ($this->form_validation->run() == TRUE)
        {
            $new_group_id = $this->ion_auth->create_group($this->input->post('group_name'), $this->input->post('description'));
            if($new_group_id)
            {
                // check to see if we are creating the group
                // redirect them back to the admin page
                $this->session->set_flashdata('message', $this->ion_auth->messages());
                redirect("auth", 'refresh');
            }
        }
        else
        {
            // display the create group form
            // set the flash data error message if there is one
            $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

            $this->data['group_name'] = array(
                'name'  => 'group_name',
                'id'    => 'group_name',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('group_name'),
            );
            $this->data['description'] = array(
                'name'  => 'description',
                'id'    => 'description',
                'type'  => 'text',
                'value' => $this->form_validation->set_value('description'),
            );

            $this->_render_page('auth/create_group', $this->data);
        }
    }

    public function edit_group($id)
    {
        // bail if no group id given
        if(!$id || empty($id))
        {
            redirect('auth', 'refresh');
        }

        $this->data['title'] = $this->lang->line('edit_group_title');

        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin())
        {
            redirect('admin/auth', 'refresh');
        }

        $group = $this->ion_auth->group($id)->row();

        // validate form input
        $this->form_validation->set_rules('group_name', $this->lang->line('edit_group_validation_name_label'), 'required|alpha_dash');

        if (isset($_POST) && !empty($_POST))
        {
            if ($this->form_validation->run() === TRUE)
            {
                $group_update = $this->ion_auth->update_group($id, $_POST['group_name'], $_POST['group_description']);

                if($group_update)
                {
                    $this->session->set_flashdata('message', $this->lang->line('edit_group_saved'));
                }
                else
                {
                    $this->session->set_flashdata('message', $this->ion_auth->errors());
                }
                redirect("admin/auth/listUsers", 'refresh');
            }
        }

        // set the flash data error message if there is one
        $this->data['message'] = (validation_errors() ? validation_errors() : ($this->ion_auth->errors() ? $this->ion_auth->errors() : $this->session->flashdata('message')));

        // pass the user to the view
        $this->data['group'] = $group;

        $readonly = $this->config->item('admin_group', 'ion_auth') === $group->name ? 'readonly' : '';

        $this->data['group_name'] = array(
            'name'    => 'group_name',
            'id'      => 'group_name',
            'type'    => 'text',
            'class'     => 'form-control m-input',
            'value'   => $this->form_validation->set_value('group_name', $group->name),
            $readonly => $readonly,
        );
        $this->data['group_description'] = array(
            'name'  => 'group_description',
            'id'    => 'group_description',
            'class'     => 'form-control m-input',
            'type'  => 'text',
            'value' => $this->form_validation->set_value('group_description', $group->description),
        );

        $this->template->title('Edit Group')
            ->build('auth/edit_group', $this->data);
    }


    public function listUsers(){
        // set the flash data error message if there is one
        $this->data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

        //list the users
        $this->data['users'] = $this->ion_auth->users()->result();
        foreach ($this->data['users'] as $k => $user)
        {
            $this->data['users'][$k]->groups = $this->ion_auth->get_users_groups($user->id)->result();
        }

        $this->template
            ->title('Users')
            ->build('auth/index', $this->data);
    }






}
