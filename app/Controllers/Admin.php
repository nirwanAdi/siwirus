<?php

namespace App\Controllers;

use \Myth\Auth\Models\UserModel;
use \Myth\Auth\Authorization\GroupModel;
use App\Models\DataPengurusModel;
use Config\Services;

class Admin extends BaseController
{


    protected $db, $builder;

    public function __construct()
    {
        $this->db      = \Config\Database::connect();
        $this->builder = $this->db->table('users');
    }

    public function index()
    {
        $userModel = new UserModel();
        $data['users'] = $userModel->findAll();

        $groupModel = new GroupModel();

        foreach ($data['users'] as $row) {
            $dataRow['group'] = $groupModel->getGroupsForUser($row->id);
            $dataRow['row'] = $row;
            $data['row' . $row->id] = view('admin/row', $dataRow);
        }

        $data['groups'] = $groupModel->findAll();

        $data['title'] = 'Users';
        return view('admin/index', $data);
    }

    public function detail($id = 0)
    {
        $data['title'] = 'User Detail';
        // $users = new \myth\auth\Models\UserModel();
        // $data['users'] = $users->findAll();

        $this->builder->select('users.id as userid, username, email, fullname, user_image, name');
        $this->builder->join('auth_groups_users', 'auth_groups_users.user_id = users.id');
        $this->builder->join('auth_groups', 'auth_groups.id = auth_groups_users.group_id');
        $this->builder->where('users.id', $id);
        $query = $this->builder->get();
        $data['user'] = $query->getRow();

        if (empty($data['user'])) {
            return redirect()->to('/admin');
        }

        return view('admin/detail', $data, ['config' => config('auth')]);
    }

    public function changeGroup()
    {
        $userId = $this->request->getVar('id');
        $groupId = $this->request->getVar('group');

        $groupModel = new GroupModel();
        $groupModel->removeUserFromAllGroups(intval($userId));

        $groupModel->addUserToGroup(intval($userId), intval($groupId));

        return redirect()->to(base_url('/admin/index'));
    }

    public function pengurus()
    {
        $data = [
            'title' => 'Management Pengurus'
        ];
        return view('/admin/pengurus/index', $data);
    }

    public function dataDetail()
    {
        $username = $this->request->getPost('username');

        $pengurus = $this->db->table('pengurus');
        $queryTampil = $pengurus->select('id_pengurus as id, id_user, username, fullname, name, poin')->join('auth_groups_users', 'id_user=user_id')->join('users', 'auth_groups_users.user_id=users.id')->join('auth_groups', 'auth_groups_users.group_id=auth_groups.id')->orderBy('poin', 'asc');

        $data = [
            'datadetail' => $queryTampil->get()
        ];
        $msg = [
            'data' => view('admin/pengurus/viewdetail', $data)
        ];
        echo json_encode($msg);
    }
    public function viewDataPengurus()
    {
        if ($this->request->isAJAX()) {
            $keyword = $this->request->getPost('keyword');
            $data = [
                'keyword' => $keyword
            ];
            $msg = [
                'viewmodal' => view('admin/pengurus/viewmodalcaripengurus', $data)
            ];
            echo json_encode($msg);
        };
    }

    public function listDataPengurus()
    {
        if ($this->request->isAJAX()) {
            $keywordkode = $this->request->getPost('keywordkode');
            $request = Services::request();
            $dataPengurusModel = new DataPengurusModel($request);
            if ($request->getMethod(true) === 'POST') {
                $lists = $dataPengurusModel->getDatatables($keywordkode);
                $data = [];
                $no = $request->getPost("start");
                foreach ($lists as $list) {
                    $no++;
                    $row = [];
                    $row[] = $no;
                    $row[] = $list->user_id;
                    $row[] = $list->username;
                    $row[] = $list->fullname;
                    $row[] = $list->email;
                    $row[] = $list->name;
                    $row[] = "<button type=\"button\" class=\"btn btn-sm btn-primary\" onclick=\"pilihitem('" . $list->user_id . "','" . $list->username . "','" . $list->fullname . "','" . $list->name . "')\">Pilih</button>";
                    $data[] = $row;
                }
                $output = [
                    "draw" => $request->getPost('draw'),
                    "recordTotals" => $dataPengurusModel->countAll($keywordkode),
                    "data" => $data
                ];
                echo json_encode($output);
            }
        }
    }

    public function simpanPengurus()
    {
        if ($this->request->isAJAX()) {
            $username = $this->request->getPost('username');
            $fullname = $this->request->getPost('fullname');
            $userid = $this->request->getPost('id_user');

            if (strlen($userid) > 0) {
                $queryCekPengurus = $this->db->table('users')->where('username', $username)->get();
            } else {
                $queryCekPengurus = $this->db->table('users')->like('username', $username)->orLike('fullname', $fullname)->get();
            }

            $totalData = $queryCekPengurus->getNumRows();
            if ($totalData > 1) {
                $msg = [
                    'totaldata' => 'banyak'
                ];
            } else if ($totalData == 1) {
                $tblPengurus = $this->db->table('Pengurus');
                $inserData = [
                    'id_user' => $userid,
                ];
                $tblPengurus->insert($inserData);

                $msg = ['sukses' => 'berhasil'];
            } else {
                $msg = ['error' => 'Username tidak ada'];
            }
            echo json_encode($msg);
        }
    }

    public function hapusPengurus()
    {
        if ($this->request->isAJAX()) {
            $id = $this->request->getPost('id');
            $tblPengurus = $this->db->table('pengurus');
            $queryHapus =  $tblPengurus->delete(['id_pengurus' => $id]);

            if ($queryHapus) {
                $msg = [
                    'sukses' => 'berhasil'
                ];

                echo json_encode($msg);
            }
        }
    }
}
