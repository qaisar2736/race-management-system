<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\UserModel;
helper('controller');

class Home extends BaseController
{
    public function __construct()
    {
      $this->db = \Config\Database::connect();
    }

    public function qaisar()
    {
      return 'home qaisar';
    }

    public function index()
    {
      return redirect()->to(base_url('user'));
    }

    public function login()
    {
        if ($this->request->is('post')) {
            $email = clean_input($_POST['email']);
            $password = clean_input($_POST['password']);
            
            $model = new UserModel();
            $user = $model->where(['email' => $email])->first();
            // var_dump($password, $user['password'], password_verify($password, $user["password"]));exit;
            if (empty($user)) {
                session()->setFlashData("error","Wrong email or password!");
                return redirect()->to(base_url("login"));
            } else if (!password_verify($password, $user["password"])) {
                session()->setFlashData("error","Wrong email or password!");
                return redirect()->to(base_url("login"));
            } else if ($user['email_verified'] == 0) {
                session()->setFlashData("error","Verify your email first!");
                return redirect()->to(base_url("login"));
            } else {
                $this->session->set('id', $user['id']);
                $this->session->set('email', $user['email']);
                $this->session->set('account_type', $user['account_type']);

                if ($user['account_type'] == 'admin') {
                  return redirect()->to(base_url("/organizer"));
                } else  if ($user['account_type'] == 'organizer') {
                  return redirect()->to(base_url("/organizer"));
                } else if ($user['account_type'] == 'participant') {
                  return redirect()->to(base_url('/'));
                }

                // return redirect()->to(base_url("/"));
            }

        } else {
            // GET REQUEST
            if ($this->session->has('id')) {
                return redirect()->to(base_url("/"));
            } else {
                return view('login');
            }
            
        }
    }

    public function register()
    {
        if ($this->request->is('post')) {

            $name = clean_input($this->request->getPost('name'));
            $surname = clean_input($this->request->getPost('surname'));
            $mobile_number = clean_input($this->request->getPost('mobile_number'));
            $email = clean_input($this->request->getPost('email'));
            $password = clean_input($this->request->getPost('password'));
            $confirm_password = clean_input($this->request->getPost('confirm_password'));
            $account_type = clean_input($this->request->getPost('account_type'));
            $email_confirmation_code = generateRandomString(8);
            $cofirm_email_link = base_url('confirm_email?code='.$email_confirmation_code);

            $model = new UserModel();
            $previous_user = $model->where(['email' => $email])->first();

            if (!empty($previous_user)) {

                session()->setFlashData("error","Email in use!");
                return redirect()->to(base_url("register"));

            } else {
                $newUser = Array(
                    'name' => $name,
                    'surname' => $surname,
                    'mobile_number' => $mobile_number,
                    'email' => $email,
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'account_type' => $account_type,
                    'email_confirmation_code' => $email_confirmation_code,
                    'email_verified' => 1
                );

                $email_template = '
                <!doctype html>
                <html>
                  <head>
                    <meta name="viewport" content="width=device-width">
                    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                    <title>Simple Transactional Email</title>
                    
                  </head>
                  <body class="" style="background-color: #f6f6f6;font-family: sans-serif;-webkit-font-smoothing: antialiased;font-size: 14px;line-height: 1.4;margin: 0;padding: 0;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                    <table border="0" cellpadding="0" cellspacing="0" class="body" style="border-collapse: separate;mso-table-lspace: 0pt;mso-table-rspace: 0pt;width: 100%;background-color: #f6f6f6;">
                      <tr>
                        <td style="font-family: sans-serif;font-size: 16px !important;vertical-align: top;">&nbsp;</td>
                        <td class="container" style="font-family: sans-serif;font-size: 16px !important;vertical-align: top;display: block;max-width: 580px;padding: 0 !important;width: 100% !important;margin: 0 auto !important;">
                          <div class="content" style="box-sizing: border-box;display: block;margin: 0 auto;max-width: 580px;padding: 0 !important;">
                            <span class="preheader" style="color: transparent;display: none;height: 0;max-height: 0;max-width: 0;opacity: 0;overflow: hidden;mso-hide: all;visibility: hidden;width: 0;font-size: 16px !important;">Subscribe to Coloured.com.ng mailing list</span>
                            <table class="main" style="border-collapse: separate;mso-table-lspace: 0pt;mso-table-rspace: 0pt;width: 100%;background: #fff;border-radius: 0 !important;border-left-width: 0 !important;border-right-width: 0 !important;">
                
                              
                              <tr>
                                <td class="wrapper" style="font-family: sans-serif;font-size: 16px !important;vertical-align: top;box-sizing: border-box;padding: 10px !important;">
                                  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate;mso-table-lspace: 0pt;mso-table-rspace: 0pt;width: 100%;">
                                    <tr>
                                      <td style="font-family: sans-serif;font-size: 16px !important;vertical-align: top;">
                                        <h1 style="color: #000000;font-family: sans-serif;font-weight: 300;line-height: 1.4;margin: 0;margin-bottom: 30px;font-size: 35px;text-align: center;text-transform: capitalize;">Confirm your email</h1>
                                        <h2 style="color: #000000;font-family: sans-serif;font-weight: 400;line-height: 1.4;margin: 0;margin-bottom: 30px;">You are just one step away</h2>
                                        <table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary" style="border-collapse: separate;mso-table-lspace: 0pt;mso-table-rspace: 0pt;width: 100%;box-sizing: border-box;">
                                          <tbody>
                                            <tr>
                                              <td align="left" style="font-family: sans-serif;font-size: 16px !important;vertical-align: top;padding-bottom: 15px;">
                                                <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate;mso-table-lspace: 0pt;mso-table-rspace: 0pt;width: 100% !important;">
                                                  <tbody>
                                                    <tr>
                                                      <td style="font-family: sans-serif;font-size: 16px !important;vertical-align: top;background-color: #3498db;border-radius: 5px;text-align: center;"> <a href="'.$cofirm_email_link.'" target="_blank" style="color: #ffffff;text-decoration: none;background-color: #3498db;border: solid 1px #3498db;border-radius: 5px;box-sizing: border-box;cursor: pointer;display: inline-block;font-size: 16px !important;font-weight: bold;margin: 0;padding: 12px 25px;text-transform: capitalize;border-color: #3498db;width: 100% !important;">confirm email</a> </td>
                                                    </tr>
                                                  </tbody>
                                                </table>
                                              </td>
                                            </tr>
                                          </tbody>
                                        </table>
                                        <p style="font-family: sans-serif;font-size: 16px !important;font-weight: normal;margin: 0;margin-bottom: 15px;">If you received this email by mistake, simply delete it. You won\t be subscribed if you don\t click the confirmation link above.</p>
                      
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                
                            
                            </table>
                
                            
                            
                            
                            
                          
                          </div>
                        </td>
                        <td style="font-family: sans-serif;font-size: 16px !important;vertical-align: top;">&nbsp;</td>
                      </tr>
                    </table>
                  </body>
                </html>';
                // echo $email_template;exit;
                $model->insert($newUser);
                // send_email($email, 'Confirm Email', $email_template);
                // session()->setFlashData("success","Email sent for confirmation");
                // return redirect()->to(base_url("register"));

                return redirect()->to(base_url('login'))->with('success', 'You can login now');
            }
        } else {
            // GET REQUEST
            if ($this->session->has('id')) {
                return redirect()->to(base_url("/"));
            } else {
                return view('register');
            }
        }
    }

    public function confirm_email()
    {
        if ($this->request->getGet('code')) {
            $code = clean_input($this->request->getGet('code'));
            $model = new UserModel();
            $user_account = $model->where(['email_confirmation_code' => $code])->first();

            if (empty($user_account)) {
                return redirect()->to(base_url("login"));
            } else {
                $update_data = Array(
                    "email_confirmation_code" => '',
                    "email_verified" => 1
                );
                $model->update($user_account["id"], $update_data);
                session()->setFlashData("success","Email confirmed. Now you can login");
                return redirect()->to(base_url("login"));
            }
        } else {
            return redirect()->to(base_url("login"));
        }
    }

    public function forgot_password()
    {
        if ($this->request->getPost('forgot_password')) {
            $email = clean_input($this->request->getPost('email'));
            $model = new UserModel();
            $user_account = $model->where(['email' => $email])->first();

            if (!empty($user_account)) {
                $new_password_code = generateRandomString(8);
                $update_data = Array(
                    "forgot_password_code" => $new_password_code
                );
                $model->update($user_account["id"], $update_data);
                $new_password_link = base_url('new_password?code=' . $new_password_code);
                $email_template = '
                <!doctype html>
                <html>
                  <head>
                    <meta name="viewport" content="width=device-width">
                    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
                    <title>Simple Transactional Email</title>
                    
                  </head>
                  <body class="" style="background-color: #f6f6f6;font-family: sans-serif;-webkit-font-smoothing: antialiased;font-size: 14px;line-height: 1.4;margin: 0;padding: 0;-ms-text-size-adjust: 100%;-webkit-text-size-adjust: 100%;">
                    <table border="0" cellpadding="0" cellspacing="0" class="body" style="border-collapse: separate;mso-table-lspace: 0pt;mso-table-rspace: 0pt;width: 100%;background-color: #f6f6f6;">
                      <tr>
                        <td style="font-family: sans-serif;font-size: 16px !important;vertical-align: top;">&nbsp;</td>
                        <td class="container" style="font-family: sans-serif;font-size: 16px !important;vertical-align: top;display: block;max-width: 580px;padding: 0 !important;width: 100% !important;margin: 0 auto !important;">
                          <div class="content" style="box-sizing: border-box;display: block;margin: 0 auto;max-width: 580px;padding: 0 !important;">
                            <span class="preheader" style="color: transparent;display: none;height: 0;max-height: 0;max-width: 0;opacity: 0;overflow: hidden;mso-hide: all;visibility: hidden;width: 0;font-size: 16px !important;">Subscribe to Coloured.com.ng mailing list</span>
                            <table class="main" style="border-collapse: separate;mso-table-lspace: 0pt;mso-table-rspace: 0pt;width: 100%;background: #fff;border-radius: 0 !important;border-left-width: 0 !important;border-right-width: 0 !important;">
                
                              
                              <tr>
                                <td class="wrapper" style="font-family: sans-serif;font-size: 16px !important;vertical-align: top;box-sizing: border-box;padding: 10px !important;">
                                  <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate;mso-table-lspace: 0pt;mso-table-rspace: 0pt;width: 100%;">
                                    <tr>
                                      <td style="font-family: sans-serif;font-size: 16px !important;vertical-align: top;">
                                        <h1 style="color: #000000;font-family: sans-serif;font-weight: 300;line-height: 1.4;margin: 0;margin-bottom: 30px;font-size: 35px;text-align: center;text-transform: capitalize;">Create new password</h1>
                                        <h2 style="color: #000000;font-family: sans-serif;font-weight: 400;line-height: 1.4;margin: 0;margin-bottom: 30px;">You are just one step away</h2>
                                        <table border="0" cellpadding="0" cellspacing="0" class="btn btn-primary" style="border-collapse: separate;mso-table-lspace: 0pt;mso-table-rspace: 0pt;width: 100%;box-sizing: border-box;">
                                          <tbody>
                                            <tr>
                                              <td align="left" style="font-family: sans-serif;font-size: 16px !important;vertical-align: top;padding-bottom: 15px;">
                                                <table border="0" cellpadding="0" cellspacing="0" style="border-collapse: separate;mso-table-lspace: 0pt;mso-table-rspace: 0pt;width: 100% !important;">
                                                  <tbody>
                                                    <tr>
                                                      <td style="font-family: sans-serif;font-size: 16px !important;vertical-align: top;background-color: #3498db;border-radius: 5px;text-align: center;"> <a href="'.$new_password_link.'" target="_blank" style="color: #ffffff;text-decoration: none;background-color: #3498db;border: solid 1px #3498db;border-radius: 5px;box-sizing: border-box;cursor: pointer;display: inline-block;font-size: 16px !important;font-weight: bold;margin: 0;padding: 12px 25px;text-transform: capitalize;border-color: #3498db;width: 100% !important;">Click Here</a> </td>
                                                    </tr>
                                                  </tbody>
                                                </table>
                                              </td>
                                            </tr>
                                          </tbody>
                                        </table>
                                        <p style="font-family: sans-serif;font-size: 16px !important;font-weight: normal;margin: 0;margin-bottom: 15px;">If you received this email by mistake, simply delete it. You won\t be subscribed if you don\t click the confirmation link above.</p>
                      
                                      </td>
                                    </tr>
                                  </table>
                                </td>
                              </tr>
                
                            
                            </table>
                
                            
                            
                            
                            
                          
                          </div>
                        </td>
                        <td style="font-family: sans-serif;font-size: 16px !important;vertical-align: top;">&nbsp;</td>
                      </tr>
                    </table>
                  </body>
                </html>';
                send_email($user_account['email'], 'Create New Password', $email_template);

                return $this->response->setJSON([ "email_sent" => true ]);
            } else {
                return $this->response->setJson(["not_found" => true]);
            }
        } else {
            // return view('forgot_password');
        }
    }

    public function new_password()
    {
        if ($this->request->getPost('new_password') && ($this->session->has('newpassword_user_id'))) {
            $user_id = $this->session->get('newpassword_user_id');
            $new_password = clean_input($this->request->getPost('new_password'));
            $new_password = password_hash($new_password, PASSWORD_DEFAULT);
            $model = new UserModel();
            $model->update(['id' => $user_id], [
                'password' => $new_password,
                'forgot_password_code' => ''
                ]);
            $this->session->remove(['newpassword_user_id']);
            session()->setFlashData("success","Password updated successfully");
            return redirect()->to(base_url("login"));
        } else if ($this->request->getGet('code')) {
            $code = clean_input($this->request->getGet('code'));
            $model = new UserModel();
            $user_account = $model->where(['forgot_password_code' => $code])->first();

            if (!empty($user_account)) {
                $this->session->set("newpassword_user_id", $user_account['id']);
                return view('new_password');
            } else {
                return redirect()->to(base_url());
            }
            
        } else {
            return redirect()->to(base_url('/'));
        }
    }

    public function logout()
    {
        $session_items = ['id', 'email', 'account_type'];
        $this->session->remove($session_items);
        return redirect()->to(base_url("/"));
    }

    public function test()
    {
        send_email('qaisark787@gmail.com', 'Congratulations', '<h1>hello world</h1><pre>php </pre>');
    }
}
