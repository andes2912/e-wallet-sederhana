

## RESTFULL API sederhana untuk sistem E-Wallet

### Penggunaan di local server
```
git clone https://github.com/andes2912/e-wallet-sederhana
```

```
Run php artisan migrate & php passport::install
```

```
File .env
Setting host email untuk keperluan reset password

MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=yourusername
MAIL_PASSWORD=yourpassword
MAIL_FROM_ADDRESS=email@gmail.com
MAIL_FROM_NAME=Andri
MAIL_ENCRYPTION=tls
```

### Contoh Request

#### Request Login
```
127.0.0.1:8000\api\login

Parameter : 
- email
- password

Method : 
- POST

```

#### Request Register
```
127.0.0.1:8000\api\register

Parameter : 
- name
- email
- password
- password_confirmation

Method : 
- POST

```

#### Request Logout
```
127.0.0.1:8000\api\logout

Headers : 
- Authorzation => Bearer Token

Method : 
- GET
```

#### Request Reset Password
```
127.0.0.1:8000\api\createreset

Parameter : 
- email

Headers
- Authorzation => Bearer Token

Method : 
- POST
```

#### Request Proses Reset Password
```
127.0.0.1:8000\api\reset

Parameter : 
- token
- password
- password_confirmation

Headers
- Authorzation => Bearer Token

Method : 
- POST
```

#### Request Cek Saldo
```
127.0.0.1:8000\api\cek-saldo

Headers : 
- Authorzation => Bearer Token

Method : 
- GET
```

#### Request Tambah Saldo
```
127.0.0.1:8000\api\topup

Parameter : 
- amount
- type_transfer ['VA','Bank']
- jenis_transfer

Headers
- Authorzation => Bearer Token

Method : 
- POST
```

#### Request Lihat Transaksi Pending
```
127.0.0.1:8000\api\show-transaksi\{id} => id transaksi

Headers : 
- Authorzation => Bearer Token

Method : 
- GET
```

#### Request Ubah Status Transaksi
```
127.0.0.1:8000\api\proses-transaksi\{id} => id transaki

Method : 
- POST
```

#### Request Withdraw
```
127.0.0.1:8000\api\withdraw

Parameter : 
- amount
- type_transfer ['VA','Bank']

Headers
- Authorzation => Bearer Token

Method : 
- POST
```

#### Request Kirim Saldo Ke Pengguna
```
127.0.0.1:8000\api\transfer

Parameter : 
- amount
- user_tujuan_id 

Headers
- Authorzation => Bearer Token

Method : 
- POST
```

#### Request Lihat Semua Mutasi
```
127.0.0.1:8000\api\mutasi

Headers : 
- Authorzation => Bearer Token

Method : 
- GET
```

