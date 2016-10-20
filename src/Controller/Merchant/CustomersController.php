<?php

namespace App\Controller\Merchant;

use Cake\Network\Exception\UnauthorizedException;
use App\Controller\AppController;
use Cake\Event\Event;

class CustomersController extends AppController {

    public function initialize() {
        parent::initialize();


        $this->loadComponent('Custom');
        $this->loadModel('Users');
        $this->loadModel('CustomerGroups');
    }

    public function beforeFilter(Event $event) {
        $this->viewBuilder()->layout('merchant');
        $this->Auth->allow(['login']);
        $action = $this->request->params['action'];
        if (!in_array($action, ['login'])) {
            if (!$this->Auth->user('id')) {
                return $this->redirect(HTTP_ROOT);
            } else if ($this->Auth->user('type') != 3) {
                throw new UnauthorizedException;
            }
        }
    }

    public function ajaxChangePasssword() {
        $data = $this->request->data;
        if (empty($data['old_password'])) {
            echo json_encode(['status' => 'error', 'msg' => 'Please enter current password.']);
        } else if (empty($data['password1'])) {
            echo json_encode(['status' => 'error', 'msg' => 'Please enter new password']);
        } else if (strlen($data['password1']) < 6) {
            echo json_encode(['status' => 'error', 'msg' => 'Password length must be greated that 5 character.']);
        } else if ($data['password1'] != $data['password2']) {
            echo json_encode(['status' => 'error', 'msg' => 'Password & Retype Password does\'t  match.']);
        } else {
            $user = $this->Users->get($this->Auth->user('id'));
            $user = $this->Users->patchEntity($user, ['old_password' => $data['old_password'], 'password' => $data['password1'], 'password1' => $data['password1'], 'password2' => $data['password2']], ['validate' => 'password']);
            if ($this->Users->save($user)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error', 'msg' => 'Current password is not correct.']);
            }
        }
        exit;
    }

    public function ajaxFetchCustomerGroups() {
        $this->viewBuilder()->layout('ajax');
        $customergroups = $this->CustomerGroups->find('all')->where(['CustomerGroups.merchant_id' => $this->Auth->user('id')]);
        if ($customergroups->count() > 0) {
            echo json_encode(['status' => "success", 'groups' => $customergroups]);
        } else {
            echo json_encode(['status' => "error"]);
        }
        exit;
    }

    public function ajaxAddGroup() {
        $this->viewBuilder()->layout('ajax');

        if ($this->request->is(['post'])) {
            $data = $this->request->data;
            $group = $this->CustomerGroups->newEntity();
            $group = $this->CustomerGroups->patchEntity($group, $data);

            $group->merchant_id = $this->Auth->user('id');
            $group->created = date("Y-m-d H:i:s");

            if ($this->CustomerGroups->save($group)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error']);
            }
        } else {
            echo json_encode(['status' => 'error']);
        }
        exit;
    }

    public function ajaxEditGroup($id = null) {
        $this->viewBuilder()->layout('ajax');
        $id = $_REQUEST['id'];
        if ($this->request->is(['post'])) {
            $data = $this->request->data;
            if (!empty($id)) {
                $name = $this->CustomerGroups->get($id);
                $name = $this->CustomerGroups->patchEntity($name, $data['group']);
                $name->modified = date("Y-m-d H:i:s");
            }
            if ($this->CustomerGroups->save($name)) {
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error']);
            }
        } else {
            echo json_encode(['status' => 'group', 'name' => $name]);
        }
        exit;
    }

    public function ajaxFetchGroupDetails($id = null) {
        $this->viewBuilder()->layout('ajax');
        $query = $this->CustomerGroups->find()->select(['name'])->where(['id' => $id]);
        if ($query->count() > 0) {
            $group = $query->first()->toArray();
            echo json_encode(['status' => 'success', 'data' => $group]);
        } else {
            echo json_encode(['status' => 'error']);
        }

        exit;
    }

    public function ajaxGroupActive($id = null) {
        $this->viewBuilder()->layout('ajax');
        $id = $_REQUEST['id'];
        $customergroups = $this->CustomerGroups->get($id);
        $customergroups->is_active = 0;
        if ($this->CustomerGroups->save($customergroups)) {
            $customergroups = $this->CustomerGroups->find('all')->where(['CustomerGroups.merchant_id' => $this->Auth->user('id')]);
            if ($customergroups->count() > 0) {
                echo json_encode(['status' => "success", 'groups' => $customergroups]);
            } else {
                echo json_encode(['status' => "error"]);
            }
            exit;
        }
        exit;
    }

    public function ajaxGroupInctive($id = null) {
        $this->viewBuilder()->layout('ajax');
        $id = $_REQUEST['id'];
        $customergroups = $this->CustomerGroups->get($id);
        $customergroups->is_active = 1;
        if ($this->CustomerGroups->save($customergroups)) {
            $customergroups = $this->CustomerGroups->find('all')->where(['CustomerGroups.merchant_id' => $this->Auth->user('id')]);
            if ($customergroups->count() > 0) {
                echo json_encode(['status' => "success", 'groups' => $customergroups]);
            } else {
                echo json_encode(['status' => "error"]);
            }
            exit;
        }
        exit;
    }

    public function ajaxGroupDelete($id = null) {
        $this->viewBuilder()->layout('ajax');
        $id = $_REQUEST['id'];

        $customergroups = $this->CustomerGroups->deleteAll(['id' => $id]);
        $customergroups = $this->CustomerGroups->find('all')->where(['CustomerGroups.merchant_id' => $this->Auth->user('id')]);
        if ($customergroups->count() > 0) {
            echo json_encode(['status' => "success", 'groups' => $customergroups]);
        } else {
            echo json_encode(['status' => "error"]);
        }
        exit;
    }

    public function ajaxFetchCustomers() {
        $this->viewBuilder()->layout('ajax');
        $customers = $this->Customers->find('all')->where(['Customers.merchant_id' => $this->Auth->user('id')])->contain(['CustomerGroups']);
        if ($customers->count() > 0) {
            echo json_encode(['status' => "success", 'customers' => $customers]);
        } else {
            echo json_encode(['status' => "error"]);
        }
        exit;
    }

    public function ajaxMyCustomerSearch() {
        $this->viewBuilder()->layout('ajax');
        $data = $this->request->data();
        $customers = $this->Customers->find('all')->where(['Customers.merchant_id' => $this->Auth->user('id')])->contain(['CustomerGroups']);
        if ($customers->count() > 0) {
            echo json_encode(['status' => "success", 'customers' => $customers]);
        } else {
            echo json_encode(['status' => "error"]);
        }
        exit;
    }

    public function paymentSetting() {
        
    }

    public function ajaxgetDropdownList() {
        $this->viewBuilder()->layout('ajax');
        $groups = $this->CustomerGroups->find()->select(['id', 'name']);
        if ($groups->count() > 0) {
            echo json_encode(['status' => "success", 'groups' => $groups]);
        } else {
            echo json_encode(['status' => "error"]);
        }
        exit;
    }

    public function ajaxActive($id = null) {
        $this->viewBuilder()->layout('ajax');
        $id = $_REQUEST['id'];
        $customer = $this->Customers->get($id);
        $customer->is_active = 0;
        if ($this->Customers->save($customer)) {
            $customers = $this->Customers->find('all')->where(['Customers.merchant_id' => $this->Auth->user('id')])->contain(['CustomerGroups']);
            if ($customers->count() > 0) {
                echo json_encode(['status' => "success", 'customers' => $customers]);
            } else {
                echo json_encode(['status' => "error"]);
            }
            exit;
        }
        exit;
    }

    public function ajaxInactive($id = null) {
        $this->viewBuilder()->layout('ajax');
        $id = $_REQUEST['id'];
        $customer = $this->Customers->get($id);
        $customer->is_active = 1;
        if ($this->Customers->save($customer)) {
            $customers = $this->Customers->find('all')->where(['Customers.merchant_id' => $this->Auth->user('id')])->contain(['CustomerGroups']);
            if ($customers->count() > 0) {
                echo json_encode(['status' => "success", 'customers' => $customers]);
            } else {
                echo json_encode(['status' => "error"]);
            }
            exit;
        }
        exit;
    }

    public function ajaxFetchDetails($id = null) {
        $this->viewBuilder()->layout('ajax');
        $query = $this->Customers->find('all')->where(['id' => $id]);
        $userId = $this->Customers->find()->select(['user_id'])->where(['id' => $id]);
        $user = $this->Users->find('all')->where(['id' => $userId]);
        if ($query->count() > 0 && $user->count() > 0) {
            $customer = $query->first()->toArray();
            $user = $user->first()->toArray();
            echo json_encode(['status' => 'success', 'data' => $customer, 'userdata' => $user]);
        } else {
            echo json_encode(['status' => 'error']);
        }

        exit;
    }

    public function ajaxDelete($id = null) {
        $this->viewBuilder()->layout('ajax');
        $id = $_REQUEST['id'];
        $user = $this->Users->get($id);
        $customers = $this->Customers->deleteAll(['user_id' => $id]);
        if ($this->Users->delete($user) && $customers) {
            $customers = $this->Customers->find('all')->where(['Customers.merchant_id' => $this->Auth->user('id')])->contain(['CustomerGroups']);
            if ($customers->count() > 0) {
                echo json_encode(['status' => "success", 'customers' => $customers]);
            } else {
                echo json_encode(['status' => "error"]);
            }
            exit;
        }
        exit;
    }

    public function ajaxAddCustomer() {
        $this->viewBuilder()->layout('ajax');

        if ($this->request->is(['post'])) {
            $data = $this->request->data;

            $user = $this->Users->newEntity();
            $user = $this->Users->patchEntity($user, $data['user']);
            $user->type = 4;
            if ($this->Users->save($user)) {
                $customer = $this->Customers->newEntity();
                $customer = $this->Customers->patchEntity($customer, $data['customer']);
                $customer->user_id = $user->id;
                $customer->merchant_id = $this->Auth->user('id');
                $this->Customers->save($customer);
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error']);
            }
        } else {
            echo json_encode(['status' => 'group', 'groupname' => $groupname]);
        }
        exit;
    }

    public function importCustomer() {
        $this->viewBuilder()->layout('ajax');

        if ($this->request->is('post')) {
            $data = $this->request->data;
            $ext = pathinfo($data["file"]["name"], PATHINFO_EXTENSION);
            if (empty($data["file"]["name"])) {
                $this->Flash->error(__('Please select file for import.'));
            } else if (!in_array($ext, ['xls', 'xlsx'])) {
                $this->Flash->error(__('Please select excel file only.'));
            } else {

                $targetDir = "temp_excel/";
                $targetFile = $targetDir . time() . "_" . basename($data["file"]["name"]);
                move_uploaded_file($data["file"]["tmp_name"], $targetFile);
                require_once(ROOT . DS . 'vendor' . DS . 'phpexcel' . DS . 'index.php');
                $customerArray = getExcelContents($targetFile);

                foreach ($customerArray as $customerData) {
                    $user = $this->Users->newEntity();
                    $user->type = 4;
                    $user->email = $customerData[1];




                    if ($this->Users->save($user)) {
                        $customer = $this->Customers->newEntity();
                        $customer->customer_group_id = $data['group_id'];
                        $customer->merchant_id = $this->Auth->user('id');
                        $customer->user_id = $user->id;
                        $customer->name = $customerData[0];
                        $customer->phone = $customerData[2];
                        $customer->address = $customerData[3];
                        $customer->fee = $customerData[4];
                        $customer->duedate = $customerData[5];
                        $customer = $this->Customers->save($customer);
                    }

                    $to = $user->email;                    
                    $from = "abc@gmail.com";
                    $subject = "Welcome to our community";
                    $message = "Dear $customerData[0],<br><br>This mail is to notify that your account has been register successfuly with the following details <br> check below details for sure<br><br>Email: $user->email<br>Name: $customerData[0]<br>Phone: $customerData[2] <br>Address: $customerData[3] <br><br>Best regards<br>Team";
                    $this->Custom->sendEmail($to, $from, $subject, $message);                   
                }
                unlink($targetFile);
                $this->Flash->success(__("Customers are imported successfully."));
                return $this->redirect(HTTP_ROOT . "merchant/#/my-customers");
            }
        }
        return $this->redirect($this->referer());
    }

    public function ajaxEditCustomer($id = null) {
        $this->viewBuilder()->layout('ajax');
        $id = $_REQUEST['id'];
        if ($this->request->is(['post'])) {
            $data = $this->request->data;
            if (!empty($id)) {
                $customer = $this->Customers->get($id);
            }
            $userId = $customer->user_id;
            $user = $this->Users->get($userId);
            $user = $this->Users->patchEntity($user, $data['user']);
            $user->type = 4;
            if ($this->Users->save($user)) {
                $customer = $this->Customers->patchEntity($customer, $data['customer']);
                $this->Customers->save($customer);
                echo json_encode(['status' => 'success']);
            } else {
                echo json_encode(['status' => 'error']);
            }
        } else {
            echo json_encode(['status' => 'group', 'groupname' => $groupname]);
        }
        exit;
    }

}
