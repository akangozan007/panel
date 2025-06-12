<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Models\UserModel;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class User extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
 


    public function index()
    {
        $password = '12345678';
        $hash = password_hash($password, PASSWORD_DEFAULT);
        


        $userModel = new UserModel();
        $users = $userModel->findAll();
    
        return $this->respond($hash);
    }

    private $secretKey;

    public function __construct()
    {
        $this->secretKey = getenv('JWT_SECRET_KEY') ?? 'G4n9t1n4j4r47Y0eK3yR4h4s14AmanB4nG3t123456';
    }

    public function login()
    {
        $input = $this->request->getJSON(true); // ambil input JSON sebagai array
    
        // Validasi input minimal
        if (!isset($input['email']) || !isset($input['password'])) {
            return $this->failValidationErrors('Email dan password harus diisi');
        }
    
        $email = $input['email'];
        $passwordInput = $input['password'];
    
        $userModel = new \App\Models\UserModel();
        $user = $userModel->where('email', $email)->first();
    
        if (!$user) {
            return $this->failNotFound('User tidak ditemukan');
        }
    
        // Cek password menggunakan password_verify dengan kolom password_hash
        if (!password_verify($passwordInput, $user['password_hash'])) {
            return $this->fail('Password salah', 401);
        }
        // generate token
        $issuedAt = time();
        $expire = $issuedAt + 3600; // 1 jam
        $fitur = [
            "user"=>"/user",
            "monitoring"=>"/monitor",
            "whatsapp"=>"/panel",
            "web settings"=>"/settings",
        ];
        $userData = [
            $user['id'],
            $user['name'],
            $user['email'],
            $user['role'],
            'endpoint' => 'http://10.11.12.13:8080',
            'sumber' => 'users',
            'iat' => $issuedAt,
            'exp' => $expire,
        ];
        $payload = $userData;
        // memanggl jwt
        $token = JWT::encode($payload, $this->secretKey, 'HS256');

        // Jika berhasil, kamu bisa return data user atau token, contoh:
        return $this->respond([
            'message' => 'Login berhasil',
            'user' => $userData,
            'fitur' => $fitur,
            'Token User'=>$token
        ]);
    }
    
    
    

}
