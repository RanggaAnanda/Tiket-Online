<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>TIKET KONSER</title>
</head>
<body>
        <h3>USERS LIST</h3>
        
        <!-- mengembalikan ke menu, tidak membutuhkan index php maka menggunakan base url -->
        <a href="<?=base_url()?>">HOME</a> 
        <hr>

         <!-- untuk memanggil cukup flashdata -->
    <?=$this->session->flashdata('msg')?> 

            <a href="<?=site_url('users/add')?>">Add New User</a>
        

<table border="1">
    <thead>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Username</th>
                    <th>Fullname</th>
                    <th>Password</th>
                    <th colspan="3">Action</th>
                </tr>
            </thead>
            <tbody>

        <?php $i=1; foreach ($users as $user) { ?>
    
            <tr>
                        <td><?=$i++?></td>
                        <td><?=$user->username?></td>
                        <td><?=$user->fullname?></td>
                        <td><?=$user->password?></td>
                        <td>
                            <a href="<?=site_url('users/edit/'.$user->userid)?>">Edit</a>
                        </td>
                        <td>
                            <a href="<?=site_url('users/delete/'.$user->userid)?>" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                        <td>
                            <a href="<?=site_url('auth/resetpass/'.$user->username)?>" onclick="return confirm('Are you sure?')">Reset Password</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>